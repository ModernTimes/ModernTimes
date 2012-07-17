<?php

/**
 * hero is the babble skill user
 * 
 * Mechanics:
 * - all skills of subtype babbling add BabbleComboEffect with charges = 1 or
 *   increase charges by 1 if BabblecomboEffect is already in place
 * - skills of subtype babbling do more damage: *= pow(base, charges)
 * - If hero uses a skill of subtype != babbling, BabblecomboEffect 
 *   is lost
 */

class BabbleComboEffect extends CBehavior {

    const BabbleComboEffect_base = 1.1;
    
    public function attachToBattle($battle) {
        $this->owner->attachToBattle($battle);
        $battle->onAfterAction = array($this, 'reactToOnAfterAction');
        $battle->onBeforeDealingDamage = array($this, 'reactToOnBeforeDealingDamage');
    }

    // Shows the damage increasing effect for babbling akills in %.
    public function getPopup() {
        return $this->owner->desc . "<BR />&nbsp;<BR /><b>" . 
               floor(pow(self::BabbleComboEffect_base, $this->owner->charges) * 100 - 100) . 
               "% more obnoxious already!</b>";
    }
    
    /**
     * Damage of skills with subtype babbling increases exponentially,
     * depending on charges
     */
    public function reactToOnBeforeDealingDamage($event) {
        if($this->owner->active &&
           $event->params['battle']->getCombatantString($event->params['hero']) == $this->owner->heroString &&
           $event->sender->owner->subType == "babbling") {
            
            $event->params['damage'] = $event->params['damage'] * 
                                       pow(self::BabbleComboEffect_base, $this->owner->charges);
        }
    }

    /**
     * ... until the ComboEffect is interrupted by a non-babbling skill
     * the function also increases charges by 1 in case hero uses another skill of subtype babbling
     */
    public function reactToOnAfterAction($event) {
        if($event->sender->getCombatantString($event->params['hero']) == $this->owner->heroString) {
            if ($event->params['action']->actionType == "personal" &&
                $event->params['action']->subType != "babbling") {
            
                    $this->owner->active = false;

                    $battleMsg = new Battlemessage($event->params['hero'] . " loses " . Yii::app()->tools->getPossessivePronoun($event->params['hero']) . " babble momentum");
                    $event->sender->log($event->params['hero'], $battleMsg);
            }
            
            // Increase charges if hero uses another babbling skill
            if ($event->params['action']->actionType == "personal" &&
                $event->params['action']->subType == "babbling") {
                
                $this->owner->charges++;

                $battleMsg = new Battlemessage("", $event->params['action']);
                if($this->owner->charges == 1) {
                    $battleMsg->msg = $event->params['hero']->name . " builds up some babble momentum";
                    $event->sender->log($event->params['hero'], $battleMsg);
                } else {
                    // $battleMsg->msg = $event->params['hero']->name . " increases " . Yii::app()->tools->getPossessivePronoun($event->params['hero']) . " babble momentum";
                    // $event->sender->log($event->params['hero'], $battleMsg);
                }
            }
        }
    }
}