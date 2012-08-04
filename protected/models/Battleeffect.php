<?php

Yii::import('application.models._base.BaseBattleeffect');
Yii::import('application.components.battleeffects.*');

/**
 * Defines basic Battleeffect behavior, which includes
 * - basic blocking mechanics (chance, types of actions, number of blocks,
 *                             active for a number of turns)
 * Can be "overridden" via the usual SpecialnessBehavior method
 * 
 * See BaseBattleeffect for a list of attributes and related Models
 * 
 * @todo add more basic effect mechanics
 * @uses SpecialnessBehavior
 * @package Battle
 */

class Battleeffect extends BaseBattleeffect {
    
    /**
     * string identifier of hero, under whose name the effect appears
     * @var string enum(combatantA|combatantB)
     */
    public $heroString;
    /**
     * string identifier of enemy
     * @var string enum(combatantA|combatantB)
     */
    public $enemyString;
    
    /**
     * inactive effects will be erased and detached by battle's sleep procedure
     * @see Battle->__sleep
     * @var bool
     */
    public $active;

    /** 
     * The following properties are not used by all skills
     */

    /**
     * Keeps track of "counters" of all sort
     * Specific use depends on the skill in question
     * @var int
     */
    public $charges = 0;

    /**
     * Keeps track of the lifespan of the Battleeffect
     * -1 means that the effect holds indefinitely
     * @var int
     */
    public $turns = -1;
    
    /**
     * Set to true once the effect is added to the Battle record
     * Used to decide whether or not the skill that creates this effect
     * should log a battle action or not
     * @var bool
     */
    public $added = false;
    
    /**
     * Initializes the Battleeffect
     * Attaches itself to the Battle, or increases the duration of an
     * existing (same) Battleeffect 
     * @param Battle $battle
     * @param CombatantBehavior $hero Model record with CombatantBehavior
     * @param CombatantBehavior $enemy Model record with CombatantBehavior
     * @param array $options 
     * @return string enum(added|increasedDuration|notAdded)
     */
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

        /**
         * up to this point: hero = combatant who brought this effect into play
         * adjust so that heroString is the owner of the buff/debuff
         */
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
        
        /**
         * Adds the effect in case it's not already active
         * Unless the effect should only be active once per combatant,
         * in which case the duration will be increased
         */
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

    /**
     * Returns a string that can be used as the ocntent of a popup for
     * the Battleeffect
     * @return string 
     */
    public function getPopup() { 
        if($this->blocks) {
            return $this->desc . "<BR />&nbsp;<BR />" . 
                "<b>Blocks" . 
                    ($this->blockNumberOfBlocks > 0 ? " the next" . $this->numberOfBlocks : "") .
                    " " . $this->blockActionTypes . " actions" . 
                ($this->blockChance < 1 ? " with a chance of " . floor($this->blockChance * 100) . "%" : "") . 
                ($this->turns > 0 ? " within the next " . $this->turns . " rounds" : "") .
                ".";
        }
        return $this->desc;
    }
    
    public function getMsgBlock() {
        return $this->msgBlock;
    }

