<?php

/**
 * Notifier
 * Informs that the battle action has dealt damage
 *
 * @uses DamageStorageBehavior
 * @package Events
 */

class BattleActionDamageDealtEvent extends BattleActionEvent {

    /**
     * Calls parent constructor
     * @param Battle $sender 
     * @param mixed $hero null or CModel with CombatantBehavior
     * Combatant from whose perspective the event takes place
     * @param mixed $enemy null or CModel with CombatantBehavior
     * Enemy of the combatant from whose perspective the event takes place
     * @param float $damage The base amount of damage (before adjustments)
     * @param string $damageType enum(normal|special)
     * @param array $params default empty
     */
    public function __construct($sender, $hero, $enemy, $action, 
                $damage = 0, $damageType = "normal", $params = array()) {
        
        $this->attachBehaviors($this->behaviors());

        // DamageStorage part
        $this->asa("DamageStorage")->init(
                $damage,
                $damageType
        );

        parent::__construct($sender, $hero, $enemy, $action, $params);
    }
    
    /**
     * Returns a list of CBehaviors to be attached to this component
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array(
            "DamageStorage" => "application.components.events.behaviors.DamageStorageBehavior"
        );
    }
}

?>
