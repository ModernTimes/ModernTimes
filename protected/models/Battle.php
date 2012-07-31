<?php

Yii::import('application.models._base.BaseBattle');
Yii::import('application.components.battleEffects.*');

/**
 * Models and manages battles, both PvE and PvP
 * 
 * See BaseBattle for a list of attributes and related Models
 *
 * @todo implememnt battle phases in State pattern?
 * @todo is this class overloaded with responsibilities? How to split it up?
 * @fixme AttributesbackupBehavior is flawed; no update via $this->save() after
 * objectState is set by save-method. Workaround: use update().
 * 
 * @link http://www.yiiframework.com/extension/attributesbackupbehavior/
 * @uses BattleeffectList
 * @package Battle
 */

class Battle extends BaseBattle {

    /**
     * @var CombatantBehavior actually a Model record with a
     * CombatantBehavior attached to it (Character or Monster) 
     * @CombatantBehavior
     */
    public $combatantA;
    /**
     * @var CombatantBehavior actually a Model record with a
     * CombatantBehavior attached to it (Character or Monster) 
     * @CombatantBehavior
     */
    public $combatantB;
    
    /**
     * @var int we are in round ...
     */
    public $round = 0;
    
    /**
     * @var mixed Skill or Item to be used by CombatantA this round
     */
    public $combatantAAction;
    /**
     * @var mixed Skill or Item to be used by CombatantB this round
     */
    public $combatantBAction;
    
    /**
     * @var BattleeffectList a CTypedList of Battleeffect objects
     * @see BattleeffectList
     */
    public $battleeffects;
    
    /**
     * Saves BattleMessages to keep track of the battle history
     * Used to render the battle history view
     * round # => array
     *     combatantA => array of BattleMessages
     *      combatantB => array of BattleMessages
     * 
     * @var array 
     */
    private $_log = array(0 => array('combatantA' => array(), 'combatantB' => array()));
    
     /**
      * Starts the battle
      * Sets some initial values and inserts the record in the database
      * 
      * @todo Trigger beginningOfCombat effects
      */
     public function start() {
        // Init stuff
        $this->combatantAID = $this->combatantA->id;
        $this->combatantBID = $this->combatantB->id;

        // Decide between pve and pvp
        if(get_class($this->combatantB) == "Monster") {
            $this->combatantB->call("getReadyForBattle");
            $this->type = "monster";
        } else {
            $this->type = "pvp";
        }
        
        $this->state = "ongoing";
        $this->winnerType = 'undecided';
        
        $this->battleeffects = new BattleeffectList();
        
        
        if($this->type == "pvp") {
            // @todo Should players have first round battle messages?
        } else {
            $battleMsg = new Battlemessage(
                $this->combatantB->call("createFirstRoundCombatMessage")
            );
            $this->log($this->combatantB, $battleMsg);
        }

        // Insert new DB record
        $this->insert();
        
        // Set ongoingBattleID for combattants
        $this->combatantA->ongoingBattleID = $this->id;
        if($this->type == "pvp") {
            $this->combatantB->ongoingBattleID = $this->id;
            // $this->combatantB->save();
        }
        
        $this->saveObjectState();
    }
    
    /**
     * Stops the battle and handle consequences of winning + loosing
     * Also does some cleaning up
     */
    public function stop() {
        if($this->combatantA->hp > 0) {
            $this->winnerType = "player";
            $this->winnerID = $this->combatantAID;
        } elseif ($this->combatantB->hp > 0) {
            $this->winnerType = ($this->type == "pvp" ? "player" : "monster");
            $this->winnerID = $this->combatantBID;
        } else {
            $this->winnerType = "draw";
        }

        // Bounty + XP
        if($this->type == "monster" && $this->combatantB->hp <= 0) {
            $loot = $this->combatantB->dropItems($this->combatantA->getDropItemPerc());
            $this->combatantA->gainItems($loot);

            $this->combatantA->gainCash($this->combatantB->dropCash, "battle");
            $this->combatantA->gainFavours($this->combatantB->dropFavours, "battle");
            $this->combatantA->gainKudos($this->combatantB->dropKudos, "battle");

            /**
             * monster->xp can be defined to deviate from the standard
             * attack / 2 xp reward
             */
            if(isset($this->combatantB->xp)) {
                $this->combatantA->increaseXp($this->combatantB->xp);
            } else {
                $this->combatantA->increaseXp($this->combatantB->attack / 2);
            }
        }

        $this->combatantA->ongoingBattleID = null;
        if($this->type == "pvp") {
            // @todo Message to PVP enemy
            $this->combatantB->ongoingBattleID = null;
        }

        $this->state = "resolved";
        $this->objectState = "";

        /**
         * ToDo: why does backupbehavior think that no attribute changed
         *       if we set ongoingBattleID to null?
         */
        // $this->combatantA->save();
        $this->combatantA->update();
        if($this->type == "pvp") {
            $this->combatantB->save();
        }

        $this->update();
        $this->reconstructCombatants();
    }
    
