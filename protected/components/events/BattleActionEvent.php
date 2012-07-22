<?php

/**
 * Basic extension from BattleEvent, that also keeps the battle action object
 * as a property
 * 
 * @package Events
 */

class BattleActionEvent extends BattleEvent {
    
    /**
     * The battle action: Skill or Item
     * @var mixed $action
     */
    public $action;
    
    /**
     * Calls parent constructor
     * @param Battle $sender 
     * @param CModel $hero with CombatantBehavior
     * Combatant from whose perspective the event takes place
     * @param CModel $enemy with CombatantBehavior
     * Enemy of the combatant from whose perspective the event takes place
     * @param mixed $action battle action: Skill or Item
     * @param array $params default empty
     */
    public function __construct($sender, $hero, $enemy, $action, $params = array()) {
        $this->action = $action;
        parent::__construct($sender, $hero, $enemy, $params);
    }
}

?>