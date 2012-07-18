<?php

Yii::import('application.models._base.BaseCharactermodifier');

/**
 * data basis for Charactermodifier behavior for items, skills, etc.
 * adds a couple of standard event listeners to stat calculation events in 
 * the Character model
 * Can be "overridden" by specialness behavior classes for items, skills, etc.
 */

class Charactermodifier extends BaseCharactermodifier {

    /**
     * implemented so far:
     * - dropCash/Favours/Kudos Abs/Perc
     * - dropItem Perc
     * - gainXp/Resoluteness/Willpower/Cunning Abs/Perc
     *
     * @param Character $Character
     */
    public function attachToCharacter($Character) {
        if($this->hp != 0 || $this->hpPerc != 0) {
            $Character->getEventHandlers("onCalcHp")->add(array($this, 'reactToOnCalcHp'));
        }
        if($this->energy != 0 || $this->energyPerc != 0) {
            $Character->getEventHandlers("onCalcEnergy")->add(array($this, 'reactToOnCalcEnergy'));
        }
        if($this->resoluteness != 0 || $this->resolutenessPerc != 0) {
            $Character->getEventHandlers("onCalcResoluteness")->add(array($this, 'reactToOnCalcResoluteness'));
        }
        if($this->willpower != 0 || $this->willpowerPerc != 0) {
            $Character->getEventHandlers("onCalcWillpower")->add(array($this, 'reactToOnCalcWillpower'));
        }
        if($this->cunning != 0 || $this->cunningPerc != 0) {
            $Character->getEventHandlers("onCalcCunning")->add(array($this, 'reactToOnCalcCunning'));
        }
        if($this->dropCash != 0 || $this->dropCashPerc != 0) {
            $Character->getEventHandlers("onGainingCash")->add(array($this, 'reactToOnGainingCash'));
        }
        if($this->dropFavours != 0 || $this->dropFavoursPerc != 0) {
            $Character->getEventHandlers("onGainingFavours")->add(array($this, 'reactToOnGainingFavours'));
        }
        if($this->dropKudos != 0 || $this->dropKudosPerc != 0) {
            $Character->getEventHandlers("onGainingKudos")->add(array($this, 'reactToOnGainingKudos'));
        }
        if($this->dropItemPerc != 0) {
            $Character->getEventHandlers("onCalcDropItemBonus")->add(array($this, 'reactToOnCalcDropItemBonus'));
        }
    }

    public function reactToOnCalcHp($event) { 
        $event->params['bonusAbs'] += $this->hp;
        $event->params['bonusPerc'] += $this->hpPerc;
    }
    public function reactToOnCalcEnergy($event) { 
        $event->params['bonusAbs'] += $this->energy;
        $event->params['bonusPerc'] += $this->energyPerc;
    }
    public function reactToOnCalcResoluteness($event) { 
        $event->params['bonusAbs'] += $this->resoluteness;
        $event->params['bonusPerc'] += $this->resolutenessPerc;
    }
    public function reactToOnCalcWillpower($event) { 
        $event->params['bonusAbs'] += $this->willpower;
        $event->params['bonusPerc'] += $this->willpowerPerc;
    }
    public function reactToOnCalcCunning($event) { 
        $event->params['bonusAbs'] += $this->cunning;
        $event->params['bonusPerc'] += $this->cunningPerc;
    }    

    /**
     * standard behavior is to react to gains from battles only
     * Can be "overridden" by special behavior classes
     * $event->params: float amount (read only)
     *                 enum(battle, encounter, ...) from (read only)
     *                 float bonusAbs
     *                 float bonusPerc
     * @param array $acceptFrom, list of scenarios in which the event observer
     * should do its work
     */
    public function reactToOnGainingCash($event, $acceptFrom = array('battle')) {
        if(in_array($event->params['from'], $acceptFrom)) {
            $event->params['bonusAbs'] += $this->dropCash;
            $event->params['bonusPerc'] += $this->dropCashPerc;
        }
    }
    public function reactToOnGainingFavours($event, $acceptFrom = array('battle')) {
        if(in_array($event->params['from'], $acceptFrom)) {
            $event->params['bonusAbs'] += $this->dropFavours;
            $event->params['bonusPerc'] += $this->dropFavoursPerc;
        }
    }
    public function reactToOnGainingKudos($event, $acceptFrom = array('battle')) {
        if(in_array($event->params['from'], $acceptFrom)) {
            $event->params['bonusAbs'] += $this->dropKudos;
            $event->params['bonusPerc'] += $this->dropKudosPerc;
        }
    }
    
    public function reactToOnCalcDropItemBonus($event) {
        $event->params['bonusPerc'] += $this->dropItemPerc;
    }
    
    
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}