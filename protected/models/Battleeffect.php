<?php

Yii::import('application.models._base.BaseBattleeffect');

/*
 *       use Specialness Behavior design
 *       define basic methods
 */

class Battleeffect extends BaseBattleeffect {
    
    // hero => the combatant under whose name the effect appears
    public $heroString;
    public $enemyString;
    
    // bool
    // inactive effects will be erased and detached by battle's sleep procedure
    public $active;

    /* 
     *  Not used by all skills
     */
    // To keep track of "counters" of all sort
    public $charges = 0;
    // To keep track of the lifespan, if appropriate. 
    // -1 means that the effect holds indefinitely
    public $turns = -1;
    
    // Set to true once the effect is added to the BattleModel
    // Used to decide whether or not the skill that creates this effect
    // should log a battle action or not
    public $added = false;
    
    // return: added, increasedDuration, notAdded
    public function initialize($battle, $hero, $enemy, $options = array()) {
        $options = array_merge(
            // The default options
            array(
                'autoAttach' => true,
                'turns' => $this->turns,
            ),
            // The specified options
            $options
        );        

        // hero = skill user that brings this effect into place
        // Adjust so that heroString is the owner of the buff/debuff
        if($this->buff) {
            $this->heroString = $battle->getCombatantString($hero);
            $this->enemyString = $battle->getCombatantString($enemy);
        } else {
            $this->heroString = $battle->getCombatantString($enemy);
            $this->enemyString = $battle->getCombatantString($hero);
        }
        
        $this->active = true;
        $this->turns = $options['turns'];

        if($this->blocks && $this->blockNumberOfBlocks > 0) {
            $this->charges = $this->blockNumberOfBlocks;
        }
        
        // Adds the effect in case it's not already active
        //     Unless the effect should only be active once per combatant,
        //         in which case the duration will be increased
        if($options['autoAttach']) {
            if(!$this->singleton || !$battle->battleeffects->contains($this)) {
                $battle->addEffect($this);
                return "added";
            } elseif ($this->increaseDuration) {
                $battle->increaseEffectDuration($this);
                return "increasedDuration";
            }
        }
        return "notAdded";
    }

    // basic getters
    public function getPopup() { 
        if($this->blocks) {
            return $this->desc . "<BR />&nbsp;<BR />" . 
                "<b>Blocks" . 
                    ($this->blockNumberOfBlocks > 0 ? " the next " . $this->numberOfBlocks : "") .
                    $this->blockActionTypes . " actions" . 
                ($this->blockChance < 1 ? " with a chance of " . floor($this->blockChance * 100) . "%" : "") . 
                ($this->turns > 0 ? " within the next " . $this->turns . " rounds" : "") .
                ".";
        }
        return $this->desc; 
    }

    public function getTurns() { return $this->turns; }
    public function getCharges() { return $this->charges; }
    public function getLogDetails() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'buff' => $this->buff,
            'desc' => $this->desc,
            'popup' => $this->call("getPopup"),
        );
    }

    
    // Overwrite by using these commands:
    /*
        $battle->onBeforeAction = array($this, 'reactToOnBeforeAction');
        $battle->onAfterAction = array($this, 'reactToOnAfterAction');
        $battle->onBeforeDealingDamage = array($this, 'reactToOnBeforeDealingDamage');
        $battle->onAfterDealingDamage = array($this, 'reactToOnAfterDealingDamage');
        $battle->onBeforeTakingDamage = array($this, 'reactToOnBeforeTakingDamage');
        $battle->onAfterTakingDamage = array($this, 'reactToOnAfterTakingDamage');
    */
    public function attachToBattle($battle) {
        $battle->onAfterRound = array($this, 'reactToOnAfterRound');
        if($this->blocks) {
            $battle->onBeforeAction = array($this, 'reactToOnBeforeAction');
        }
    }

    // Overwrite / extend as necessary
    public function reactToOnBeforeRound($event) { }
    public function reactToOnAfterRound($event) {
        $this->turns --;
        if($this->turns == 0) {
            $this->active = 0;

            $battleMsg = new Battlemessage(sprintf($this->msgExpire, $event->sender->{$this->heroString}->name));
            $event->sender->log($event->sender->{$this->heroString}, $battleMsg);
        }
    }
    /*
     *  ToDo: check typeOfActions
     */
    public function reactToOnBeforeAction($event) {
        if($this->blocks &&
           $this->active &&
           $event->sender->getCombatantString($event->params['hero']) == $this->heroString &&
           !$event->params['action']->blocked) {
            
            if($this->blockChance != 1) {
                $rand = mt_rand(0,100);
                if($rand > $this->blockChance * 100) {
                    return;
                }
            }
            
            if($event->params['action']->call("setBlocked")) {
                $this->blockNumberOfBlocks --;
                $this->charges --;
                
                $battleMsg = new Battlemessage(sprintf($this->msgBlock, $event->params['hero']->name, $event->params['action']->name));
                $event->sender->log($event->params['hero'], $battleMsg);
                        
                if($this->blockNumberOfBlocks == 0) {
                    $this->active = false;

                    $battleMsg = new Battlemessage(sprintf($this->msgExpire, $event->params['hero']->name));
                    $event->sender->log($event->params['hero'], $battleMsg);
                }
            }
        }
    }
    public function reactToOnAfterAction($event) { }
    public function reactToOnBeforeDealingDamage($event) { }
    public function reactToOnAfterDealingDamage($event) { }
    public function reactToOnBeforeTakingDamage($event) { }
    public function reactToOnAfterTakingDamage($event) { }

    public function behaviors() {
        return array("application.components.SpecialnessBehavior");
    }
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}