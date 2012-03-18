<?php

class BattleMessage extends CComponent {

    public $hero;
    
    public $skill;
    public $msg;
    public $result;
    
    public function __construct($msg = "", $skill = array(), $result = array()) {
        $this->msg = $msg;
        $this->result = $result;
        
        $this->setSkill($skill);
    }
    
    public function setSkill($skill) {
        if(is_a($skill, "Skill")) {
            $skill = $skill->call("getLogDetails");
        }
        $this->skill = $skill;
    }
    
    public function hasResult() {
        return (!empty($this->result));
    }
    public function getResultType() {
        if($this->hasResult()) {
            return $this->result["type"];
        }
        return "";
    }
    
    public function setResult() {
        switch(func_get_arg(0)) {
            case "damage":
                $this->setResultDamage(func_get_arg(1), func_get_arg(2));
                break;
            case "effect":
                $this->setResultEffect(func_get_arg(1));
                break;
            default:
                break;
        }
    }
    
    public function setResultDamage($damageDone, $damageType = 'normal') {
        $this->result['type'] = 'damage';
        $this->result['damageDone'] = $damageDone;
        $this->result['damageType'] = $damageType;
    }
    
    public function setResultEffect($effect) {
        $this->result['type'] = 'effect';
        $this->result['effect'] = $effect->getLogDetails();
    }
    
    public function setResultBlocked() {
        $this->result['type'] = 'blocked';
    }
}