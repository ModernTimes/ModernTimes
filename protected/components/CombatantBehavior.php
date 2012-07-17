<?php

/**
 * Gets attached to Character and Monster models 
 * to take care of certain battle-related tasks
 */

class CombatantBehavior extends CModelBehavior {

    /**
     * @param int $damage, how much damage the combatant is to take
     * @param enum(normal, special) $damageType
     * @return int, how much damage the combatant actually suffered after
     *              damage reduction effects
     */
    public function takeDamage($damage, $damageType) {
        $event = new CModelEvent($this, array('damage' => &$damage,
                                              'damageType' => &$damageType));
        $this->onBeforeTakingDamage($event);
        
        /**
         * Calculate damage reduction for normal damage
         * (cunningBuffed for characters, defense attribute for monsters)
         */
        if($damageType == "normal") {
            $damage -= $this->owner->getDefense();
        }
        
        $damage = max(floor($damage), 0);
        $this->owner->decreaseHp($damage);

        $this->onAfterTakingDamage($event);
        
        return $damage;
    }
    
    public function onBeforeDealingDamage($event) { 
        $this->raiseEvent('onBeforeDealingDamage', $event);
    }
    public function onAfterDealingDamage($event) {
        $this->raiseEvent('onAfterDealingDamage', $event);
    }
    public function onBeforeTakingDamage($event) {
        $this->raiseEvent('onBeforeTakingDamage', $event);
    }
    public function onAfterTakingDamage($event) {
        $this->raiseEvent('onAfterTakingDamage', $event);
    }
}