    /**
     * Basic getter
     * @return int 
     */
    public function getTurns() { 
        return $this->turns; 
    }
    /**
     * Basic getter
     * @return int 
     */
    public function getCharges() { 
        return $this->charges; 
    }
    /**
     * Returns an array with log details that can be part of a BattleMessage
     * Includes id, name, buff, desc, and popup
     * @see BattleMessage
     * @return array
     */
    public function getLogDetails() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'buff' => $this->buff,
            'desc' => $this->desc,
            'popup' => $this->call("getPopup"),
        );
    }

    
    /** 
     * Attaches the Battleeffect to the Battle
     * @todo Add more event handlers once Battleeffects can handle more stuff
     * "Override" by specialness classes by using these commands:
     * $battle->onBeforeAction = array($this, 'reactToOnBeforeAction');
     * $battle->onAfterAction = array($this, 'reactToOnAfterAction');
     * $battle->onBeforeDealingDamage = array($this, 'reactToOnBeforeDealingDamage');
     * $battle->onAfterDealingDamage = array($this, 'reactToOnAfterDealingDamage');
     * $battle->onBeforeTakingDamage = array($this, 'reactToOnBeforeTakingDamage');
     * $battle->onAfterTakingDamage = array($this, 'reactToOnAfterTakingDamage');
     * @param Battle $battle
     */
    public function attachToBattle($battle) {
        $battle->onAfterRound = array($this, 'reactToOnAfterRound');
        if($this->blocks) {
            $battle->onBeforeAction = array($this, 'reactToOnBeforeAction');
        }
    }

    /**
     * Empty event handler. Only there to have a fallback function if
     * a SpecialnessBehavior class does not provide it.
     * "Override" and extend by SpecialnessBehavior classes as necessary
     * @param CEvent $event 
     */
    public function reactToOnBeforeRound($event) { }

    /**
     * Decreases the duration of the Battleeffect. If it goes down to 0, it
     * deactivates itself, adds a deactivation Battlemessage and waits for
     * Battle->__sleep to be destroyed
     * "Override" and extend by SpecialnessBehavior classes as necessary
     * @param CEvent $event 
     */
    public function reactToOnAfterRound($event) {
        $this->turns --;
        if($this->turns == 0) {
            $this->active = 0;

            $battleMsg = new Battlemessage(sprintf($this->msgExpire, $event->sender->{$this->heroString}->name));
            $event->sender->log($event->sender->{$this->heroString}, $battleMsg);
        }
    }
    
    /**
     * Checks if a battle action is blocked by this Battleeffect
     * "Override" and extend by SpecialnessBehavior classes as necessary
     * @todo check typeOfActions
     * @param CEvent $event 
     */
    public function reactToOnBeforeAction($event) {
        if($this->blocks &&
           $this->active &&
           $event->sender->getCombatantString($event->hero) == $this->enemyString &&
           !$event->action->blocked &&
           $event->action->battlePhase == "offense") {
            
            if($this->blockChance != 1) {
                $rand = mt_rand(0,100);
                if($rand > $this->blockChance * 100) {
                    return;
                }
            }
            
            if($event->action->call("setBlocked")) {
                $this->blockNumberOfBlocks --;
                $this->charges --;
                
                $battleMsg = new Battlemessage(sprintf($this->call("getMsgBlock"), $event->hero->name, $event->action->name));
                $event->sender->log($event->hero, $battleMsg);
                        
                if($this->blockNumberOfBlocks == 0) {
                    $this->active = false;

                    $battleMsg = new Battlemessage(sprintf($this->msgExpire, $event->hero->name));
                    $event->sender->log($event->hero, $battleMsg);
                }
            }
        }
    }
    
    /**
     * Empty event handler. Only there to have a fallback function if
     * a SpecialnessBehavior class does not provide it.
     * "Override" and extend by SpecialnessBehavior classes as necessary
     * @param CEvent $event 
     */
    public function reactToOnAfterAction($event) { }
    /**
     * Empty event handler. Only there to have a fallback function if
     * a SpecialnessBehavior class does not provide it.
     * "Override" and extend by SpecialnessBehavior classes as necessary
     * @param BattleActionDamageEvent $event 
     */
    public function reactToOnBeforeDealDamage($event) { }
    /**
     * Empty event handler. Only there to have a fallback function if
     * a SpecialnessBehavior class does not provide it.
     * "Override" and extend by SpecialnessBehavior classes as necessary
     * @param CEvent $event 
     */
    public function reactToOnAfterDealtDamage($event) { }
    /**
     * Empty event handler. Only there to have a fallback function if
     * a SpecialnessBehavior class does not provide it.
     * "Override" and extend by SpecialnessBehavior classes as necessary
     * @param CombatantTakeDamageEvent $event 
     */
    public function reactToOnBeforeTakingDamage($event) { }
    /**
     * Empty event handler. Only there to have a fallback function if
     * a SpecialnessBehavior class does not provide it.
     * "Override" and extend by SpecialnessBehavior classes as necessary
     * @param CombatantTakenDamageEvent $event 
     */
    public function reactToOnAfterTakingDamage($event) { }

    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior");
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