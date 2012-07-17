<?php

/**
 * hero is the Procrastinate skill user.
 * Does nothing. Not yet.
 */

class ProcrastinateSkill extends CBehavior {

    public function resolve($battle, $hero, $enemy) {
        $battleMsg = new Battlemessage(
                sprintf($this->owner->call("getMsgResolved"), $hero->name), 
                $this->owner
        );
        $battle->log($hero, $battleMsg);
    }
}