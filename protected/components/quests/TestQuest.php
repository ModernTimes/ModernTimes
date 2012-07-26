<?php

/**
 * Demonstration class to show how quests can be customized with the
 * specialnessBehavior pattern
 * @todo change onCalcHp with something more quest-like
 * 
 * $this->owner is a Quest record
 * $this->owner->CharacterQuest is a CharacterQuest record
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterQuests
 * @package Quests
 */

class TestQuest extends CBehavior {

    /**
     * Initialize the Quest
     * @param Character $Character
     * @param CharacterQuest $CharacterQuest 
     */
    public function initialize($Character, $CharacterQuest) {
        // Call "parent" method
        $this->owner->initialize($Character, $CharacterQuest);
        
        if(empty($this->owner->params['counter'])) {
            $this->owner->params['counter'] = 0;
            $this->owner->saveParams();
        }
    }
    
    /**
     * Returns a string representation of what is going on right now with
     * regard to this Quest (from the Character's point of view)
     * @return string empty
     */
    public function getDescStatus() {
        return "onCalcHp events since this nonsense started: " . 
               $this->owner->params['counter'];
    }
    
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
        $this->owner->params['counter'] ++;
        $this->owner->saveParams();
    }
}