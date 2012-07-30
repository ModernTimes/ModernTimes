<?php

Yii::import('application.models._base.BaseBattleskill');
Yii::import('application.components.skills.*');

/**
 * Resolve the battleskill by interfering with the battle object
 * The following holds true for all funcitons in this class:
 * hero and enemy are from the Skill user's point of view
 * 
 * See BaseBattleskill for a list of attributes and related Models.
 * 
 * @uses SpecialnessBehavior
 * @package System.Models
 */

class Battleskill extends BaseBattleskill {

    /**
     * Other Skills or Battleeffects can block this skill, which means that
     * it's not executed
     * @var bool
     */
    public $blocked = false;

    /**
     * Resolves the Battleskill by calling other functions to take care of basic
     * Skill mechanics
     * @uses checkBlocked
     * @uses dealDamage
     * @uses createEffects
     * @param Battle $battle
     * @param CombatantBehavior $hero Model record with CombatantBehavior
     * @param CombatantBehavior $enemy Model record with CombatantBehavior
     */
    public function resolve($battle, $hero, $enemy) {
        if(!$this->call("checkBlocked", $battle, $hero, $enemy)) {
            return;
        }
        
        $this->call("dealDamage", $battle, $hero, $enemy);
        $this->call("createEffects", $battle, $hero, $enemy);
    }
    
    /**
     * Checks if this Battleskill is blocked and if so adds a Battlemessage
     * @param Battle $battle
     * @param CombatantBehavior $hero Model record with CombatantBehavior
     * @param CombatantBehavior $enemy Model record with CombatantBehavior
     * @return bool not blocked: true, blocked: false
     */
    public function checkBlocked($battle, $hero, $enemy) {
        if($this->blocked) {
            $battleMsg = new Battlemessage("", $this);
            $battleMsg->setResult("blocked");
            $battle->log($hero, $battleMsg);
            
            /**
             * Remember that blocked is a property of the skill class and gets
             * carried over to future rounds unless it is reset properly
             */
            $this->blocked = false;
            
            return false;
        }
        return true;
    }
    
    /**
     * Basic Battleeffect creation
     * @param Battle $battle
     * @param CombatantBehavior $hero Model record with CombatantBehavior
     * @param CombatantBehavior $enemy Model record with CombatantBehavior
     * @param bool $log whether the effect creation should be looged with a 
     * Battlemessage
     */
    public function createEffects($battle, $hero, $enemy, $log = true) {
        if($this->createBattleeffectID != null) {
            $Battleeffect = clone $this->createBattleeffect;
            
            // See Battleeffect->initialize for further details
            $result = $Battleeffect->call("initialize", $battle, $hero, $enemy, array(
                'turns' => $this->battleeffectTurns)
            );
            if($log) {
                $battleMsg = new Battlemessage("", $this);
                if($result == "added") {
                    $battleMsg->msg = sprintf($this->call("getMsgResolved"), $hero->name);
                } elseif($result == "increasedDuration") {
                    $battleMsg->msg = sprintf($this->call("getMsgIncreasedDuration"), $hero->name);
                }
                $battleMsg->setResult("effect", $Battleeffect);
                $battle->log($hero, $battleMsg);
            }
        }
    }
    
    /**
     * Basic damage dealing mechanics
     * @param Battle $battle
     * @param CombatantBehavior $hero Model record with CombatantBehavior
     * @param CombatantBehavior $enemy Model record with CombatantBehavior
     * @uses onBeforeDealingDamage
     * @uses onAfterDealingDamage
     * @uses BattleActionDamageEvent
     * @uses BattleActionDamageDealtEvent
     */
    public function dealDamage($battle, $hero, $enemy) {
        if($this->dealsDamage) {
            $damage = $this->damageFixedAmount;
            $damageType = $this->damageType;

            if ($this->costEnergy == 0) {
                $damage += $this->damageAttackFactor * $hero->getNormalAttack();
            } else {
                $damage += $this->damageAttackFactor * $hero->getSpecialAttack();
            }

            // Bonus collection
            $event = new BattleActionDamageEvent($battle, $hero, $enemy, $this, 
                    $damage, $damageType);
            $battle->onBeforeDealingDamage($event);

            $damageAdjusted = max(0, floor($event->adjustStat($damage)));
            $damageDone = $enemy->takeDamage($damageAdjusted, $damageType);

            $battleMsg = new Battlemessage(sprintf($this->call("getMsgResolved"), $hero->name), $this);
            $battleMsg->setResult("damage", $damageDone, $damageType);
            $battle->log($hero, $battleMsg);
            
            // Notification only
            $event = new BattleActionDamageDealtEvent($battle, 
                    $hero, $enemy, $this, 
                    $damageDone, $damageType
            );
            $battle->onAfterDealingDamage($event);
        }
    }
    
    /**
     * Basic setter
     * @param bool $bool default true
     * @return boolean true
     */
    public function setBlocked($bool = true) {
        $this->blocked = $bool;
        return true;
    }
    
    /**
     * Basic getter
     * msgResolved is usually used as the main message in BattleMessages
     * @return string
     */
    public function getMsgResolved() {
        return $this->msgResolved;
    }
    /**
     * There might be a different message in case the duration of an effect
     * was increased (instead of a new effect getting in place)
     * @uses getMsgResolved
     * @return string
     */
    public function getMsgIncreasedDuration() {
        return (!empty($this->effectMsgIncreasedDuration) ? 
                    $this->effectMsgIncreasedDuration :
                    $this->getMsgResolved());
    }

    /**
     * Returns a string that can be used as the ocntent of a popup for this
     * Battleskill
     * @return string
     */
    public function getPopup() {
        return "<p>" . $this->desc . 
               ($this->costEnergy > 0 ? "<BR />&nbsp;<BR /><span class='btn btn-mini'><i class='icon-star'></i> " . $this->costEnergy . "</span>" : "") . 
               "</p>";
    }
    
    /**
     * Returns an array with log details about this Skill:
     * id, name, type, desc, popup
     * @return array
     */
    public function getLogDetails() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->actionType,
            'desc' => $this->desc,
            'popup' => $this->call("getPopup"),
        );
    }

    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array(
            "application.components.SpecialnessBehavior",
        );
    }

    /**
     * Returns the declaration of named scopes. A named scope represents a query
     * criteria that can be chained together with other named scopes and applied
     * to a query.
     * @link http://www.yiiframework.com/doc/api/1.1/CActiveRecord#scopes-detail
     * @return array the scope definition. The array keys are scope names
     */
    public function scopes() {
        return array(
            'withRelated' => array(
                'with' => array(
                    'createBattleeffect' => array(
                        'alias' => 'battleskillCreateBattleeffect' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                )
            )
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