<?php

/*
 *  Handles some basic buffs and debuff functionalities for 
 *  Item, Effect, (passive) Skill and other Model classes
 */

class CharacterModifierBehavior extends CBehavior {
    
    public function attachToCharacter($character) {
	/*
        - dropCash/Favours/Kudos Abs/Perc
	- dropItem Perc
        - gainXp/Resoluteness/Willpower/Cunning Abs/Perc
        */
        
        if($this->owner->hp != 0 || $this->owner->hpPerc != 0) {
            $character->onCalcHp = array($this, 'reactToOnCalcHp');
        }
        if($this->owner->energy != 0 || $this->owner->energyPerc != 0) {
            $character->onCalcEnergy = array($this, 'reactToOnCalcEnergy');
        }
        if($this->owner->resoluteness != 0 || $this->owner->resolutenessPerc != 0) {
            $character->onCalcResoluteness = array($this, 'reactToOnCalcResoluteness');
        }
        if($this->owner->willpower != 0 || $this->owner->willpowerPerc != 0) {
            $character->onCalcWillpower = array($this, 'reactToOnCalcWillpower');
        }
        if($this->owner->cunning != 0 || $this->owner->cunningPerc != 0) {
            $character->onCalcCunning = array($this, 'reactToOnCalcCunning');
        }
        if($this->owner->dropCash != 0 || $this->owner->dropCashPerc != 0) {
            $character->onGainingCash = array($this, 'reactToOnGainingCash');
        }
        if($this->owner->dropFavours != 0 || $this->owner->dropFavoursPerc != 0) {
            $character->onGainingFavours = array($this, 'reactToOnGainingFavours');
        }
        if($this->owner->dropKudos != 0 || $this->owner->dropKudosPerc != 0) {
            $character->onGainingKudos = array($this, 'reactToOnGainingKudos');
        }
        if($this->owner->dropItemPerc != 0) {
            $character->onCalcDropItemBonus = array($this, 'reactToOnCalcDropItemBonus');
        }
    }

    public function reactToOnCalcHp($event) { 
        $event->params['bonusAbs'] += $this->owner->hp;
        $event->params['bonusPerc'] += $this->owner->hpPerc;
    }
    public function reactToOnCalcEnergy($event) { 
        $event->params['bonusAbs'] += $this->owner->energy;
        $event->params['bonusPerc'] += $this->owner->energyPerc;
    }
    public function reactToOnCalcResoluteness($event) { 
        $event->params['bonusAbs'] += $this->owner->resoluteness;
        $event->params['bonusPerc'] += $this->owner->resolutenessPerc;
    }
    public function reactToOnCalcWillpower($event) { 
        $event->params['bonusAbs'] += $this->owner->willpower;
        $event->params['bonusPerc'] += $this->owner->willpowerPerc;
    }
    public function reactToOnCalcCunning($event) { 
        $event->params['bonusAbs'] += $this->owner->cunning;
        $event->params['bonusPerc'] += $this->owner->cunningPerc;
    }    

    /* standard behavior is to react to gains from battles only
     * Can be "overwritten" by special behaviors
     * params: amount (read only)
     *         from    enum    battle, encounter, quest, ...
     *         bonusAbs, bonusPerc
     */
    public function reactToOnGainingCash($event, $acceptFrom = array('battle')) {
        if(in_array($event->params['from'], $acceptFrom)) {
            $event->params['bonusAbs'] += $this->owner->dropCash;
            $event->params['bonusPerc'] += $this->owner->dropCashPerc;
        }
    }
    public function reactToOnGainingFavours($event, $acceptFrom = array('battle')) {
        if(in_array($event->params['from'], $acceptFrom)) {
            $event->params['bonusAbs'] += $this->owner->dropFavours;
            $event->params['bonusPerc'] += $this->owner->dropFavoursPerc;
        }
    }
    public function reactToOnGainingKudos($event, $acceptFrom = array('battle')) {
        if(in_array($event->params['from'], $acceptFrom)) {
            $event->params['bonusAbs'] += $this->owner->dropKudos;
            $event->params['bonusPerc'] += $this->owner->dropKudosPerc;
        }
    }
    
    public function reactToOnCalcDropItemBonus($event) {
        $event->params['bonusPerc'] += $this->owner->dropItemPerc;
    }
    
    // ToDo: Some nice text based on the modifications of owner
    public function getPopup() { 
        return $this->owner->desc; 
    }

}