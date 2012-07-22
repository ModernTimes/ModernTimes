<?php

/**
 * Gets attached to Character and Monster models 
 * to take care of certain battle-related tasks
 * 
 * @package Battle
 */

class CombatantBehavior extends CModelBehavior {

    /**
     * returns how much damage the combatant actually suffered after damage 
     * reduction effects
     * @uses onBeforeTakingDamage
     * @uses onAfterTakingDamage
     * @uses CombatantTakeDamageEvent
     * @uses CombatnatTakenDamageEvent
     * @param int $damage, how much damage the combatant is to take
     * @param string $damageType enum(normal|special)
     * @return int 
     */
    public function takeDamage($damage, $damageType) {
        // TakeDamageEvent, collect bonuses
        $event = new CombatantTakeDamageEvent($this, $damage, $damageType);
        $this->onBeforeTakingDamage($event);
        
        $damageAdjusted = floor($event->adjustStat($damage));
        
        /**
         * Calculate damage reduction for normal damage
         * (cunningBuffed for characters, defense attribute for monsters)
         */
        if($damageType == "normal") {
            $damageAdjusted -= $this->owner->getDefense();
        }
        
        $damageAdjusted = max($damage, 0);
        $this->owner->decreaseHp($damageAdjusted);

        // takeN damage event, notification only
        $event = new CombatantTakenDamageEvent($this, $damageAdjusted, $damageType);
        $this->onAfterTakingDamage($event);
        
        return $damage;
    }
    
    /**
     * Raises an event
     * @param CEvent $event
     */
    public function onBeforeDealingDamage($event) { 
        $this->raiseEvent('onBeforeDealingDamage', $event);
    }
    /**
     * Raises an event
     * @param CEvent $event
     */
    public function onAfterDealingDamage($event) {
        $this->raiseEvent('onAfterDealingDamage', $event);
    }
    /**
     * Raises an event
     * @param CEvent $event
     */
    public function onBeforeTakingDamage($event) {
        $this->raiseEvent('onBeforeTakingDamage', $event);
    }
    /**
     * Raises an event
     * @param CEvent $event
     */
    public function onAfterTakingDamage($event) {
        $this->raiseEvent('onAfterTakingDamage', $event);
    }
}