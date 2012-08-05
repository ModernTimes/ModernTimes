<?php

/**
 * Tutorial quest
 * 
 * Upon completion, the Character gets their initial items and skills.
 * 
 * This Quest is automatically added for new players with state = ongoing.
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterQuests
 * @package Quests
 */

class TutorialQuest extends CBehavior {

    /**
     * Set the initial parameters for the Quest.
     * In this case: flags for each step
     */
    public function setInitialParams() {
            $this->owner->params['currentStep'] = '';
            $this->owner->params['hasEquippedWeapon'] = 0;
            $this->owner->saveParams();
    }
    
    /**
     * Returns a string representation of what is going on right now with
     * regard to this Quest
     * @return string
     */
    public function getDescStatus() {
        switch($this->owner->params['currentStep']) {
            case "inventory":
                return "You are just trying to remember where your stuff is.";
                break;
            default:
                return "";
                break;
        }
    }
    
    /**
     * Attaches custom event handlers to a Character
     * @param Character $Character 
     */
    public function attachToCharacter($Character) {
        $Character->onGainItem = array($this, 'reactToOnGainItem');
    }
    
    /**
     * Detaches custom event handlers from a Character
     * @param Character $Character 
     */
    public function detachFromCharacter($Character) {
        $Character->detachEventHandler("onGainItem", array($this, 'reactToOnGainItem'));
    }
    
    /**
     * Checks whether the character got a novice deck
     * @param GainItemEvent $event 
     */
    public function reactToOnGainItem($event) {
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