<?php

/**
 * Gives enemy a (useless) insurance policy (20) for 5 cash.
 * 
 * $this->owner is a Skill
 * 
 * @package Battle.Skills
 */

class SellInsuranceSkill extends CBehavior {

    /**
     * See above
     * @param Battle $battle
     * @param Monster $hero
     * @param Character $enemy
     */
    public function resolve($battle, $hero, $enemy) {
        if(!$this->owner->checkSuccess($battle, $hero, $enemy)) {
            return;
        }
        if(!$this->owner->checkBlocked($battle, $hero, $enemy)) {
            return;
        }
        
        $this->owner->dealDamage($battle, $hero, $enemy);
        
        $enemy->decreaseCash(5);
        $enemy->gainItem(20, 1, "battle");
    }
}