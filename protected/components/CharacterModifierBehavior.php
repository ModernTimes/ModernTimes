<?php

/**
 * Every model that has a characterModifier attribute uses this as a behavior
 * Makes it possible to call Model->attachTo() instead of 
 * Model->charactermodifier->attachTo(), which is better readable
 */

class CharacterModifierBehavior extends CBehavior {
    public function attachToCharacter($Character) {
        if(is_a($this->owner->charactermodifier, "Charactermodifier")) {
            // d($this->owner->charactermodifier);
            $this->owner->charactermodifier->attachToCharacter($Character);
        }
    }

    public function detachFromCharacter($Character) {
        if(is_a($this->owner->charactermodifier, "Charactermodifier")) {
            // d($this->owner->charactermodifier);
            $this->owner->charactermodifier->detachFromCharacter($Character);
        }
    }
    
    // ToDo: Some nice text based on the modifiers
    public function getPopup() { 
        return $this->owner->desc; 
    }
}