    /**
     * Checks if all combatants have valid actions defined. Calls
     * calculateRound if that is so.
     * Validity of $playerAction is checked by controller or is provided by
     * a Monster model directly
     * @uses calculateRound
     * @param mixed Battleskill or Item record
     */
    public function playerAction($playerAction = null) {
        // Yii::trace("playerAction. Action: " . $playerAction->name);
        
        // Did the player define a new and valid action?
        if($playerAction != $this->{$this->getHeroString() . "Action"} &&
           is_object($playerAction)) {

            $this->{$this->getHeroString() . "Action"} = $playerAction;

            // Let the monster act
            if($this->type == "monster") {
                $this->combatantBAction = $this->combatantB->call("act", $this);
            }

            // If enemy has already acted: continue!
            if(is_object($this->{$this->getEnemyString() . "Action"})) {

                    $this->calculateRound();
            } else {
                // ToDo: Print waiting for opponent message
            }
        } else {
            Yii::trace("Player action is the same as before (or invalid)");
        }
    }
    
    /**
     * - resolve block actions
     * - resolve delayed effects
     * - resolve defensive actions
     * - resolve offensive actions
     * - create new battleeffects
     * 
     * @uses onBeforeRound with BattleEvent
     * @uses onAfterRound with BattleEvent
     * @uses onBeforeAction with BattleActionEvent
     * @uses onAfterAction with BattleActionEvent
     * @uses BattleEvent
     * @uses BattleActionEvent
     */
    public function calculateRound() {
        Yii::trace("calculateRound");

        $this->nextRound();
        $this->onBeforeRound(new BattleEvent($this));

        /**
         * Resolve actions
         * Action calls expects $battle, $hero, $enemy, from the action's user 
         * point of view
         * If actions happen in the same battle phase, RNG decides who acts 
         * first. Otherwise, actions resolve in the order of the battle phases
         */
        if($this->combatantAAction->battlePhase == $this->combatantBAction->battlePhase) {
            $rand = mt_rand(0,100);
            if($rand >= 50) {
                $first = "combatantA";
            } else {
                $first = "combatantB";
            }
        } elseif ($this->combatantAAction->battlePhase == "block") {
            $first = "combatantA";
        } elseif ($this->combatantBAction->battlePhase == "block") {
            $first = "combatantB";
        } elseif ($this->combatantAAction->battlePhase == "defense") {
            $first = "combatantA";
        } elseif ($this->combatantBAction->battlePhase == "defense") {
            $first = "combatantB";
        }
        $second = ($first == "combatantA" ? "combatantB" : "combatantA");
        
        // First action
        $event = new BattleActionEvent($this, 
                $this->{$first}, $this->{$second},
                $this->{$first . "Action"}
        );
        $this->onBeforeAction($event);
        $this->{$first . "Action"}->call("resolve", $this, $this->{$first}, $this->{$second});
        $this->onAfterAction($event);
        
        // Second action
        $event = new BattleActionEvent($this, 
                $this->{$second}, $this->{$first}, 
                $this->{$second . "Action"}
        );
        $this->onBeforeAction($event);
        $this->{$second . "Action"}->call("resolve", $this, $this->{$second}, $this->{$first});
        $this->onAfterAction($event);

        
        // Clean up
        $this->combatantAAction = null;
        $this->combatantBAction = null;

        /*
         * Check if fight is over
         */
        if($this->combatantA->hp <= 0 || $this->combatantB->hp <= 0) {
            $this->stop();
        } else {
            $this->onAfterRound(new BattleEvent($this));

            $this->combatantA->save();
            if($this->type == "pvp") {
                $this->combatantB->save();
            }
            $this->saveObjectState();
        }
    }


    /**
     * EVENTS + RELATED STUFF
     */
    
    /**
     * Adds a Battleeffect to $this->battleeffects
     * @see Battleeffect
     * @see BattleeffectList
     * @param Battleeffect $effect 
     */
    public function addEffect($Effect) {
        $Effect->call("attachToBattle", $this);
        $this->battleeffects->add($Effect);
    }
    
