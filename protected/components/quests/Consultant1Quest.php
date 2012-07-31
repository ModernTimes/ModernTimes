<?php

/**
 * "My first deck": The character is sent to an Undisclosed insurance company
 * to create their first professional PowerPoint deck.
 * 
 * Upon completion, the Character gets a cash bonus.
 * 
 * This Quest is automatically added for new consultants with state = available.
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterQuests
 * @package Quests
 */

class Consultant1Quest extends CBehavior {

    /**
     * Amount of cash that the character gets for completing the quest
     * @constant int 
     */
    const rewardCash = 2000;
    
    /**
     * ID of the required item
     * @constant int 
     */
    const deckItemID = 11;
    
    /**
     * Attaches custom event handlers to a Character
     * @param Character $Character 
     * @return void
     */
    public function attachToCharacter($Character) {
        $Character->onGainItem = array($this, 'reactToOnGainItem');
    }
    
    public function reactToOnGainItem($event) {
        d($event);
        if($event->getItem()->id == self::deckItemID) {
            $this->owner->setState("succeeded");
        }
    }
    
    /**
     * Gives out the reward
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnCompleted($event) {
        $this->owner->Character->gainCash(self::rewardCash, "quest");
        $this->owner->Character->update();
        
        // Reset params and update CharacterQuest record
        $this->owner->reactToOnCompleted($event);
    }
}