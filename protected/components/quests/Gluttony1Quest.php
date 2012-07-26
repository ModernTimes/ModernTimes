<?php

/**
 * Beelzebub waits until the Character fulfills a number of
 * gluttony-related conditions, which completes the quest.
 * 
 * @todo Change state, trigger messages, etc.
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
     * Initialize the Quest
     * @param Character $Character
     * @param CharacterQuest $CharacterQuest 
     */
    public function initialize($Character, $CharacterQuest) {
        // Call "parent" method
        $this->owner->initialize($Character, $CharacterQuest);
        
        if(empty($this->owner->params)) {
            $this->owner->params['wasHigh'] = 0;
            $this->owner->params['wasStoned'] = 0;
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
        $Character->onGainEffect = array($this, 'reactToOnGainEffect');
    }

    /**
     * Checks if the Character gets high, stoned, or whatever else is needed
     * to complete this quest
     * @param GainEffectEvent $event 
     * @return void
     */
    public function reactToOnGainEffect($event) { 
        switch($event->getCharacterEffect()->effect->id) {
            // High
            case 2:
                $this->owner->params['wasHigh'] = 1;
                $this->owner->saveParams();
                break;
            default:
                break;
        }
    }
}