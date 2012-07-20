<?php

Yii::import('application.models._base.BaseMonster');
Yii::import('application.components.monsters.*');

/**
 * Simulates monsters during battles
 * 
 * See BaseMonster for a list of attributes and related Models
 * 
 * @see CombatantBehavior
 * @see SpecialnessBehavior
 * @package Battle
 */

class Monster extends BaseMonster {

    /**
     * Temporary values. set to attribute hpMax at the beginning of a battle
     * @var int
     */
    public $hp;

    /**
     * Future AI can refer to the current battle state
     * @uses Lottery
     * @param Battle $battle
     * @return Skill
     * @todo check if the skill can actually be used
     */
    public function act($battle) {
        $l = new Lottery();
        $l->addParticipants($this->monsterSkills);
        $winner = $l->getWinner();

        if($winner == false) {
            // Use the Wait skill, which does nothing
            return Skill::model()->findByPk(1);
        }
        // Remember that the winner is not the skill, but a MonsterSkills AR entry
        return $winner->skill;
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
     * Initializes the Monster for battle 
     */
    public function getReadyForBattle() {
        $this->hp = $this->hpMax;
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
     * @see CombatantBehavior
     * @see SpecialnessBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                        "application.components.CombatantBehavior");
    }
        
    /**
     * Factory method to get Model objects
     * @see http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}