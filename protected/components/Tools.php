<?php

/**
 * Defines a number of global utility functions
 * 
 * @link http://www.yiiframework.com/doc/api/1.1/CApplicationComponent
 * @package System.Tools
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
     * - Decreases the number of available turns by 1
     * - Reduces the duration of active effects by 1
     * - Reduces the delay of encounters in the encounter queue by 1
     * @todo ask for Character record in parameters to make dependency injection
     * and spending turns on other characters possible
     */
    function spendTurn () {
        $Character = CD();
        $Character->turns--;
        
        foreach($Character->characterEffects as $CharacterEffect) {
            $CharacterEffect->turns--;
            if($CharacterEffect->turns == 0) {
                $CharacterEffect->delete();
            } else {
                $CharacterEffect->update();
            }
        }
        foreach($Character->characterEncounters as $CharacterEncounter) {
            if($CharacterEncounter->delay > 0) {
                $CharacterEncounter->delay --;
                $CharacterEncounter->update();
            }
        }
    }
    
    /**
     * Adds an effect to a character
     * @param Character $Character Character record that the effect is to be
     * added to
     * @param mixed $effect Effect|int|string Effect model or its PK or its name
     * @param int $turns number of turns for which the effect is to be active
     *                   0 means that it is only used during the current battle
     * @param array $options
     * param bool 'addTurns', whether to increase the number of turns when the 
     *                         effect is already in place instead of adding a 
     *                         second effect of the same kind. Default is true.
     * 
     * @return boolean whether or not the effect was added
     */
    function addEffect($Character, $Effect, $turns = 0, $options = array()) {
        $options = array_merge(
            // The default options
            array(
                'addTurns' => true
            ),
            // The specified options
            $options
        );
        
        // d($effect);

        if ($turns == 0) {
            Yii::trace("Cannot add effect with duration of 0 turns");
            return false;
        }
        
        if(is_int($Effect)) {
            $Effect = Effect::model()->findByPk($Effect);
        } elseif (is_string($Effect)) {
            $Effect = Effect::model()->find("name = '" . $Effect . "'");
        }
        if(!is_a($Effect, "Effect")) {
            return false;
        }
        
        if ($Character->hasEffect($Effect)) {
            if($options['addTurns']) {
                // returns CharacterEffects model, not Effect model
                $effectInPlace = $Character->getEffect($Effect);
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
            $CharacterEffect = new CharacterEffects();
            $CharacterEffect->characterID = $Character->id;
            $CharacterEffect->effectID = $Effect->id;
            $CharacterEffect->effect = $Effect;
            $CharacterEffect->turns = $turns;
            
            if ($CharacterEffect->save()) {
                $Character->addEffect($CharacterEffect);
                Yii::trace("Added effect '" . $Effect->name . "' for " . $turns . " turns");
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * Returns a new CDbTransaction or returns the currently active one
     * @return CDbTransaction
     */
    public function getTransaction() {
        $transaction = Yii::app()->db->getCurrentTransaction();
        if(empty($transaction)) {
            $transaction = Yii::app()->db->beginTransaction();
        }
        return $transaction;
    }
    
    /**
     * Returns the possessive pronoun for a given character
     * @param Character $character, default is the active character
     * @return string "his" or "her"
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
     * @return string "he" or "she"
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