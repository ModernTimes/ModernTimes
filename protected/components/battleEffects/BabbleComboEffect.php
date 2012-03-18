<?php

/*
 *   hero: babble skill user
 */

class BabbleComboEffect extends CBehavior {
    
    const BabbleComboEffect_base = 1.1;
    
    public function attachToBattle($battle) {
        $this->owner->attachToBattle($battle);
        $battle->onAfterAction = array($this, 'reactToOnAfterAction');
        $battle->onBeforeDealingDamage = array($this, 'reactToOnBeforeDealingDamage');
    }

    public function getPopup() {
        return $this->owner->desc . "<BR />&nbsp;<BR /><b>" . 
               floor(pow(self::BabbleComboEffect_base, $this->owner->charges) * 100 - 100) . 
               "% more obnoxious already!</b>";
    }
    
    /*
     *  Damage increases exponentially
     */
    public function reactToOnBeforeDealingDamage($event) {
        if($this->owner->active &&
           $event->params['battle']->getCombatantString($event->params['hero']) == $this->owner->heroString &&
           $event->sender->owner->subType == "babbling") {
            
            $event->params['damage'] = $event->params['damage'] * 
                                       pow(self::BabbleComboEffect_base, $this->owner->charges);
        }
    }

    /*
     *  ... until interrupted by a non-babbling skill
     */
    public function reactToOnAfterAction($event) {
        if($event->sender->getCombatantString($event->params['hero']) == $this->owner->heroString) {
            if ($event->params['action']->actionType == "personal" &&
                $event->params['action']->subType != "babbling") {
            
                    $this->owner->active = false;

                    $battleMsg = new Battlemessage($event->params['hero'] . " loses " . Yii::app()->tools->getPossessivePronoun($event->params['hero']) . " babble momentum");
                    $event->sender->log($event->params['hero'], $battleMsg);
            }
            
            // Sets consecutiveBabbles to 1, as it is called after resolving the babble skill
            // that creates this effect
            if ($event->params['action']->actionType == "personal" &&
                $event->params['action']->subType == "babbling") {
                
                $this->owner->charges++;

                $battleMsg = new Battlemessage("", $event->params['action']);
                if($this->owner->charges == 1) {
                    $battleMsg->msg = $event->params['hero']->name . " builds up some babble momentum";
                } else {
                    $battleMsg->msg = $event->params['hero']->name . " increases " . Yii::app()->tools->getPossessivePronoun($event->params['hero']) . " babble momentum";
                }
                $event->sender->log($event->params['hero'], $battleMsg);
            }
        }
    }
}