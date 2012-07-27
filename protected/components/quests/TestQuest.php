<?php

/**
 * Demonstration class to show how quests can be customized with the
 * specialnessBehavior pattern
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
     * Is only called if CharacterQuest->state is not completed or failed
     * This one does nothing, but that might be different for other quests
     * @use Quest->initialize
     * @param Character $Character
     * @param CharacterQuest $CharacterQuest 
     */
    public function initialize($Character, $CharacterQuest) {
        // Call "parent" method
        $this->owner->initialize($Character, $CharacterQuest);
    }
    
    /**
     * Set the initial parameters for the Quest.
     * In this case: a counter
     */
    public function setInitialParams() {
        $this->owner->params['counter'] = 0;
        $this->owner->saveParams();
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
     * Custum event handler. This is what makes TestQuest special.
     * In this example, a quest counter is increased by 1 everytime the
     * Character record calculates its maxHp. Boring.
     * @param CEvent $event 
     * @return void
     */
    public function reactToOnCalcHp($event) { 
        $this->owner->params['counter'] ++;
        $this->owner->saveParams();
    }
}