<?php

/**
 * Notifier + BonusCollector
 * Battle action is about to deal damage
 * 
 * @uses BonusCollectorBehavior
 * @uses DamageStorageBehavior
 * @package Events
 */

class BattleActionDamageEvent extends BattleActionEvent {

    /**
     * Calls parent constructor
     * @param Battle $sender 
     * @param mixed $hero null or CModel with CombatantBehavior
     * Combatant from whose perspective the event takes place
     * @param mixed $enemy null or CModel with CombatantBehavior
     * Enemy of the combatant from whose perspective the event takes place
     * @param mixed $action Skill or Item
     * @param float $damage The base amount of damage (before adjustments)
     * @param string $damageType enum(normal|special)
     * @param array $params default array()
     */
    public function __construct($sender, $hero, $enemy, $action, 
                $damage = 0, $damageType = "normal", $params = array()) {
        
        $params = array_merge(
            // The default options
            array(
                'bonusAbs' => 0,
                'bonusPerc' => 0,
            ),
            // The specified options
            $params
        );
        
        $this->attachBehaviors($this->behaviors());

        // BonusCollector part
        $this->asa("BonusCollector")->init(
                $params['bonusAbs'], 
                $params['bonusPerc']
        );
        unset($params['bonusAbs'], $params['bonusPerc']);
        
        // DamageStorage part
        $this->asa("DamageStorage")->init(
                $damage,
                $damageType
        );

        parent::__construct($sender, $hero, $enemy, $action, $params);
    }
    
    /**
     * Returns a list of CBehaviors to be attached to this component
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array(
            "BonusCollector" => "application.components.events.behaviors.BonusCollectorBehavior",
            "DamageStorage" => "application.components.events.behaviors.DamageStorageBehavior"
        );
    }
}

?>
