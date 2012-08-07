<?php

Yii::import('application.models._base.BaseBattleskill');
Yii::import('application.components.battleskills.*');

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
     * @uses checkSuccess
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
        if(!$this->call("checkSuccess", $battle, $hero, $enemy)) {
            return;
        }

        if($this->costEnergy > 0) {
            $hero->decreaseEnergy($this->costEnergy);
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
     * Checks if this Battleskill is used successfully 
     * (RNG based on successRate)
     * @param Battle $battle
     * @param CombatantBehavior $hero Model record with CombatantBehavior
     * @param CombatantBehavior $enemy Model record with CombatantBehavior
     * @return bool success: true, failure: false
     */
    public function checkSuccess($battle, $hero, $enemy) {
        if($this->successRate == 1) {
            return true;
        } else {
            if(mt_rand(0, 100) > $this->successRate * 100) {
                $battleMsg = new Battlemessage("", $this);
                $battleMsg->setResult("failed");
                $battle->log($hero, $battleMsg);
                return false;
            } else {
                return true;
            }
        }
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
                    $battleMsg->msg = $this->call("getMsgResolved", $hero, $enemy);
                } elseif($result == "increasedDuration") {
                    $battleMsg->msg = $this->call("getMsgIncreasedDuration", $hero, $enemy);
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
     * @uses getDamageFixedAmount
     * @uses getDamageAttackStatBonus
     * @uses getCritFactor
     * @uses onBeforeDealingDamage
     * @uses onAfterDealingDamage
     * @uses BattleActionDamageEvent
     * @uses BattleActionDamageDealtEvent
     */
    public function dealDamage($battle, $hero, $enemy) {
        if($this->dealsDamage) {
            $damageType = $this->damageType;

            // Fixed amount + variation
            $damage = $this->call("getDamageFixedAmount");
            // Attack stat bonus (resoluteness or willpower) + cap of said bonus
            $damage += $this->call("getDamageAttackStatBonus", $hero);
            /**
             * Critical hit factor
             * 2 for critical hits [typically], 1 for normal hits
             */
            $critFactor = $this->call("getCritFactor", $hero);
            $damage *= $critFactor;
            
            // Bonus collection
            $event = new BattleActionDamageEvent($battle, $hero, $enemy, $this, 
                    $damage, $damageType);
            // raise 2x
            $battle->onBeforeDealDamage($event);
            $hero->onCalcBonusDamage($event, $damageType);
            $damage = $event->adjustStat($damage);
            
            // Adjust damage based on hero's attack and enemy's defense rating
            $damage *= $this->call("getAttDefDifferenceFactor", 
                            $hero->getAttack($this->damageAttackFactorStat) - $enemy->getDefense());
            
            /**
             * Actually inflict damage
             * This returns an integer >= 0
             */
            $damageDone = $enemy->takeDamage($damage, $damageType);

            $battleMsg = new Battlemessage(
                    ($critFactor > 1
                        ? "<span class='label label-important'>Critical Hit!</span> " : "") . 
                    $this->call("getMsgResolved", $hero, $enemy), 
                    $this);
            $battleMsg->setResult("damage", $damageDone, $damageType);
            $battle->log($hero, $battleMsg);
            
            // Notification only
            $event = new BattleActionDamageDealtEvent($battle, 
                    $hero, $enemy, $this, 
                    $damageDone, $damageType
            );
            $battle->onAfterDealtDamage($event);
        }
    }
    
    /**
     * Returns damageFixedAmount + variation
     * (based on damageFixedAmountVariation)
     * @return float
     */
    public function getDamageFixedAmount() {
        $damage = $this->damageFixedAmount;
        // Variations
        if(!empty($this->damageFixedAmountVariation)) {
            $damage += mt_rand(0, $this->damageFixedAmountVariation);
            $damage -= mt_rand(0, $this->damageFixedAmountVariation);
        }
        return $damage;
    }
    
    /**
     * Returns attack stat based bonus damage
     * @param CombatantBehavior $hero Model record with CombatantBehavior
     * @return float
     */
    public function getDamageAttackStatBonus($hero) {
        switch ($this->damageAttackFactorStat) {
            case "resoluteness":
            case "willpower":
                $attackStat = $hero->getAttack($this->damageAttackFactorStat);
                break;
            default:
                $attackStat = 0;
                break;
        }
        $damageAttackBonus = $this->damageAttackFactor * $attackStat;
        
        // Limit attack stat based bonus if a limit is defined
        if(!empty($this->damageAttackFactorCap)) {
            $damageAttackBonus = min($damageAttackBonus, $this->damageAttackFactorCap);
        }
        
        return $damageAttackBonus;
    }
    
    /**
     * Returns the crit factor (1 if not crit, 2 if crit)
     * @param CombatantBehavior $hero Model record with CombatantBehavior
     * @return float
     */
    public function getCritFactor($hero) {
        $critFactor = 1;
        
        // Get crit chance bonus
        $event = new CollectBonusEvent($this);
        $hero->onCalcCritChance($event);
        $critChance = 5 + $event->getBonusPerc();

        if(mt_rand(0, 100) <= $critChance) {
            $critFactor = 2;
        }
        return $critFactor;
    }
    
    /**
     * Returns the damage modifier based on the difference of hero's
     * attack stat and enemy's defense stat
     * @param int $difference
     * @return float
     */
    public function getAttDefDifferenceFactor($difference) {
        // @todo load precalculated modifiers?
        if($difference < 0) {
            return (0.1 + 0.9 * pow(10/11, abs($difference)));
        } else {
            return (1 + 0.12 * pow($difference, 0.95));
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
     * Basic version. Parses $this->msgResolved
     * MsgResolved is usually used as the main message in BattleMessages
     * @param mixed $hero Character or Monster
     * @param mixed $enemy Character or Monster
     * @return string
     */
    public function getMsgResolved($hero, $enemy) {
        return self::parseMsg($this->msgResolved, $hero, $enemy);
    }
    
    /**
     * Basic version. Parses $this->effectMsgIncreasedEffect
     * MsgResolved is usually used as the main message in BattleMessages
     * There might be a different message in case the duration of an effect
     * was increased (instead of a new effect getting in place)
     * @param mixed $hero Character or Monster
     * @param mixed $enemy Character or Monster
     * @uses getMsgResolved
     * @return string
     */
    public function getMsgIncreasedDuration($hero, $enemy) {
        return (!empty($this->effectMsgIncreasedDuration) ? 
                    self::parseMsg($this->effectMsgIncreasedDuration, $hero, $enemy) :
                    $this->call("getMsgResolved", $hero, $enemy));
    }
    
    /**
     * Parses a msg so that hero's and enemy's names and sexes are
     * considered appropriately
     * - %1$s: hero's name
     * - %2$s: personal pronoun for hero
     * - %3$s: possessive pronoun for hero
     * - %4$s: enemy's name
     * - %5$s: personal pronoun for enemy
     * - %6$s: possessive pronoun for enemy
     * @param string $msg
     * @param mixed $hero
     * @param mixed $enemy 
     */
    static function parseMsg($msg, $hero, $enemy) {
        return sprintf($msg, $hero->name, 
                             Yii::app()->tools->getPersonalPronoun($hero->sex),
                             Yii::app()->tools->getPossessivePronoun($hero->sex),
                             $enemy->name, 
                             Yii::app()->tools->getPersonalPronoun($enemy->sex),
                             Yii::app()->tools->getPossessivePronoun($enemy->sex));
    }

    /**
     * Returns a string that can be used as the ocntent of a popup for this
     * Battleskill
     * @return string
     */
    public function getPopup() {
        return "<p>" . $this->desc . "</p>" .
               ($this->costEnergy > 0 ? "<p><BR /><span class='btn btn-mini'><i class='icon-star'></i> " . $this->costEnergy . "</span></p>" : "") . 
               (!empty($this->subType) ? "<p style='font-size: 0.8em'><BR />Type: " . ucfirst($this->subType) . "</p>" : "");
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