<?php

Yii::import('application.models._base.BaseBattle');
Yii::import('application.components.battleEffects.*');

class Battle extends BaseBattle {

    // Expects Combatant objects
    public $combatantA;
    public $combatantB;
    
    // Integer
    public $round = 0;
    
    // Skill or Item objects for the current round
    public $combatantAAction;
    public $combatantBAction;
    
    // CTypedList of effect objects
    public $battleeffects;
    
    /*
     *  Battle history and messages
     *  round # => array
     *      combatantA => array
     *          0 => array
     *              'skill' => array(id, name, type, desc, etc. -- or empty)
     *              'msg' => string
     *              'result' => array
     *                  type => 
     *                  additional properties (like damageType, amount, etc.)
     * 
     *      combatantB => ...
     */
    public $_log = array(0 => array('combatantA' => array(), 'combatantB' => array()));
    
     /*
      *  ToDo: Trigger beginningOfCombat effects
      */
     public function start() {
        // Init stuff
        $this->combatantAID = $this->combatantA->id;
        $this->combatantBID = $this->combatantB->id;

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
            // Player first round messages are only needed in PVP. (Are they?)
        } else {
            $battleMsg = new Battlemessage(
                $this->combatantB->call("createFirstRoundCombatMessage")
            );
            $this->log($this->combatantB, $battleMsg);
        }

        // Insert new DB record
        $this->insert();
        
        // Set ongoing battle flag
        $this->combatantA->setBattleFlag($this->id);
        if($this->type == "pvp") {
            $this->combatantB->setBattleFlag($this->id);
            $this->combatantB->save();
        }
        
        $this->saveObjectState();
    }
    
    /*
     *  Determine winner
     *  Handle consequences of winning + loosing
     *  Do some cleaning up
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

            $this->combatantA->increaseXp($this->combatantB->attack / 2);
        }

        if($this->type == "pvp") {
            // ToDo: Message to PVP enemy
            $this->combatantB->setBattleFlag(0);
        }
        $this->combatantA->setBattleFlag(0);

        $this->state = "resolved";
        $this->objectState = "";

        $this->combatantA->save();
        if($this->type == "pvp") {
            $this->combatantB->save();
        }

        $this->update();
        $this->reconstructCombatants();
    }
    
    /*
     *  Gültigkeit von $playerAction wird vom Controller überprüft
     *  bzw. stammt von Monster model
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
    
    /*
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

        // Resolve actions
        // Action calls expects $battle, $hero, $enemy, from the action's user point of view
        // If actions happen in the same battle
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
        
        if($first == "combatantA") {
            $second = "combatantB";
        } else {
            $second = "combatantA";
        }
        
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


    /*
     *    EVENTS + RELATED STUFF
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

    // Finds out if a combatant "owns" battleeffects
    // ToDo: allow obj for combatantString
    public function combatantHasEffects($combatantString) {
        foreach($this->battleeffects as $battleeffect) {
            if ($battleeffect->heroString == $combatantString) {
                return true;
            }
        }
        return false;
    }
    
    // Event raisers
    // When adding new ones: Don't forget to add their names to the array in detachAll...
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
    
    
    
    /*
     *    BORING STUFF
     */

    /*
     *  Add a message to the log array
     *  combatant    obj of the combatant on whose side the message should appear
     *  Default value for round is the current round
     *  For more details, see comment @ $_log
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
    
    /*
     *  ToDo: array, check if round exists, etc.
     *  round  mixed  all gives the whole array
     *               current gives the messages of the current round
     *               last    gives the messages of the last round played
     *               number gives the messages of the indicated round
     *               array of numbers gives the messages of the indicated rounds
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
    
    
    // From current user's point of view
    public function getHero() {
        if($this->combatantAID == CD()->id) {
            return $this->combatantA;
        } else {
            return $this->combatantB;
        }
    }
    public function getEnemy() {
        if($this->combatantAID == CD()->id) {
            return $this->combatantB;
        } else {
            return $this->combatantA;
        }
    }
    public function getHeroString() {
        if($this->combatantAID == CD()->id) {
            return "combatantA";
        } else {
            return "combatantB";
        }
    }
    public function getEnemyString() {
        if($this->combatantAID == CD()->id) {
            return "combatantB";
        } else {
            return "combatantA";
        }
    }
    
    public function getWinner() {
        if($this->winnerType == "draw") {
            return "draw";
        } elseif($this->winnerID == $this->combatantAID && $this->winnerType == "player") {
            return $this->combatantA;
        } else {
            return $this->combatantB;
        }
    }
    public function getLoser() {
        if($this->winnerType == "draw") {
            return "draw";
        } elseif($this->winnerID == $this->combatantAID && $this->winnerType == "player") {
            return $this->combatantB;
        } else {
            return $this->combatantA;
        }
    }
    public function isUserWinner() {
        if($this->winnerType == "player" && $this->winnerID == CD()->id) {
            return true;
        }
        return false;
    }
    
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
    
    /*
     * __sleep sets Character model properties to null
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
        
        // This is ugly, but you can't remove items from a CList while cycling through
        // the list with foreach. The iterator's $_i for the current position is not
        // updated. Apparently, this is how it should be. Weird.
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
    
    // Factory method
    // ToDo: reconstruct enemy Character model in PVP
    static public function reconstructBattle($battleID) {
        $battleModel = Battle::model()->findByPk($battleID);
        $battle = unserialize(base64_decode($battleModel->objectState));
        if(is_a($battle, "Battle")) {
            $battle->reconstructCombatants();
            return $battle;
        }
        return false;
    }
    
    // ToDo: reconstruct non-user character in pvp as well
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