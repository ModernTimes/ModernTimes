<?php

class Tools extends CApplicationComponent {
    
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
        
    function spendAction () {
        $character = CD();
        $character->actions--;
        
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
    
    /*
     * effect  mixed  int    => effect model id
     *                name   => effect model name
     *                object => effect model AR
     * turns   int    Number of turns that the effect is in place
     *                0 means that it is a battle effect which will not be written
     *                into the db
     * options
     * 'addTurns'    bool  Whether to increase the number of turns when the effect
     *                     is already in place. Default is true
     * 'characterID' int   which character the effect has to be attached to
     *                     Default is current character
     *
     * * ToDo:        Effects to other players
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
        } else {
            return false;
        }
        
        $character = CD();
        
        if ($character->hasEffect($effectModel)) {
            if($options['addTurns']) {
                $effectInPlace = $character->getEffect($effectModel);
                $effectInPlace->increaseTurns($turns);
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