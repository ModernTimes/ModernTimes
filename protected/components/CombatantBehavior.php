<?php

/**
 * Gets attached to Character and Monster models. 
 * Provides event raisers for battles
 * 
 * @package Battle
 */

class CombatantBehavior extends CModelBehavior {
    
    /**
     * Raises an event
     * @param CombatantTakeDamage $event
     */
    public function onBeforeTakeDamage($event) {
        $this->raiseEvent('onBeforeTakeDamage', $event);
    }
    /**
     * Raises an event
     * @param CombatantTakenDamage $event
     */
    public function onAfterTakenDamage($event) {
        $this->raiseEvent('onAfterTakenDamage', $event);
    }
}