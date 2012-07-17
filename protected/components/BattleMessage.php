<?php

class BattleMessage extends CComponent {

    /**
     * @var string, set by Battle's logging function
     */
    public $hero;
    
    /**
     * @var array, log details of the skill that is responsible for the message
     */
    public $skill;
    
    /**
     * @var string, the message itself
     */
    public $msg;
    /**
     * @var array, log details of a battle action result
     */
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
    
    /**
     * Redirects setResult requests to more specific setResult methods
     * @param enum(damage,effect) firstOne, type of the result
     * @param rest, see these more specific setResult methods
     */
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