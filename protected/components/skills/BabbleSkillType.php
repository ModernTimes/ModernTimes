<?php

/**
 * Provides babble bullshit phrases for BabbleSkills
 * 
 * $this->owner is a Skill
 * 
 * @todo create babble bullshit phrases dynamically
 *       (https://github.com/ModernTimes/ModernTimes/issues/7)
 * 
 * @package Battle.Skills
 */

class BabbleSkillType extends CBehavior {

    /**
     * Returns a random babble bullshit phrase out of a small collection
     * of phrases
     * @return string
     */
    public function getBabbleBullshit() {
        $messages = array(
            "Confirmed, our team consists of young, ambitious and motivated professionals in a result-driven organization, which encourages initiative, combined with responsibility and personal development.",
            "Our biggest challenge is cultivating fully operational performances at a much shorter duration and more limited scope.",
            "We realize that generating quick-win marketing efforts help you cope with an ultra-dynamic marketplace.",
            "Our ongoing efforts to productize turnkey thoughtware are leading potential customers to your web page.",
        );
        
        return $messages[mt_rand(0, count($messages)-1)];
    }
}