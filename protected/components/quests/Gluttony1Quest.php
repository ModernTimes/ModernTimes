<?php

/**
 * Beelzebub waits until the Character has experienced a number of 
 * gluttony-related effects, which completes the quest.
 * 
 * This Quest is added for new Characters (state = unavailable).
 * 
 * Upon completion, the Character can summon Beelzebub.
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterQuests
 * @package Quests
 */

class Gluttony1Quest extends CBehavior {

    /**
     * How many gluttony-related effects the Character has to experience
     * in order to complete the quest
     * @const int 
     */
    const effectsNeeded = 4;

    /**
     * Encounter record id of Beelzebub saying hello the first time
     * @const int 
     */
    const beelzebubCallsEncounterID = 1;
    
    /**
     * Set the initial parameters for the Quest.
     * In this case: flags for certain effects
     */
    public function setInitialParams() {
            $this->owner->params['wasHigh'] = 0;
            $this->owner->params['wasStoned'] = 0;
            $this->owner->params['wasDrunk'] = 0;
            $this->owner->params['wasHammered'] = 0;
            $this->owner->params['wasSated'] = 0;
            $this->owner->params['wasSurfeited'] = 0;
            $this->owner->saveParams();
    }
    
    /**
     * Attaches custom event handlers to a Character
     * @param Character $Character 
     * @return void
     */
    public function attachToCharacter($Character) {
        $Character->onGainEffect = array($this, 'reactToOnGainEffect');
    }
    
    /**
     * Checks if the Character gets high, stoned, or whatever else is needed
     * to complete this quest
     * @todo add 3 more severe forms of high, drunk, and sated
     * @param GainEffectEvent $event 
     * @return void
     */
    public function reactToOnGainEffect($event) {
        $relevantEffectIDs = array(2,3,4);
        $Effect = $event->getCharacterEffect()->effect;
        if(in_array($Effect->id, $relevantEffectIDs)) {
            switch($Effect->id) {
                // High
                case 2:
                    $this->owner->params['wasHigh'] = 1;
                    break;
                // Sated
                case 3:
                    $this->owner->params['wasSated'] = 1;
                    break;
                // Drunk
                case 4:
                    $this->owner->params['wasDrunk'] = 1;
                    break;
                default:
                    break;
            }
            
            $numberOfEffects = $this->owner->params['wasHigh'] + 
                               $this->owner->params['wasStoned'] + 
                               $this->owner->params['wasSated'] + 
                               $this->owner->params['wasSurfeited'] + 
                               $this->owner->params['wasDrunk'] + 
                               $this->owner->params['wasHammered'];
            if($numberOfEffects >= self::effectsNeeded) {
                $this->owner->setState("completed");
            } else {
                $this->owner->saveParams();
            }
            
        }
    }

    /**
     * Adds the "Beelzebub says hello" encounter to the encounter queue
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnCompleted($event) {
        $CharacterEncounter = new CharacterEncounters();
        $CharacterEncounter->characterID = $this->owner->CharacterQuest->characterID;
        $CharacterEncounter->encounterID = self::beelzebubCallsEncounterID;
        $CharacterEncounter->delay = 0;
        $CharacterEncounter->save();
        
        // Reset params and update CharacterQuest record
        $this->owner->reactToOnCompleted($event);
    }
}