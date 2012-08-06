<?php

/**
 * Basic BattleEvent 
 * Enforces the sender to be either null or a Battle
 * Keeps $hero and $enemy as properties
 * 
 * @package Events
 */

class BattleEvent extends CEvent {
    
    /**
     * Combatant from whose perspective the event takes place, if any
     * @var CombatantBehavior CModel with CombatantBehavior
     */
    public $hero;
    
    /**
     * Enemy of the combatant from whose perspective the event takes place, 
     * if any
     * @var CombatantBehavior CModel with CombatantBehavior
     */
    public $enemy;
    
    /**
     * Calls parent constructor
     * @param Battle $sender 
     * @param mixed $hero null or CModel with CombatantBehavior
     * Combatant from whose perspective the event takes place
     * @param mixed $enemy null or CModel with CombatantBehavior
     * Enemy of the combatant from whose perspective the event takes place
     * @param array $params default empty
     * @throws CException if sender is not null or Battle record
     */
    public function __construct($sender, $hero = null, $enemy = null, $params = array()) {
        if(!is_a($sender, "Battle")) {
            throw new CException("Sender needs to be a Battle record");
        }
        $this->hero = $hero;
        $this->enemy = $enemy;
        
        parent::__construct($sender, $params);
    }
    
    /**
     * Basic getter
     * @return Battle 
     */
    public function getBattle() {
        return $this->sender;
    }
}

?>