    /**
     * Increases the duration of $Effect, if $Effect is already in the list
     * of active Battleeffects, and if $Effect is not a permanent effect
     * @param Battleeffect $Battleeffect
     * @param bool $sameHero default true
     */
    public function increaseEffectDuration($Battleeffect, $sameHero = true) {
        $existingEffectIndex = $this->battleeffects->indexOf($Battleeffect, $sameHero);
        if($existingEffectIndex > -1) {
            $existingEffect = $this->battleeffects->itemAt($existingEffectIndex);
            $existingEffect->turns += $Battleeffect->turns;
        } else {
            // nothing or throw exception?
        }
    }

    /**
     * Finds out if a combatant has Battleeffects attached to them
     * @todo allow obj for combatantString
     * @param string $combatantString
     * @return boolean 
     */
    public function combatantHasEffects($combatantString) {
        foreach($this->battleeffects as $battleeffect) {
            if ($battleeffect->heroString == $combatantString) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Event raisers
     * When adding new ones: Don't forget to add their names to the array in 
     * detachAll()
     */
    
    /**
     * Raises an event
     * @param CEvent $event 
     */
    public function onBeforeRound($event) {
        $this->raiseEvent("onBeforeRound", $event);
    }
    /**
     * Raises an event
     * @param CEvent $event 
     */
    public function onAfterRound($event) {
        $this->raiseEvent("onAfterRound", $event);
    }
    /**
     * Raises an event
     * @param CEvent $event 
     */
    public function onBeforeAction($event) {
        $this->raiseEvent("onBeforeAction", $event);
    }
    /**
     * Raises an event
     * @param CEvent $event 
     */
    public function onAfterAction($event) {
        $this->raiseEvent("onAfterAction", $event);
    }
    /**
     * Raises an event
     * @param CEvent $event 
     */
    public function onBeforeDealingDamage($event) {
        $this->raiseEvent("onBeforeDealingDamage", $event);
    }
    /**
     * Raises an event
     * @param CEvent $event 
     */
    public function onAfterDealingDamage($event) {
        $this->raiseEvent("onAfterDealingDamage", $event);
    }
    /**
     * Raises an event
     * @param CEvent $event 
     */
    public function onBeforeTakingDamage($event) {
        $this->raiseEvent("onBeforeTakingDamage", $event);
    }
    /**
     * Raises an event
     * @param CEvent $event 
     */
    public function onAfterTakingDamage($event) {
        $this->raiseEvent("onAfterTakingDamage", $event);
    }
    
    /**
     * Detaches the Effect's event handlers from all Battle events
     * @param Battleeffect $effect
     */
    public function detachAllEventHandlers($effect) {
        $eventNames = array("onBeforeAction", "onAfterAction", "onBeforeDealingDamage", "onAfterDealingDamage", "onBeforeTakingDamage", "onAfterTakingDamage");
        foreach($eventNames as $eventName) {
            $this->detachEventHandler($eventName, array($effect, "reactTo" . ucfirst($eventName)));
            $this->detachEventHandler($eventName, array($effect->asa("special"), "reactTo" . ucfirst($eventName)));
        }
    }
    
    
    
    /**
     * BORING STUFF
     */

    /**
     * Add a message to the log array
     * @param CombatantBehavior $combatant Model record with CombatantBehavior 
     * on whose side the message should appear
     * @param Battlemessage $battleMsg
     * @param int $round default is the current round
     */
    public function log($combatant, $battleMsg, $round = null) {
        if(empty($round)) {
            $round = $this->round;
        }
        
        if(empty($this->_log[$round])) {
            $this->_log[$round] = array();
        }
        
        // dd($battleMsg);
        $battleMsg->hero = $this->getCombatantString($combatant);
        
        $this->_log[$round][] = $battleMsg;
    }
    
    /**
     * Returns the Battlemessages of a given round or set of rounds
     * @todo accept arrays
     * @todo check if round exists
     * @see $_log
     * @param mixed $rounds enum(all|last|current) or int
     * @return array
     */
    public function getLogs($rounds = "all") {
        switch($rounds) {
            case "last":
                return end($this->_log);
                break;
            case "current":
                return $this->_log[$this->round];
                break;
            case (is_int($rounds)):
                return $this->_log[$rounds];
                break;
            default:
                return $this->_log;
                break;
        }
    }
    
    
    /**
     * Returns hero (from the current user's point of view)
     * @return CombatantBehavior Model record with CombatantBehavior
     */
    public function getHero() {
        if($this->combatantAID == CD()->id) {
            return $this->combatantA;
        } else {
            return $this->combatantB;
        }
    }
    /**
     * Returns enemy (from the current user's point of view)
     * @return CombatantBehavior Model record with CombatantBehavior
     */
    public function getEnemy() {
        if($this->combatantAID == CD()->id) {
            return $this->combatantB;
        } else {
            return $this->combatantA;
        }
    }

    /**
     * Returns a strig identifier of hero 
     * (from the current user's point of view)
     * @return string
     */
    public function getHeroString() {
        if($this->combatantAID == CD()->id) {
            return "combatantA";
        } else {
            return "combatantB";
        }
    }
    /**
     * Returns a string identifier of enemy 
     * (from the current user's point of view)
     * @return string
     */
    public function getEnemyString() {
        if($this->combatantAID == CD()->id) {
            return "combatantB";
        } else {
            return "combatantA";
        }
    }
    /**
     * Returns the winning combatant or the string "draw"
     * @return mixed CombatantBehavior or string "draw"
     */
    public function getWinner() {
        if($this->winnerType == "draw") {
            return "draw";
        } elseif($this->winnerID == $this->combatantAID && $this->winnerType == "player") {
            return $this->combatantA;
        } else {
            return $this->combatantB;
        }
    }
    /**
     * Returns the losing combatant or the string "draw"
     * @return mixed CombatantBehavior or string "draw"
     */
    public function getLoser() {
        if($this->winnerType == "draw") {
            return "draw";
        } elseif($this->winnerID == $this->combatantAID && $this->winnerType == "player") {
            return $this->combatantB;
        } else {
            return $this->combatantA;
        }
    }
    
    /**
     * Checks if the Character of the user won the battle
     * @return bool
     */
    public function isUserWinner() {
        if($this->winnerType == "player" && $this->winnerID == CD()->id) {
            return true;
        }
        return false;
    }
    
    /**
     * returns a string identifier of a Combatant
     * @param CombatantBehavior $obj Model record with CombatantBehavior
     * @return string "combatantA" or "combatantB"
     */
    public function getCombatantString($obj) {
        if(is_a($obj, "Monster")) {
            return "combatantB";
        } elseif ($obj->id == $this->combatantA->id) {
            return "combatantA";
        } else {
            return "combatantB";
        }
    }
    
    /**
     * Just increases $this->round by 1
     */
    public function nextRound() {
        $this->round++;
    }
    
    /**
     * Saves the Battle state in the database
     * serialize invokes __sleep, which sets $this->combatantA and B to null
     * reconstructCombatants reconstructs the Combatants. That way, the
     * complex Combatant objects do not use up space in the DB
     * @uses __sleep
     * @uses reconstructCombatants
     */
    public function saveObjectState() {
        $this->objectState = base64_encode(serialize($this));
        $this->isNewRecord = false;
        $this->update();
        $this->reconstructCombatants();
    }
    
    /**
     * Prepares the object for hibernation
     * Sets combatantA and B to null and removes inactive Battleeffects
     * @return array array_keys((array)$this)
     */
    public function __sleep() {
        if($this->type == "pvp") {
            $this->combatantA = null;
            $this->combatantB = null;
        } else {
            $this->combatantA = null;
        }
        
        /**
         * This is ugly, but you can't remove items from a CList while cycling 
         * through the list with foreach. The iterator's $_i for the current 
         * position is not updated. Apparently, this is how it should be. Weird.
         */
        $toDelete = array();
        foreach($this->battleeffects as $battleeffect) {
            if(!$battleeffect->active) {
                $toDelete[] = $battleeffect;
            }
        }
        foreach($toDelete as $deletee) {
            $this->battleeffects->remove($deletee);
        }
        
        return parent::__sleep();
    }
    
    /**
     * Factory method
     * Reconstructs a battle record with unserialize from the attribute
     * objectState
     * @todo reconstruct enemy Character model in PVP
     * @uses reconstructCombatants
     * @param int $battleID
     * @return mixed Battle record or false in case of an error
     */
    static public function reconstructBattle($battleID) {
        $battleModel = Battle::model()->findByPk($battleID);
        $battle = unserialize(base64_decode($battleModel->objectState));
        if(is_a($battle, "Battle")) {
            $battle->reconstructCombatants();
            return $battle;
        }
        return false;
    }
    
    /**
     * Reconstructs $this->combatantA and B after the Battle record was in
     * hibernation
     * @todo Reconstruct the second Character record in case of pvp
     */
    private function reconstructCombatants() {
        $Character = CD();
        if($this->type == "pvp") {
            if($this->combatantAID == $Character->id) {
                $this->combatantA = $Character;
            } else {
                $this->combatantB = $Character;
            }
        } else {
            $this->combatantA = $Character;
        }
    }

    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @link http://www.yiiframework.com/extension/attributesbackupbehavior/
     * @return array
     */
    public function behaviors() {
        return array(
            'AttributesBackupBehavior' => 'ext.AttributesBackupBehavior',
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