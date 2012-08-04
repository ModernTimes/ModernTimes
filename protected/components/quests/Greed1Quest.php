<?php

/**
 * Mammon waits until the Character collects 2.000 cash, 
 * which completes the quest.
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
     * How much cash the Character has to collect in order to complete the quest
     * @const int 
     */
    const cashToCollect = 2000;
    
    /**
     * Encounter record id of Mommon saying hello the first time
     * @const int 
     */
    const mommonCallsEncounterID = 2;

    /**
     * Set the initial parameters for the Quest.
     * In this case: a counter
     */
    public function setInitialParams() {
            $this->owner->params['cashCollected'] = 0;
            $this->owner->saveParams();
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
     * Detaches custom event handlers from a Character
     * @param Character $Character 
     */
    public function detachFromCharacter($Character) {
        $Character->detachEventHandler("onGainCash", array($this, 'reactToOnGainCash'));
    }

    /**
     * Adds the amount of cash that the character gets to the quest counter
     * @param GainStatEvent $event 
     * @return void
     */
    public function reactToOnGainCash($event) { 
        if($event->getAmount() > 0) {
            $this->owner->params['cashCollected'] += $event->getAmount();
            if($this->owner->params['cashCollected'] >= self::cashToCollect) {
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
        $CharacterEncounter->encounterID = self::mommonCallsEncounterID;
        $CharacterEncounter->delay = 0;
        $CharacterEncounter->save();
    }
}