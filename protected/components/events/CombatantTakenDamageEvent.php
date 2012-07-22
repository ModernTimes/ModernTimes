<?php

/**
 * Notifier
 * Informs that the Combatant has taken damage
 * @todo Enforce the sender to have CombatantBehavior
 *
 * @uses DamageStorageBehavior
 * @package Events
 */

class CombatantTakenDamageEvent extends CEvent {
    
    public function __construct($sender, $damage = 0, $damageType = "normal", $params = array()) {
        $this->attachBehaviors($this->behaviors());

        // DamageStorage part
        $this->asa("DamageStorage")->init(
                $damage,
                $damageType
        );

        parent::__construct($sender, $params);
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
