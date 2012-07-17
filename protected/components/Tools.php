<?php

/**
 * Defines a number of global utility functions
 */

class Tools extends CApplicationComponent {
    
    /**
     * returns an integer number adjacent to $number
     * 3.38 has a 38% chance to return 4 and a 62% chance to return 3.
     * @param float $number
     * @return int
     */
    function decideBetweenTwoNumbers($number) {
        $modulo = $number - floor($number);
        $number = floor($number);
        if($modulo > 0) {
            $rand = mt_rand(0, 100);
            if($rand <= $modulo * 100) {
                $number ++;
            }
        }
        return $number;
    }

    /**
     * decreases the number of available turns by 1
     * reduces the duration of active effects by 1
     */
    function spendTurn () {
        $character = CD();
        $character->turns--;
        
        foreach($character->characterEffects as $characterEffect) {
            $characterEffect->turns--;
            if($characterEffect->turns == 0) {
                $characterEffect->delete();
            } else {
                $characterEffect->update();
            }
        }
        // $character->withRelated->save(true, array("characterEffects"));
    }
    
    /**
     * Adds an effect to the active character
     * @param Effect|int|string $effect, Effect model or its PK or its name
     * @param int $turns, number of turns for which the effect is to be active
     *                    0 means that it is only used during the current battle
     * options
     * @param bool 'addTurns', whether to increase the number of turns when the 
     *                         effect is already in place instead of adding a 
     *                         second effect of the same kind. Default is true.
     * @param int 'characterID', PK of the character that the effect is to be
     *                           attached to
     * 
     * @return boolean, whether or not the effect was added
     * ToDo: Make it possible to add effects to other characters
     */
    function addEffect($effect, $turns = 0, $options = array()) {
        $options = array_merge(
            // The default options
            array(
                'addTurns' => true,
                'characterID' => CD()->id,
            ),
            // The specified options
            $options
        );
        
        // d($effect);

        if ($turns == 0) {
            Yii::trace("Cannot add effect with duration of 0 turns");
            return false;
        }
        
        if(is_int($effect)) {
            $effectModel = Effect::model()->findByPk($effect);
        } elseif (is_string($effect)) {
            $effectModel = Effect::model()->find("name = '" . $effect . "'");
        } elseif (is_a($effect, "Effect")) {
            $effectModel = $effect;
        }
        if(!is_a($effectModel, "Effect")) {
            return false;
        }
        
        $character = CD();
        
        if ($character->hasEffect($effectModel)) {
            if($options['addTurns']) {
                // returns CharacterEffects model, not Effect model
                $effectInPlace = $character->getEffect($effectModel);
                $effectInPlace->increaseDuration($turns);
                if ($effectInPlace->save()) {
                    Yii::trace("Effect already in place, increased turns by " . $turns);
                    return true;
                } else {
                    return false;
                }
            } else {
                Yii::trace("Effect already in place, nothing to do here");
            }
        } else {
            $characterEffect = new CharacterEffects();
            $characterEffect->characterID = $character->id;
            $characterEffect->effectID = $effectModel->id;
            $characterEffect->effect = $effectModel;
            $characterEffect->turns = $turns;
            
            if ($characterEffect->save()) {
                $character->addEffect($characterEffect);
                Yii::trace("Added effect '" . $effectModel->name . "' for " . $turns . " turns");
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * Returns the possessive pronoun for a given character
     * @param Character $character, default is the active character
     * @return string, "his" or "her"
     */
    public function getPossessivePronoun($character = null) {
        if(empty($character)) {
            $character = CD();
        }
        if($character->sex == 'male') {
            return "his";
        } else {
            return "her";
        }
    }
    
    /**
     * Returns the personal pronoun for a given character
     * @param Character $character, default is the active character
     * @return string, "he" or "she"
     */
    public function getPersonalPronoun($character = null) {
        if(empty($character)) {
            $character = CD();
        }
        if($character->sex == 'male') {
            return "he";
        } else {
            return "she";
        }
    }
    
}