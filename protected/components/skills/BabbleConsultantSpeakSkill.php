<?php

/*
 *  Uses and adds BabbleComboEffect
 */

class BabbleConsultantSpeakSkill extends BabbleSkillType {
    
    // Same, except that no log is generated for creating the BabbleComboEffect
    /*
    public function resolve($battle, $hero, $enemy) {
        if(!$this->owner->checkBlocked($battle, $hero, $enemy)) {
            return;
        }
        $this->owner->dealDamage($battle, $hero, $enemy);

        $effect = clone $this->owner->createEffect0;
        $effect->call("initialize", $battle, $hero, $enemy, array('turns' => $this->owner->effectTurns));
    }
    */
    // Same as owner, just no battlemessage for the creation of the effect
    public function createEffects($battle, $hero, $enemy, $log = false) {
        $this->owner->createEffects($battle, $hero, $enemy, false);
    }
    
    public function getMsgResolved() {
         return "%1\$s takes a deep breath: \"" . $this->getBabbleBullshit() . "\"";
    }
}