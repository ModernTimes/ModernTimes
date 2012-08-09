<?php

/**
 * Mammon waits until the Character exploits their contacts for cash a
 * number of times.
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
     * How often the Character has to exploit a contact for cash
     * @const int 
     */
    const numberOfFavors = 20;
    
    /**
     * ID of the "Ask for cash" favor
     * @const int 
     */
    const favorID = 2;
    
    /**
     * Encounter record id of Mommon saying hello the first time
     * @const int 
     */
    const mammonCallsEncounterID = 2;

    /**
     * Set the initial parameters for the Quest.
     * In this case: a counter
     */
    public function setInitialParams() {
            $this->owner->params['n'] = 0;
            $this->owner->saveParams();
    }

    /**
     * Attaches custom event handlers to a Character
     * @param Character $Character 
     * @return void
     */
    public function attachToCharacter($Character) {
        $Character->onExploit = array($this, 'reactToOnExploit');
    }

    /**
     * Detaches custom event handlers from a Character
     * @param Character $Character 
     */
    public function detachFromCharacter($Character) {
        $Character->detachEventHandler("onExploit", array($this, 'reactToOnExploit'));
    }

    /**
     * Checks if the Character exploited for cash, and if so, increases n by 1
     * @param ExploitEvent $event 
     * @return void
     */
    public function reactToOnExploit($event) { 
        $Favor = $event->getFavor();
        if($Favor->id == self::favorID) {
            $this->owner->params['n'] ++;
            if($this->owner->params['n'] >= self::numberOfFavors) {
                $this->owner->setState("succeeded");
            } else {
                $this->owner->saveParams();
            }
        }
    }
    
    /**
     * Adds the "Mommon says hello" encounter to the encounter queue
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnSucceeded($event) {
        $CharacterEncounter = new CharacterEncounters();
        $CharacterEncounter->characterID = $this->owner->CharacterQuest->characterID;
        $CharacterEncounter->encounterID = self::mammonCallsEncounterID;
        $CharacterEncounter->delay = 0;
        $CharacterEncounter->save();
    }
    
    /**
     * Sets the CharacterQuest to visible
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnCompleted($event) {
        $this->owner->visible = 1;
        // Reset params and update CharacterQuest record
        $this->owner->reactToOnCompleted($event);
    }
}