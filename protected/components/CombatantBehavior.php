<?php

/*
 *  Gets attached to Character and Monster to take care of certain battle-related tasks
 */

class CombatantBehavior extends CModelBehavior {

    public function takeDamage($damage, $damageType) {
        $event = new CModelEvent($this, array('damage' => &$damage,
                                              'damageType' => &$damageType));
        $this->onBeforeTakingDamage($event);
        
        /*
         * Calculate damage reduction for normal damage
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