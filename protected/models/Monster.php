<?php

Yii::import('application.models._base.BaseMonster');
Yii::import('application.components.monsters.*');

/**
 * Simulates monsters during battles
 * 
 * See BaseMonster for a list of attributes and related Models.
 * 
 * @uses CombatantBehavior
 * @uses SpecialnessBehavior
 * @package Battle
 */

class Monster extends BaseMonster {

    /**
     * Temporary values. set to attribute hpMax at the beginning of a battle
     * @var int
     */
    public $hp;

    /**
     * Just in case a Monster uses a Battleskill with costEnergy > 0
     * @var int
     */
    public $energy;
    
    /**
     * Future AI can refer to the current battle state
     * @todo ask for Lottery as parameter to enable dependency injection
     * @uses Lottery
     * @param Battle $battle
     * @return Skill
     * @todo check if the skill can actually be used
     */
    public function act($battle) {
        $l = new Lottery();
        $l->addParticipants($this->monsterBattleskills);
        $winner = $l->getWinner();

        if($winner == false) {
            // Use the Pracrastinate skill, which does nothing
            return Battleskill::model()->findByPk(1);
        }
        /**
         * Remember that the winner is not the battleskill, but a 
         * MonsterBattleskills AR entry
         */
        return $winner->battleskill;
    }
    
    /**
     * Returns how much damage the Monster actually suffered
     * @uses onBeforeTakeDamage
     * @uses onAfterTakenDamage
     * @uses CombatantTakeDamageEvent
     * @uses CombatnatTakenDamageEvent
     * @param int $damage, how much damage the Monster is to take
     * @param string $damageType enum(normal|vices)
     * @return int 
     */
    public function takeDamage($damage, $damageType) {
        // TakeDamageEvent, collect bonuses
        $event = new CombatantTakeDamageEvent($this, $damage, $damageType);
        $this->onBeforeTakeDamage($event);
        
        $damageAdjusted = floor($event->adjustStat($damage));
        $damageAdjusted = max($damageAdjusted, 0);
        
        $this->decreaseHp($damageAdjusted);

        // takeN damage event, notification only
        $event = new CombatantTakenDamageEvent($this, $damageAdjusted, $damageType);
        $this->onAfterTakenDamage($event);
        
        return $damageAdjusted;
    }
    
    /**
     * Decides for each potential item drop whether it is indeed dropped or not
     * dropItemPerc are percentage point increasers/decreasers as usual
     * @param int $dropItemPerc bonus to the drop rate
     * @return array of Item records
     */
    public function dropItems($dropItemPerc = 0) {
        $loot = array();
        foreach($this->monsterItems as $monsterItem) {
            $prob = max(0, min(1, $monsterItem->prob + ($dropItemPerc / 100)));
            $rand = mt_rand(0, 1000000);
            if($rand <= $prob * 1000000) {
                $loot[] = $monsterItem->item;
            }
        }
        return $loot;
    }
    
    /**
     * Decides whether the monster drops its contact details
     * dropContactPerc are percentage point increasers/decreasers as usual
     * @param int $dropContactPerc bonus to the drop rate
     * @return mixed CharacterContacts record or null
     */
    public function dropContact($dropContactPerc = 0) {
        $prob = max(0, min(1, $this->contactProb + $dropContactPerc / 100));
        $rand = mt_rand(0, 1000);
        if($rand <= $prob * 1000) {
            return $this->contact->getCharacterContact($this->sex);
        }
        return null;
    }
    
    /**
     * Decreases the monster's temporary hp by $damage
     * @param int $damage 
     */
    public function decreaseHp($damage) {
        $this->hp -= $damage;
        if($this->hp < 0) {
            $this->hp = 0;
        }
    }
    
    /**
     * Fpr compatibility reasons
     * @param float $amount 
     */
    public function decreaseEnergy($amount) {
        $this->energy -= (int) $amount;
        if($this->energy < 0) {
            $this->energy = 0;
        }
    }
    
    /**
     * Initializes the Monster for battle 
     */
    public function getReadyForBattle() {
        $this->hp = $this->hpMax;
        $this->energy = 0;
        if(empty($this->sex)) {
            $this->sex = (mt_rand(0,1) ? "female" : "male");
        }
    }
    
    
    /**
     * Create a message that appears when the battle against this monster starts
     * @todo do this in Battle
     * @todo do it way more dynamically
     * @return string 
     */
    public function createFirstRoundCombatMessage() {
        if(!empty($this->msgEncounter)) {
            return sprintf($this->msgEncounter, $this->name);
        }
        
        $msgs = array(
            "A " . $this->name . " sneaks up on you.",
            "A wild " . $this->name . " appears.",
            "You're engaging in an epic battle with a " . $this->name . ".",
        );
        
        return $msgs[mt_rand(0,count($msgs)-1)];
    }
    
    /**
     * Returns a string representation of the Monster's title
     * Default is empty string, but can be changed by specialness behavior class
     * @return string
     */
    public function getTitle() {
        return "";
    }

    /**
     * Returns the Monster's attack value
     * @param string $stat enum(resoluteness|willpower). Included for
     * compatibility reasons (Character->getAttack needs that param)
     * @return int
     */
    public function getAttack($stat = "resoluteness") {
        return $this->attack;
    }
    /**
     * Returns the Monster's defense value
     * @return int
     */
    public function getDefense() {
        return $this->defense;
    }
    /**
     * Returns the Monster's maximum hp value
     * @return int
     */
    public function getHpMax() {
        return $this->hpMax;
    }
    
    /**
     * Raises nothing, leaves $event unchanged
     * @param CollectBonusEvent $event
     * @param string $damageType enum (normal|vices) default normal
     */
    public function onCalcBonusDamage($event, $damageType = "normal") { }

    /**
     * Raises nothing, leaves $event unchanged
     * @param CollectBonusEvent $event
     */
    public function onCalcCritChance($event) { }
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     "application.components.CombatantBehavior");
    }
        
    /**
     * Returns the declaration of named scopes. A named scope represents a query
     * criteria that can be chained together with other named scopes and applied
     * to a query.
     * @link http://www.yiiframework.com/doc/api/1.1/CActiveRecord#scopes-detail
     * @return array the scope definition. The array keys are scope names
     */
    public function scopes() {
        return array(
            'withRelated' => array(
                'with' => array(
                    'monsterBattleskills' => array(
                        'alias' => 'monsterMonsterBattleskills' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'monsterItems' => array(
                        'alias' => 'monsterMonsterItems' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                )
            ),
        );
    }

    /**
     * Factory method to get Model objects
     * @link http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}