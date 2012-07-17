<?php

Yii::import('application.models._base.BaseSkill');
Yii::import('application.components.skills.*');

/**
 * Resolve the skill by interfering with the battle object
 * The following holds true for all funcitons in this class:
 * hero and enemy are from the Skill user's point of view
 * @param Battle $battle
 * @param Combatant $hero
 * @param Combatant $enemy
 * ToDo: source out battle action behavior (sharable with Item model)
 * ToDo: implement non-combat skill mechanics
 */

class Skill extends BaseSkill {

    public $blocked = false;

    public function resolve($battle, $hero, $enemy) {
        if(!$this->call("checkBlocked", $battle, $hero, $enemy)) {
            return;
        }
        
        $this->call("dealDamage", $battle, $hero, $enemy);
        $this->call("createEffects", $battle, $hero, $enemy);
    }
    
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
     * basic Battleeffect creation
     */
    public function createEffects($battle, $hero, $enemy, $log = true) {
        if($this->createEffect != null) {
            $effect = clone $this->createEffect0;
            
            // See Battleeffect->initialize for further details
            $result = $effect->call("initialize", $battle, $hero, $enemy, array(
                'turns' => $this->effectTurns)
            );
            if($log) {
                $battleMsg = new Battlemessage("", $this);
                if($result == "added") {
                    $battleMsg->msg = sprintf($this->call("getMsgResolved"), $hero->name);
                } elseif($result == "increasedDuration") {
                    $battleMsg->msg = sprintf($this->call("getMsgIncreasedDuration"), $hero->name);
                }
                $battleMsg->setResult("effect", $effect);
                $battle->log($hero, $battleMsg);
            }
        }
    }
    
    /**
     * Basic damage dealing stuff
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

            // Give Battleeffects an opportunity to react
            $event = new CModelEvent($this, array('battle' => $battle,
                                                'hero' => $hero,
                                                'enemy' => $enemy,
                                                'damage' => &$damage,
                                                'damageType' => &$damageType));
            $battle->onBeforeDealingDamage($event);

            $damageDone = $enemy->takeDamage($damage, $damageType);

            $battleMsg = new Battlemessage(sprintf($this->call("getMsgResolved"), $hero->name), $this);
            $battleMsg->setResult("damage", $damageDone, $damageType);
            $battle->log($hero, $battleMsg);
            
            // Give Battleeffects an opportunity to react
            $event = new CModelEvent($this, array('battle' => $battle,
                                                'hero' => $hero,
                                                'enemy' => $enemy,
                                                'damageDone' => $damageDone,
                                                'damageType' => $damageType));
            $battle->onAfterDealingDamage($event);
        }
    }
    
    public function setBlocked($bool = true) {
        $this->blocked = $bool;
        return true;
    }
    
    public function getMsgResolved() {
        return $this->msgResolved;
    }
    public function getMsgIncreasedDuration() {
        return (!empty($this->effectMsgIncreasedDuration) ? 
                    $this->effectMsgIncreasedDuration :
                    $this->getMsgResolved());
    }

    public function getPopup() {
        return "<p>" . $this->desc . 
               ($this->costEnergy > 0 ? "<BR />&nbsp;<BR /><span class='btn btn-mini'><i class='icon-star'></i> " . $this->costEnergy . "</span>" : "") . 
               "</p>";
    }
    public function getLogDetails() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->actionType,
            'desc' => $this->desc,
            'popup' => $this->call("getPopup"),
        );
    }

    public function behaviors() {
        return array(
            "application.components.SpecialnessBehavior",
            "application.components.CharacterModifierBehavior",
        );
    }

    public static function model($className=__CLASS__) {
            return parent::model($className);
    }
}