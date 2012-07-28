<?php

Yii::import('application.models._base.BaseEncounter');

/**
 * Handles basic encounter procedures.
 * Can be "overridden" by specialnessBehavior classes
 * 
 * See BaseEncounter for a list of attributes and related Models.
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterModifierBehavior
 * @uses Charactermodifier
 * @package System.Models
 */

class Encounter extends BaseEncounter {
    
    /**
     * Resolves an Encounter
     * @todo split into smaller parts, so that specialnessBehavior classes can 
     * call these smaller __parent-methods?
     */
    public function run($Character) {
        $Character->gainCash($this->gainCash);
        $Character->gainFavours($this->gainFavours);
        $Character->gainKudos($this->gainKudos);
        
        $Character->gainXp($this->gainXp);
        $Character->gainResoluteness($this->gainResoluteness);
        $Character->gainWillpower($this->gainWillpower);
        $Character->gainCunning($this->gainCunning);

        // Items
        $Character->gainItems($this->call('dropItems'));
    
        // Does the encounter cost a turn?
        if($this->costsTurn) {
            Yii::app()->tools->spendTurn();
        }

        // Effect
        if(is_a($this->effect, "Effect")) {
            // Add the effect after the action is spent, to prevent its duration being decreased by 1 immediately
            Yii::app()->tools->addEffect($Character, $this->effect, $this->effectDuration);
        }

        /**
         * Choice-Encounter: user can't escape but must choose one option
         * No choice-encounter: any potentially ongoing encounters are finished
         */
        if($this->isChoiceEncounter()) {
            $Character->ongoingEncounterID = $this->id;
        } else {
            $Character->ongoingEncounterID = null;
        }
    }
        
    /** 
     * Checks if the Encounter leads to further Encounters, i.e. if
     * the Encounter path of this Encounter is not yet finished
     * If there are two or more encounters originating from an encounter,
     * the actual path is usually based on the player's choice. It can also be
     * based on some kind of algorithm, though.
     * @see EncounterEncounters
     * @return bool
     */
    public function isChoiceEncounter() {
        return (count($this->encounterEncounters) > 0);
    }
    
    /**
     * Returns a list of Items that the Character finds during the Encounter
     * @see EncounterItems
     * @return array of Item records
     */
    public function dropItems() {
        $loot = array();
        foreach($this->encounterItems as $encounterItem) {
            $prob = max(0, min(1, $encounterItem->prob));
            $rand = mt_rand(0, 1000000);
            if($rand <= $prob * 1000000) {
                $loot[] = $encounterItem->item;
            }
        }
        return $loot;
    }        
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     );
    }
    
    /**
     * Returns the declaration of named scopes. A named scope represents a query
     * criteria that can be chained together with other named scopes and applied
     * to a query.
     * @link http://www.yiiframework.com/doc/api/1.1/CActiveRecord#scopes-detail
     * @return array the scope definition. The array keys are scope names
     */
    public function scopes() {
        return array(
            'withRelated' => array(
                'with' => array(
                    'effect' => array(
                        'alias' => 'encounterEffect' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'encounterEncounters' => array(
                        'alias' => 'encounterEncounterEncounters' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'encounterItems' => array(
                        'alias' => 'encounterEncounterItems' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                )
            ),
        );
    }

    /**
     * Factory method to get Model objects
     * @link http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}