<?php

/**
 * Demonstration class to show how quests can be customized with the
 * specialnessBehavior pattern
 * @todo change onCalcHp with something more quest-like
 * 
 * $this->owner is a Quest record
 * 
 * @uses SpecialnessBehavior
 * @package Quests
 */

class TestQuest extends CBehavior {

    /**
     * Attaches custom event handlers to a Character
     * @param Character $Character 
     * @return void
     */
    public function attachToCharacter($Character) {
        $Character->onCalcHp = array($this, 'reactToOnCalcHp');
    }

    /**
     * Custum event handler. This is what makes TestQuest special
     * @param CEvent $event 
     * @return void
     */
    public function reactToOnCalcHp($event) { 
        // $event->params['bonusAbs'] += 235;
    }
}