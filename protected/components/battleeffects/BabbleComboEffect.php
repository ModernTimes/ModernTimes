<?php

/**
 * Mechanics:
 * - all skills of subtype babbling add BabbleComboEffect with charges = 1 or
 *   increase charges by 1 if BabblecomboEffect is already in place
 * - skills of subtype babbling do more damage: *= pow(base, charges)
 * - If hero uses a skill of subtype != babbling, BabblecomboEffect 
 *   is lost
 * 
 * $this->owner is a Battleeffect
 * $this->owner's hero is the babbling skill user
 *
 * @package Battle.Battleeffects
 */

class BabbleComboEffect extends CBehavior {

    /**
     * @var float the base in "damage *= pow(base, charges)"
     */
    const BabbleComboEffect_base = 1.1;
    
    /**
     * Hooks the effect's event handlers to Battle's events
     * @param Battle $Battle 
     * @return void
     */
    public function attachToBattle($Battle) {
        $this->owner->attachToBattle($Battle);
        $Battle->onAfterAction = array($this, 'reactToOnAfterAction');
        $Battle->onBeforeDealingDamage = array($this, 'reactToOnBeforeDealingDamage');
    }

    /**
     * Returns a popup message, indicating
     * the damage increasing effect for babbling akills in %.
     * @return string
     */
    public function getPopup() {
        return $this->owner->desc . "<BR />&nbsp;<BR /><b>" . 
               floor(pow(self::BabbleComboEffect_base, $this->owner->charges) * 100 - 100) . 
               "% more obnoxious already!</b>";
    }
    
    /**
     * Increase the damage of skills with subtype babbling
     * Damage increase depends on $this->owner->charges
     * @param BattleActionDamageEvent $Event sender is a Skill
     * @return void
     */
    public function reactToOnBeforeDealingDamage($Event) {
        if($this->owner->active &&
                $Event->sender->getCombatantString($Event->hero) == $this->owner->heroString &&
                $Event->action->subType == "babbling") {
            
            $Event->increaseBonusPerc(
                    pow(self::BabbleComboEffect_base, $this->owner->charges) 
                    // increaseBonusPerc needs percentage points
                    * 100 - 100
            );
        }
    }

    /**
     * Disable BabbleComboEffect if hero uses a non-babbling skill
     * Increase charges by 1 if hero uses another babbling skill
     * @param BattleActionEvent $Event sender is a Battle record
     * @return void
     */
    public function reactToOnAfterAction($event) {
        if($this->owner->active &&
                $event->sender->getCombatantString($event->hero) == $this->owner->heroString) {
            
            if ($event->action->actionType == "personal" &&
                $event->action->subType != "babbling") {
            
                    $this->owner->active = false;

                    $battleMsg = new Battlemessage($event->hero . " loses " . Yii::app()->tools->getPossessivePronoun($event->hero) . " babble momentum");
                    $event->sender->log($event->hero, $battleMsg);
            }
            
            // Increase charges if hero uses another babbling skill
            if ($event->action->actionType == "personal" &&
                $event->action->subType == "babbling") {
                
                $this->owner->charges++;

                $battleMsg = new Battlemessage("", $event->action);
                if($this->owner->charges == 1) {
                    $battleMsg->msg = $event->hero->name . " builds up some babble momentum";
                    $event->sender->log($event->hero, $battleMsg);
                } else {
                    // $battleMsg->msg = $event->hero->name . " increases " . Yii::app()->tools->getPossessivePronoun($event->hero) . " babble momentum";
                    // $event->sender->log($event->hero, $battleMsg);
                }
            }
        }
    }
}