<?php

/**
 * Mammon waits until the Character collects 2.000 cash, 
 * which completes the quest.
 * 
 * @todo Change state, trigger messages, etc.
 * 
 * This Quest is added for new Characters (state = unavailable).
 * 
 * Upon completion, the Character can summon Mammon.
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterQuests
 * @package Quests
 */

class Greed1Quest extends CBehavior {

    /**
     * Initialize the Quest
     * @param Character $Character
     * @param CharacterQuest $CharacterQuest 
     */
    public function initialize($Character, $CharacterQuest) {
        // Call "parent" method
        $this->owner->initialize($Character, $CharacterQuest);
        
        if(empty($this->owner->params)) {
            $this->owner->params['cashCollected'] = 0;
            $this->owner->saveParams();
        }
    }
    
    /**
     * Returns a string representation of what is going on right now with
     * regard to this Quest (from the Character's point of view)
     * @return string empty
     */
    public function getDescStatus() {
        return "";
    }
    
    /**
     * Attaches custom event handlers to a Character
     * @param Character $Character 
     * @return void
     */
    public function attachToCharacter($Character) {
        $Character->onGainCash = array($this, 'reactToOnGainCash');
    }

    /**
     * Adds the amount of cash that the character gets to the quest counter
     * @param GainStatEvent $event 
     * @return void
     */
    public function reactToOnGainCash($event) { 
        if($event->getAmount() > 0) {
            $this->owner->params['cashCollected'] += $event->getAmount();
            $this->owner->saveParams();
        }
    }
}