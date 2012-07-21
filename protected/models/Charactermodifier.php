<?php

Yii::import('application.models._base.BaseCharactermodifier');

/**
 * Data basis for Charactermodifier behavior for items, skills, etc.
 * Adds a couple of standard event listeners to stat calculation events in 
 * the Character model.
 *
 * implemented so far:
 * - dropCash/Favours/Kudos Abs/Perc
 * - dropItem Perc
 * @todo gainXp/Resoluteness/Willpower/Cunning Abs/Perc
 *
 * If you add more event handlers, don't forget to add a line to
 * detachFromCharacter()
 * 
 * Can be "overridden" by specialness behavior classes for items, skills, etc.
 * 
 * See BaseCharactermodifier for a list of attributes and related Models
 * 
 * @see CharacterModifierBehavior
 * @see SpecialnessBehavior
 * @package Character
 */

class Charactermodifier extends BaseCharactermodifier {

    /**
     * Attach this class's event handlers to the Character's events
     * 
     * "$component->onXXX = y" is the same as "$component->onXXX->add(y)"
     * 
     * @param Character $Character
     */
    public function attachToCharacter($Character) {
        if($this->hp != 0 || $this->hpPerc != 0) {
            $Character->onCalcHp = array($this, 'reactToOnCalcHp');
        }
        if($this->energy != 0 || $this->energyPerc != 0) {
            $Character->onCalcEnergy = array($this, 'reactToOnCalcEnergy');
        }
        if($this->resoluteness != 0 || $this->resolutenessPerc != 0) {
            $Character->onCalcResoluteness = array($this, 'reactToOnCalcResoluteness');
        }
        if($this->willpower != 0 || $this->willpowerPerc != 0) {
            $Character->onCalcWillpower = array($this, 'reactToOnCalcWillpower');
        }
        if($this->cunning != 0 || $this->cunningPerc != 0) {
            $Character->onCalcCunning = array($this, 'reactToOnCalcCunning');
        }
        if($this->dropCash != 0 || $this->dropCashPerc != 0) {
            $Character->onGainingCash = array($this, 'reactToOnGainingCash');
        }
        if($this->dropFavours != 0 || $this->dropFavoursPerc != 0) {
            $Character->onGainingFavours = array($this, 'reactToOnGainingFavours');
        }
        if($this->dropKudos != 0 || $this->dropKudosPerc != 0) {
            $Character->onGainingKudos = array($this, 'reactToOnGainingKudos');
        }
        if($this->dropItemPerc != 0) {
            $Character->onCalcDropItemBonus = array($this, 'reactToOnCalcDropItemBonus');
        }
    }

    /**
     * Detach this class's event handlers from the Character's events
     * 
     * @param Character $Character
     */
    public function detachFromCharacter($Character) {
        $Character->detachEventHandler("onCalcHp", array($this, 'reactToOnCalcHp'));
        $Character->detachEventHandler("onCalcEnergy", array($this, 'reactToOnCalcEnergy'));

        $Character->detachEventHandler("onCalcResoluteness", array($this, 'reactToOnCalcResoluteness'));
        $Character->detachEventHandler("onCalcWillpower", array($this, 'reactToOnCalcWillpower'));
        $Character->detachEventHandler("onCalcCunning", array($this, 'reactToOnCalcCunning'));

        $Character->detachEventHandler("onGainingCash", array($this, 'reactToOnGainingCash'));
        $Character->detachEventHandler("onGainingFavours", array($this, 'reactToOnGainingFavours'));
        $Character->detachEventHandler("onGainingKudos", array($this, 'reactToOnGainingKudos'));
        
        $Character->detachEventHandler("onCalcDropItemBonus", array($this, 'reactToOnCalcDropItemBonus'));
    }    
    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc according to the Model record's attributes
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcHp($event) { 
        $event->increaseBonusAbs($this->hp);
        $event->increaseBonusPerc($this->hpPerc);
    }
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc according to the Model record's attributes
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcEnergy($event) { 
        $event->increaseBonusAbs($this->energy);
        $event->increaseBonusPerc($this->energyPerc);
    }
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc according to the Model record's attributes
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResoluteness($event) { 
        $event->increaseBonusAbs($this->resoluteness);
        $event->increaseBonusPerc($this->resolutenessPerc);
    }
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc according to the Model record's attributes
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcWillpower($event) { 
        $event->increaseBonusAbs($this->willpower);
        $event->increaseBonusPerc($this->willpowerPerc);
    }
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc according to the Model record's attributes
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcCunning($event) { 
        $event->increaseBonusAbs($this->cunning);
        $event->increaseBonusPerc($this->cunningPerc);
    }    

    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc according to the Model record's attributes
     * Only reacts to gains from battles
     * @param GainStatEvent $event with BonusCollectorBehavior
     * @param array $acceptedSources list of scenarios in which the event observer
     * should do its work
     */
    public function reactToOnGainingCash($event, $acceptedSources = array('battle')) {
        if(in_array($event->params['from'], $acceptedSources)) {
            $event->increaseBonusAbs($this->dropCash);
            $event->increaseBonusPerc($this->dropCashPerc);
        }
    }
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc according to the Model record's attributes
     * Only reacts to gains from battles
     * @param GainStatEvent $event with BonusCollectorBehavior
     * @param array $acceptedSources list of scenarios in which the event observer
     * should do its work
     */
    public function reactToOnGainingFavours($event, $acceptedSources = array('battle')) {
        if(in_array($event->params['from'], $acceptedSources)) {
            $event->increaseBonusAbs($this->dropFavours);
            $event->increaseBonusPerc($this->dropFavoursPerc);
        }
    }
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc according to the Model record's attributes
     * Only reacts to gains from battles
     * @param GainStatEvent $event with BonusCollectorBehavior
     * @param array $acceptedSources list of scenarios in which the event observer
     * should do its work
     */
    public function reactToOnGainingKudos($event, $acceptedSources = array('battle')) {
        if(in_array($event->params['from'], $acceptedSources)) {
            $event->increaseBonusAbs($this->dropKudos);
            $event->increaseBonusPerc($this->dropKudosPerc);
        }
    }
    
    /**
     * Basic event handler
     * Adds bonusPerc according to the Model record's attributes
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcDropItemBonus($event) {
        $event->increaseBonusPerc($this->dropItemPerc);
    }
    
    
    /**
     * Factory method to get Model objects
     * @see http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}