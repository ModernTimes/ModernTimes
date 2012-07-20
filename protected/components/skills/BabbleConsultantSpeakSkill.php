<?php

/**
 * All BabbleSkills add the BabbleComboEffect (we have to write the effectID 
 * of BabbleComboEffect in each babbling skill entry in the database)
 * However, we don't want to create a battlemessage when the BabbleComboEffect 
 * is created.
 * 
 * $this->owner is a Skill
 * 
 * @see Skill
 * @package Battle.Skills
 */

class BabbleConsultantSpeakSkill extends BabbleSkillType {
    /**
     * Same as owner, just no battlemessage for the creation of the effect
     * @param Battle $battle
     * @param CombatantBehavior $hero actually a record with CombatantBehavior
     * @param CombatantBehavior $enemy actually a record with CombatantBehavior
     * @param bool $log has no influence on the function's behavior. It is only
     * provided to be compatible with Skill->createEffects
     */
    public function createEffects($battle, $hero, $enemy, $log = false) {
        $this->owner->createEffects($battle, $hero, $enemy, false);
    }
    
    /**
     * Returns a string that can be used as the message in a BattleMessage
     * @see BattleMessage
     * @return string
     */
    public function getMsgResolved() {
         return "%1\$s takes a deep breath: \"" . $this->getBabbleBullshit() . "\"";
    }
}