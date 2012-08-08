<?php

/**
 * Calls a meeting and then attacks
 * 
 * @package Monsters
 */

class MeetingMonster extends CBehavior {

    /**
     * See above
     * @param Battle $battle
     * @return Skill
     */
    public function act($battle) {
        // If opponent trapped in a meeting: waste time in a meeting (11)
        if($battle->combatantHasEffect("combatantA", 3)) {
            return Battleskill::model()->findByPk(11);
        }
        // Else: trap in meeting (10)
        else {
            return Battleskill::model()->findByPk(10);
        }
    }    
}

?>
