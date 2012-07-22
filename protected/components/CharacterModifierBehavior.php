<?php

/**
 * Every model that has a characterModifier attribute uses this as a behavior.
 * Makes it possible to call Model->attachTo() instead of 
 * Model->charactermodifier->attachTo(), which is better readable
 * 
 * @uses Charactermodifier
 * @package Character
 */

class CharacterModifierBehavior extends CBehavior {
    
    /**
     * Attaches the Charactermodifier record of $this->owner to a Character
     * @uses Charactermodifier
     * @param Character $Character
     * @return void
     */
    public function attachToCharacter($Character) {
        if(is_a($this->owner->charactermodifier, "Charactermodifier")) {
            // d($this->owner->charactermodifier);
            $this->owner->charactermodifier->attachToCharacter($Character);
        }
    }

    /**
     * Detaches the Charactermodifier record of $this->owner from a Character
     * @uses Charactermodifier
     * @param Character $Character 
     * @return void
     */
    public function detachFromCharacter($Character) {
        if(is_a($this->owner->charactermodifier, "Charactermodifier")) {
            // d($this->owner->charactermodifier);
            $this->owner->charactermodifier->detachFromCharacter($Character);
        }
    }
    
}