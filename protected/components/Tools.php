<?php

/**
 * Defines a number of global utility functions
 * 
 * @link http://www.yiiframework.com/doc/api/1.1/CApplicationComponent
 * @package System.Tools
 */

class Tools extends CApplicationComponent {
    
    /**
     * Called by Yii preloader
     * Used to initialize aliases for Yii::app()->tools->getXPronoun
     * @return void
     */
    public function init() {
        if (!function_exists('_personal')) {
            function _personal($sex = null) {
                return Yii::app()->tools->getPersonalPronoun($sex);
            }
        }
        if (!function_exists('_possessive')) {
            function _possessive($sex = null) {
                return Yii::app()->tools->getPossessivePronoun($sex);
            }
        }
        if (!function_exists('_objective')) {
            function _objective($sex = null) {
                return Yii::app()->tools->getObjectPronoun($sex);
            }
        }
    }
    
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
     * Returns information about the last place as an array:
     * id (actionID), name
     * default: id: map, name: London
     * @return array
     */
    function getLastPlace() {
        if(!empty(Yii::app()->session['lastPlace'])) {
            return Yii::app()->session['lastPlace'];
        } else {
            return array(
                "id" => array("map"), 
                "name" => "London"
            );
        }
    }
    /**
     * Returns a Yii route to the last safe action
     * default: array('map')
     * @return array
     */
    function getLastPlaceRoute() {
        if(!empty(Yii::app()->session['lastPlace'])) {
            return Yii::app()->session['lastPlace']['route'];
        } else {
            return array("map");
        }
    }
    /**
     * Returns the name of the last place visited by the character
     * default: London
     * @return string
     */
    function getLastPlaceName() {
        if(!empty(Yii::app()->session['lastPlace'])) {
            return Yii::app()->session['lastPlace']['name'];
        } else {
            return "London";
        }
    }

    /**
     * - Decreases the number of available turns by 1
     * - Reduces the duration of active effects by 1
     * - Reduces the delay of encounters in the encounter queue by 1
     * @todo Rework! Add spendTurn method in Character. Let that method raise an
     * onSpendTurn event. Let characterEffects and characterEncounters hook 
     * into onSpendTurn.
     */
    function spendTurn () {
        $Character = CD();
        $Character->turns--;
        
        // @todo use updateAll queries. This is insane.
        
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
                $effectInPlace = $Character->getCharacterEffect($Effect);
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
                $Character->addCharacterEffect($CharacterEffect);
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
     * Verbal representation of a given resistance level
     * @todo much nicer representation pls
     * @param int $level
     * @return string 
     */
    public function getResistanceLevelLabel($level) {
        switch($level) {
            case 1:
                return "Minimal";
            case 2:
                return "Some";
            case 3:
                return "OKish";
            default:
                return "Superb";
        }
    }
    
    /**
     * Returns the possessive pronoun for a given sex
     * @param string $sex enum(male|female|null)
     * @return string enum(his|her|their)
     */
    public function getPossessivePronoun($sex = null) {
        switch($sex) {
            case "male":
                return "his";
            case "female":
                return "her";
            default:
                return "their";
        }
    }
    
    /**
     * Returns the personal pronoun for a given sex
     * @param string $sex enum(male|female|null)
     * @return string enum (he|she|they)
     */
    public function getPersonalPronoun($sex = null) {
        switch($sex) {
            case "male":
                return "he";
            case "female":
                return "she";
            default:
                return "they";
        }
    }
    
    /**
     * Returns a pronoun for the given sex in object form
     * @param string $sex enum(male|female|null)
     * @return string enum (him|her|them)
     */
    public function getObjectPronoun($sex = null) {
        switch($sex) {
            case "male":
                return "him";
            case "female":
                return "her";
            default:
                return "them";
        }
    }    
    
    /**
     * Adds "a " or "an " to a string based on the first letter of $string
     * @param string $string
     * @return string
     */
    public function addIndefArticle($string) {
        $vowels = array('a', 'e', 'i', 'o', 'u');
        return (in_array(substr($string, 0, 1), $vowels) ? "an " : "a ") . $string;
        
    }
    
}