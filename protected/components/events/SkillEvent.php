<?php

/**
 * Notifier
 * @see Skill
 * @package Events 
 */

class SkillEvent extends CEvent {

    /**
     * The Skill record that was used
     * @var Skill
     */
    private $_Skill;
    
    /**
     * Constructor
     * @param mixed $sender obj or null
     * @param mixed $Skill Skill or null
     * @param array $params
     */
    public function __construct($sender = null, $Skill = null, $params = array()) {
        $this->_Skill = $Skill;
        parent::__construct($sender, $params);
    }
    
    /**
     * Basic getter
     * @return Skill
     */
    public function getSkill() {
        return $this->_Skill;
    }
}

?>
