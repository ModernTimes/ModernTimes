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
     * Decides for each potential item drop whether it is indeed dropped or not
     * dropItemPerc are percentage point increasers/decreasers as usual
     * @param int $dropItemPerc bonus to the drop rate
     * @return array of Item records
     */
    public function dropItems($dropItemPerc = 0) {
        $loot = array();
        foreach($this->monsterItems as $monsterItem) {
            $prob = max(0, min(1, $monsterItem->prob * (($dropItemPerc + 100) / 100)));
            $rand = mt_rand(0, 1000000);
            if($rand <= $prob * 1000000) {
                $loot[] = $monsterItem->item;
            }
        }
        return $loot;
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
    }
    
    
    /**
     * Create a message that appears when the battle against this monster starts
     * @todo do this in Battle
     * @todo do it way more dynamically
     * @return string 
     */
    public function createFirstRoundCombatMessage() {
        $msgs = array(
            "A " . $this->name . " sneaks up on you.",
            "A wild " . $this->name . " appears.",
            "You're engaging in an epic battle with a " . $this->name . ".",
        );
        $ret = $msgs[mt_rand(0,count($msgs)-1)];
    
        if(!empty($this->msgEncounter)) {
            $ret .= " " . $this->msgEncounter;
        }
        return $ret;
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
     * Returns the Monster's attack value (for normal attacks)
     * @return int
     */
    public function getNormalAttack() {
        return $this->attack;
    }
    /**
     * Returns the Monster's special attack value (for special attacks)
     * @return int
     */
    public function getSpecialAttack() {
        return $this->attack;
    }
    /**
     * Returns the Monster's defense value (against normal attacks)
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