<?php

Yii::import('application.models._base.BaseBattle');
Yii::import('application.components.battleEffects.*');

/**
 * Models and manages battles, both PvE and PvP
 * ToDo: implememnt battle phases in State pattern?
 */

class Battle extends BaseBattle {

    /**
     * @var Combatant (Character or Monster) 
     */
    public $combatantA;
    public $combatantB;
    
    /**
     * @var int
     */
    public $round = 0;
    
    /**
     * @var Skill or Item to be used by the combatants this round
     */
    public $combatantAAction;
    public $combatantBAction;
    
    /**
     * @var CTypedList of Battleeffect objects
     */
    public $battleeffects;
    
    /**
     * @var array, saves battle history and messages, 
     * used to render the battle history view
     * 
     * round # => array
     *     combatantA => array
     *         0 => array
     *             'skill' => array(id, name, type, desc, etc. -- or empty)
     *             'msg' => string
     *             'result' => array
     *                 type => 
     *                 additional properties (like damageType, amount, etc.)
     *      combatantB => ...
     */
    public $_log = array(0 => array('combatantA' => array(), 'combatantB' => array()));
    
     /**
      * ToDo: Trigger beginningOfCombat effects
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
            // Player first round messages are only needed in PVP.
            // ToDo: Are they?
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
            $this->combatantB->save();
        }
        
        $this->saveObjectState();
    }
    
    /**
     * Determine winner
     * Handle consequences of winning + loosing
     * Do some cleaning up
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
            // ToDo: Message to PVP enemy
            $this->combatantB->ongoingBattleID = null;
        }

        $this->state = "resolved";
        $this->objectState = "";

        /**
         * ToDo: why does backupbehavior think that no attribute changed
         *       if we set ongoingBattleID to null?
         */
        $this->combatantA->update();
        // $this->combatantA->save();
        if($this->type == "pvp") {
            $this->combatantB->save();
        }

        $this->update();
        $this->reconstructCombatants();
    }
    
    /**
     * Validity of $playerAction is checked by controller or is provided by
     * a monster model directly
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
     * 1. resolve block actions
     * 2. resolve delayed effects
     * 3. resolve defensive actions
     * 4. resolve offensive actions
     * 5. create new effects
     */
    public function calculateRound() {
        Yii::trace("calculateRound");

        $this->nextRound();
        $this->onBeforeRound(new CEvent($this));

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
        $event = new CModelEvent($this, array('hero' => $this->{$first},
                                            'enemy' => $this->{$second},
                                            'action' => $this->{$first . "Action"}));
        $this->onBeforeAction($event);
        $this->{$first . "Action"}->call("resolve", $this, $this->{$first}, $this->{$second});
        $this->onAfterAction($event);
        
        // Second action
        $event = new CModelEvent($this, array('hero' => $this->{$second},
                                            'enemy' => $this->{$first},
                                            'action' => $this->{$second . "Action"}));
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
            $this->onAfterRound(new CEvent($this));

            if($this->type == "pvp") {
                $this->combatantA->save();
                $this->combatantB->save();
            }
            $this->saveObjectState();
        }
    }


    /**
     * EVENTS + RELATED STUFF
     */
    
    public function addEffect($effect) {
        $effect->call("attachToBattle", $this);
        $this->battleeffects->add($effect);
    }
    
    public function increaseEffectDuration($effect, $sameHero = true) {
        $existingEffectIndex = $this->battleeffects->indexOf($effect, $sameHero);
        if($existingEffectIndex > -1) {
            $existingEffect = $this->battleeffects->itemAt($existingEffectIndex);
            $existingEffect->turns += $effect->turns;
        } else {
            // nothing or throw exception?
        }
    }

    /**
     * Finds out if a combatant has battleeffects attached to them
     * @param string $combatantString
     * @return boolean 
     * ToDo: allow obj for combatantString
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
     * detachAll...
     */
    public function onBeforeRound($event) {
        $this->raiseEvent("onBeforeRound", $event);
    }
    public function onAfterRound($event) {
        $this->raiseEvent("onAfterRound", $event);
    }
    public function onBeforeAction($event) {
        $this->raiseEvent("onBeforeAction", $event);
    }
    public function onAfterAction($event) {
        $this->raiseEvent("onAfterAction", $event);
    }
    public function onBeforeDealingDamage($event) {
        $this->raiseEvent("onBeforeDealingDamage", $event);
    }
    public function onAfterDealingDamage($event) {
        $this->raiseEvent("onAfterDealingDamage", $event);
    }
    public function onBeforeTakingDamage($event) {
        $this->raiseEvent("onBeforeTakingDamage", $event);
    }
    public function onAfterTakingDamage($event) {
        $this->raiseEvent("onAfterTakingDamage", $event);
    }
    
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
     * @param Combatant $combatant, on whose side the message should appear
     * @param Battlemessage $battleMsg
     * @param int $round, default is the current round
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
     * Returns Battlemessages of a given round or set of rounds
     * @param mixed $rounds, "all", "last", "current" or int of round
     * @return array
     * ToDo: array, check if round exists, etc.
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
     * All getWhateverCombatants are from current user's point of view
     */
    
    /**
     * @return Combatant 
     */
    public function getHero() {
        if($this->combatantAID == CD()->id) {
            return $this->combatantA;
        } else {
            return $this->combatantB;
        }
    }
    /**
     * @return Combatant 
     */
    public function getEnemy() {
        if($this->combatantAID == CD()->id) {
            return $this->combatantB;
        } else {
            return $this->combatantA;
        }
    }
    /**
     * @return string, either "combatantA" or "combatantB"
     */
    public function getHeroString() {
        if($this->combatantAID == CD()->id) {
            return "combatantA";
        } else {
            return "combatantB";
        }
    }
    /**
     * @return string, either "combatantA" or "combatantB"
     */
    public function getEnemyString() {
        if($this->combatantAID == CD()->id) {
            return "combatantB";
        } else {
            return "combatantA";
        }
    }
    /**
     * @return Combatant or string "draw"
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
     * @return Combatant or string "draw"
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
     * @return bool
     */
    public function isUserWinner() {
        if($this->winnerType == "player" && $this->winnerID == CD()->id) {
            return true;
        }
        return false;
    }
    
    /**
     * returns the combatant-string of a Combatant object
     * @return string, "combatantA" or "combatantB"
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
    
    public function nextRound($nextRound = true) {
        $this->round++;
    }
    
    /**
     * __sleep sets Combatant model properties to null
     * reconstructBattle reconstructs these properties
     * Saves space on DB and makes it possible to use CharacterData component
     * throughout the battle
     */
    public function saveObjectState() {
        $this->objectState = base64_encode(serialize($this));
        $this->isNewRecord = false;
        $this->save();
        $this->reconstructCombatants();
    }
    
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
     * @param type $battleID
     * @return Battle or false in case of an error
     * ToDo: reconstruct enemy Character model in PVP
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
    
    // ToDo: reconstruct the second Character in case of a pvp fight as well
    private function reconstructCombatants() {
        if($this->type == "pvp") {
            if($this->combatantAID == CD()->id) {
                $this->combatantA = CD();
            } else {
                $this->combatantB = CD();
            }
        } else {
            $this->combatantA = CD();
        }
    }

    public function behaviors() {
        return array(
            'AttributesBackupBehavior' => 'ext.AttributesBackupBehavior',
            );
    }
    
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}