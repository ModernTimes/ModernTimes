<?php

/**
 * All BabbleSkills add the BabbleComboEffect (we have to write the effectID 
 * of BabbleComboEffect in each babbling skill entry in the database)
 * However, we don't want to create a battlemessage when the BabbleComboEffect 
 * is created.
 */

class BabbleConsultantSpeakSkill extends BabbleSkillType {
    // Same as owner, just no battlemessage for the creation of the effect
    public function createEffects($battle, $hero, $enemy, $log = false) {
        $this->owner->createEffects($battle, $hero, $enemy, false);
    }
    
    public function getMsgResolved() {
         return "%1\$s takes a deep breath: \"" . $this->getBabbleBullshit() . "\"";
    }
}