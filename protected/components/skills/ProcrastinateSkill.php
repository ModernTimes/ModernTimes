<?php

/**
 * Does nothing. Not yet.
 * 
 * $this->owner is a Skill
 * 
 * @package Battle.Skills
 */

class ProcrastinateSkill extends CBehavior {

    /**
     * Unleashes the mighty power of pracrastination onto the enemy
     * @param Battle $battle
     * @param CombatantBehavior $hero actually a record with CombatantBehavior
     * @param CombatantBehavior $enemy actually a record with CombatantBehavior
     */
    public function resolve($battle, $hero, $enemy) {
        $battleMsg = new Battlemessage(
                sprintf($this->owner->call("getMsgResolved"), $hero->name), 
                $this->owner
        );
        $battle->log($hero, $battleMsg);
    }
}