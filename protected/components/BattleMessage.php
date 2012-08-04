<?php

/**
 * Encapsulates battle messages which are then used to print detailed and
 * nice looking battle histories.
 * 
 * @package Battle
 */

class BattleMessage extends CComponent {

    /**
     * @var string set by Battle's logging function
     */
    public $hero;
    
    /**
     * @var array log details of the skill that is responsible for the message
     */
    public $skill;
    
    /**
     * @var string the message itself
     */
    public $msg;
    
    /**
     * @var array log details of a battle action result
     */
    public $result;
    
    /**
     * Constructor
     * @param string $msg
     * @param array $skill log details of the skill that produced the message
     * @param array $result log details of the battle action result
     */
    public function __construct($msg = "", $skill = array(), $result = array()) {
        $this->msg = $msg;
        $this->result = $result;
        
        $this->setSkill($skill);
    }
    
    /**
     * Basic setter
     * @param array|Skill $skill log details of the skilll that produced the 
     * message, or the Skill record to get the log details from
     * @return void
     */
    public function setSkill($skill) {
        if(is_a($skill, "Skill")) {
            $skill = $skill->call("getLogDetails");
        }
        $this->skill = $skill;
    }
    
    /**
     * checks if the message has a battle action result defined
     * @return bool
     */
    public function hasResult() {
        return (!empty($this->result));
    }
    
    /**
     * returns the type of the battle action result, e.g. damage or createEffect
     * returns an empty string if no battle action result is defined
     * @return string
     */
    public function getResultType() {
        if($this->hasResult()) {
            return $this->result["type"];
        }
        return "";
    }
    
    /**
     * Redirects setResult requests to more specific setResult methods
     * param string first parameter  type of the result (damage|effect|blocked)
     * param other parameters see the more specific setResult methods
     * @return void
     */
    public function setResult() {
        switch(func_get_arg(0)) {
            case "damage":
                $this->setResultDamage(func_get_arg(1), func_get_arg(2));
                break;
            case "effect":
                $this->setResultEffect(func_get_arg(1));
                break;
            case "blocked":
                $this->setResultBlocked();
                break;
            case "failed":
                $this->setResultFailed();
                break;
            default:
                break;
        }
    }
    
    /**
     * Sets the result type to 'damage' and stores additional information about
     * that result
     * @param int $damageDone the amount of damage inflicted
     * @param string $damageType enum(normal|special)
     * @return void
     */
    public function setResultDamage($damageDone, $damageType = 'normal') {
        $this->result['type'] = 'damage';
        $this->result['damageDone'] = $damageDone;
        $this->result['damageType'] = $damageType;
    }
    
     /**
     * Sets the result type to 'effect' and stores additional information about
     * that effect
     * @param Battleeffect $Effect
     * @return void
     */
    public function setResultEffect($Effect) {
        $this->result['type'] = 'effect';
        $this->result['effect'] = $Effect->getLogDetails();
    }
    
    /**
     * Sets the battle action result to 'blocked'
     * @return void 
     */
    public function setResultBlocked() {
        $this->result['type'] = 'blocked';
    }
    /**
     * Sets the battle action result to 'failed'
     * @return void 
     */
    public function setResultFailed() {
        $this->result['type'] = 'failed';
    }
}