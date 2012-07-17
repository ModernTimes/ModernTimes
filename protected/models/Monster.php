<?php

Yii::import('application.models._base.BaseMonster');
Yii::import('application.components.monsters.*');

/**
 * Simulates monsters during battles
 */

class Monster extends BaseMonster {

    /**
     * Temporary values. set to attribute hpMax at the beginning of a battle
     * @var int
     */
    public $hp;

    /**
     * Future AI can refer to the current battle state
     * @param Battle $battle
     * @return Skill
     * ToDo: check if the skill can actually be used
     *      */
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
     * @param int $dropItemPerc
     * @return array|Item
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
    
    public function decreaseHp($damage) {
        $this->hp -= $damage;
        if($this->hp < 0) {
            $this->hp = 0;
        }
    }
    
    public function getReadyForBattle() {
        $this->hp = $this->hpMax;
    }
    
    // ToDo: make this waaay more dynamic
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
    public function getTitle() {
        return "";
    }


    /**
     * Stuff that cannot be made special
     */
    public function getNormalAttack() {
        return $this->attack;
    }
    public function getSpecialAttack() {
        return $this->attack;
    }
    public function getDefense() {
        return $this->defense;
    }
    public function getHpMax() {
        return $this->hpMax;
    }
    
    public function behaviors() {
            return array("application.components.SpecialnessBehavior",
                         "application.components.CombatantBehavior");
    }
        
    public static function model($className=__CLASS__) {
            return parent::model($className);
    }
}