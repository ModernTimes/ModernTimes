<?php

class TestItem extends CBehavior {

    public function attachToCharacter($character) {
        // Include basic modifier functionality
        $this->owner->attachToCharacter($character);
        
        $character->onCalcHp = array($this, 'reactToOnCalcHp');
    }

    public function reactToOnCalcHp($event) { 
        // $event->params['bonusAbs'] += 235;
    }
}