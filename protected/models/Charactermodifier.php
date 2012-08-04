<?php

Yii::import('application.models._base.BaseCharactermodifier');

/**
 * Data basis for Charactermodifier behavior for items, skills, etc.
 * Adds a couple of standard event listeners to stat calculation events in 
 * the Character model.
 *
 * Implemented so far:
 * - calcAttributes
 * - calc combat stats (critChance, resistances, bonus damage)
 * - dropCash/Favours/Kudos
 * - dropItem chance
 *
 * If you add more event handlers, don't forget to add a line to
 * detachFromCharacter()
 * 
 * Can be "overridden" by specialness behavior classes for items, skills, etc.
 * 
 * See BaseCharactermodifier for a list of attributes and related Models
 * 
 * @todo gainXp/Resoluteness/Willpower/Cunning Abs/Perc
 * 
 * @uses CharacterModifierBehavior
 * @uses SpecialnessBehavior
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
            $Character->onGainCash = array($this, 'reactToonGainCash');
        }
        if($this->dropFavours != 0 || $this->dropFavoursPerc != 0) {
            $Character->onGainFavours = array($this, 'reactToonGainFavours');
        }
        if($this->dropKudos != 0 || $this->dropKudosPerc != 0) {
            $Character->onGainKudos = array($this, 'reactToonGainKudos');
        }
        if($this->dropItemPerc != 0) {
            $Character->onCalcDropItemBonus = array($this, 'reactToOnCalcDropItemBonus');
        }
        
        if($this->critChancePerc != 0) {
            $Character->onCalcCritChance = array($this, 'reactToOnCalcCritChance');
        }
        if($this->damageNormalAbs != 0 || $this->damageNormalPerc != 0) {
            $Character->onCalcBonusDamageNormal = array($this, 'reactToOnCalcBonusDamageNormal');
        }
        if($this->damageEnvyAbs != 0 || $this->damageEnvyPerc != 0) {
            $Character->onCalcBonusDamageEnvy = array($this, 'reactToOnCalcBonusDamageEnvy');
        }
        if($this->damageGreedAbs != 0 || $this->damageGreedPerc != 0) {
            $Character->onCalcBonusDamageGreed = array($this, 'reactToOnCalcBonusDamageGreed');
        }
        if($this->damageGluttonyAbs != 0 || $this->damageGluttonyPerc != 0) {
            $Character->onCalcBonusDamageGluttony = array($this, 'reactToOnCalcBonusDamageGluttony');
        }
        if($this->damageLustAbs != 0 || $this->damageLustPerc != 0) {
            $Character->onCalcBonusDamageLust = array($this, 'reactToOnCalcBonusDamageLust');
        }
        if($this->damagePrideAbs != 0 || $this->damagePridePerc != 0) {
            $Character->onCalcBonusDamagePride = array($this, 'reactToOnCalcBonusDamagePride');
        }
        if($this->damageSlothAbs != 0 || $this->damageSlothPerc != 0) {
            $Character->onCalcBonusDamageSloth = array($this, 'reactToOnCalcBonusDamageSloth');
        }
        if($this->damageWrathAbs != 0 || $this->damageWrathPerc != 0) {
            $Character->onCalcBonusDamageWrath = array($this, 'reactToOnCalcBonusDamageWrath');
        }
        
        if($this->resistanceAbs != 0) {
            $Character->onCalcResistanceAbs = array($this, 'reactToOnCalcResistanceAbs');
        }
        if($this->resistanceLevelNormal != 0) {
            $Character->onCalcResistanceLevelNormal = array($this, 'reactToOnCalcResistanceLevelNormal');
        }
        if($this->resistanceLevelEnvy != 0) {
            $Character->onCalcResistanceLevelEnvy = array($this, 'reactToOnCalcResistanceLevelEnvy');
        }
        if($this->resistanceLevelGreed != 0) {
            $Character->onCalcResistanceLevelGreed = array($this, 'reactToOnCalcResistanceLevelGreed');
        }
        if($this->resistanceLevelGluttony != 0) {
            $Character->onCalcResistanceLevelGluttony = array($this, 'reactToOnCalcResistanceLevelGluttony');
        }
        if($this->resistanceLevelLust != 0) {
            $Character->onCalcResistanceLevelLust = array($this, 'reactToOnCalcResistanceLevelLust');
        }
        if($this->resistanceLevelPride != 0) {
            $Character->onCalcResistanceLevelPride = array($this, 'reactToOnCalcResistanceLevelPride');
        }
        if($this->resistanceLevelSloth != 0) {
            $Character->onCalcResistanceLevelSloth = array($this, 'reactToOnCalcResistanceLevelSloth');
        }
        if($this->resistanceLevelWrath != 0) {
            $Character->onCalcResistanceLevelWrath = array($this, 'reactToOnCalcResistanceLevelWrath');
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

        $Character->detachEventHandler("onGainCash", array($this, 'reactToonGainCash'));
        $Character->detachEventHandler("onGainFavours", array($this, 'reactToonGainFavours'));
        $Character->detachEventHandler("onGainKudos", array($this, 'reactToonGainKudos'));
        
        $Character->detachEventHandler("onCalcDropItemBonus", array($this, 'reactToOnCalcDropItemBonus'));
        
        $Character->detachEventHandler("onCalcResistanceAbs", array($this, 'reactToOnCalcResistanceAbs'));
        $Character->detachEventHandler("onCalcResistanceLevelNormal", array($this, 'reactToOnCalcResistanceLevelNormal'));
        $Character->detachEventHandler("onCalcResistanceLevelEnvy", array($this, 'reactToOnCalcResistanceLevelEnvy'));
        $Character->detachEventHandler("onCalcResistanceLevelGreed", array($this, 'reactToOnCalcResistanceLevelGreed'));
        $Character->detachEventHandler("onCalcResistanceLevelGluttony", array($this, 'reactToOnCalcResistanceLevelGluttony'));
        $Character->detachEventHandler("onCalcResistanceLevelLust", array($this, 'reactToOnCalcResistanceLevelLust'));
        $Character->detachEventHandler("onCalcResistanceLevelPride", array($this, 'reactToOnCalcResistanceLevelPride'));
        $Character->detachEventHandler("onCalcResistanceLevelSloth", array($this, 'reactToOnCalcResistanceLevelSloth'));
        $Character->detachEventHandler("onCalcResistanceLevelWrath", array($this, 'reactToOnCalcResistanceLevelWrath'));
        
        $Character->detachEventHandler("onCalcCritChance", array($this, 'reactToOnCalcCritChance'));
        
        $Character->detachEventHandler("onCalcBonusDamageNormal", array($this, 'reactToOnCalcBonusDamageNormal'));
        $Character->detachEventHandler("onCalcBonusDamageEnvy", array($this, 'reactToOnCalcBonusDamageEnvy'));
        $Character->detachEventHandler("onCalcBonusDamageGreed", array($this, 'reactToOnCalcBonusDamageGreed'));
        $Character->detachEventHandler("onCalcBonusDamageGluttony", array($this, 'reactToOnCalcBonusDamageGluttony'));
        $Character->detachEventHandler("onCalcBonusDamageLust", array($this, 'reactToOnCalcBonusDamageLust'));
        $Character->detachEventHandler("onCalcBonusDamagePride", array($this, 'reactToOnCalcBonusDamagePride'));
        $Character->detachEventHandler("onCalcBonusDamageSloth", array($this, 'reactToOnCalcBonusDamageSloth'));
        $Character->detachEventHandler("onCalcBonusDamageWrath", array($this, 'reactToOnCalcBonusDamageWrath'));

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
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcCunning($event) { 
        $event->increaseBonusAbs($this->cunning);
        $event->increaseBonusPerc($this->cunningPerc);
    }    
    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResistanceAbs($event) { 
        $event->increaseBonusAbs($this->resistanceAbs);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResistanceLevelNormal($event) { 
        $event->increaseBonusAbs($this->resistanceLevelNormal);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResistanceLevelEnvy($event) { 
        $event->increaseBonusAbs($this->resistanceLevelEnvy);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResistanceLevelGreed($event) { 
        $event->increaseBonusAbs($this->resistanceLevelGreed);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResistanceLevelGluttony($event) { 
        $event->increaseBonusAbs($this->resistanceLevelGluttony);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResistanceLevelLust($event) { 
        $event->increaseBonusAbs($this->resistanceLevelLust);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResistanceLevelPride($event) { 
        $event->increaseBonusAbs($this->resistanceLevelPride);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResistanceLevelSloth($event) { 
        $event->increaseBonusAbs($this->resistanceLevelSloth);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcResistanceLevelWrath($event) { 
        $event->increaseBonusAbs($this->resistanceLevelWrath);
    }    
    
    /**
     * Basic event handler
     * Adds bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcCritChance($event) { 
        $event->increaseBonusPerc($this->critChancePerc);
    }    

    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcBonusDamageNormal($event) { 
        $event->increaseBonusAbs($this->damageNormalAbs);
        $event->increaseBonusPerc($this->damageNormalPerc);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcBonusDamageEnvy($event) { 
        $event->increaseBonusAbs($this->damageEnvyAbs);
        $event->increaseBonusPerc($this->damageEnvyPerc);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcBonusDamageGreed($event) { 
        $event->increaseBonusAbs($this->damageGreedAbs);
        $event->increaseBonusPerc($this->damageGreedPerc);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcBonusDamageGluttony($event) { 
        $event->increaseBonusAbs($this->damageGluttonyAbs);
        $event->increaseBonusPerc($this->damageGluttonyPerc);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcBonusDamageLust($event) { 
        $event->increaseBonusAbs($this->damageLustAbs);
        $event->increaseBonusPerc($this->damageLustPerc);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcBonusDamagePride($event) { 
        $event->increaseBonusAbs($this->damagePrideAbs);
        $event->increaseBonusPerc($this->damagePridePerc);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcBonusDamageSloth($event) { 
        $event->increaseBonusAbs($this->damageSlothAbs);
        $event->increaseBonusPerc($this->damageSlothPerc);
    }    
    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcBonusDamageWrath($event) { 
        $event->increaseBonusAbs($this->damageWrathAbs);
        $event->increaseBonusPerc($this->damageWrathPerc);
    }    
    

    /**
     * Basic event handler
     * Adds bonusAbs und bonusPerc according to the Model record's attributes
     * Only reacts to gains from battles
     * @param GainStatEvent $event with BonusCollectorBehavior
     * @param array $acceptedSources list of scenarios in which the event observer
     * should do its work
     */
    public function reactToOnGainCash($event, $acceptedSources = array('battle')) {
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
    public function reactToOnGainFavours($event, $acceptedSources = array('battle')) {
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
    public function reactToOnGainKudos($event, $acceptedSources = array('battle')) {
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
     * @link http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}