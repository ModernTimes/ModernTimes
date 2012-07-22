<?php

/**
 * 
 * @uses BonusCollectorBehavior
 * @package Events 
 */

class BattleActionDamageEvent extends BattleActionEvent {

    /**
     * The base amount of damage (before adjustments). Cannot be altered by
     * event handlers.
     * @param float 
     */
    private $_damageAmount;
    
    /**
     * The damage type. Cannot be altered by event handlers.
     * @var string enum(normal|special)
     */
    private $_damageType;
    
    /**
     * Calls parent constructor
     * @param Battle $sender 
     * @param mixed $hero null or CModel with CombatantBehavior
     * Combatant from whose perspective the event takes place
     * @param mixed $enemy null or CModel with CombatantBehavior
     * Enemy of the combatant from whose perspective the event takes place
     * @param float $damage The base amount of damage (before adjustments)
     * @param string $damageType enum(normal|special)
     * @param array $params default empty
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
        
        // BonusCollector part
        $this->attachBehaviors($this->behaviors());
        $this->asa("BonusCollector")->init(
                $params['bonusAbs'], 
                $params['bonusPerc']
        );
        unset($params['bonusAbs'], $params['bonusPerc']);
        
        // GainStat part
        $this->_damageAmount = $damage;
        $this->_damageType = $damageType;

        parent::__construct($sender, $hero, $enemy, $action, $params);
    }
    
    /**
     * Basic getter
     * @return float
     */
    public function getDamageAmount() {
        return $this->_damageAmount;
    }
    
    /**
     * Basic gettter
     * @return string enum(normal|special)
     */
    public function getDamageType() {
        return $this->_damageType;
    }

    /**
     * Returns a list of CBehaviors to be attached to this component
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array(
            "BonusCollector" => "application.components.events.BonusCollectorBehavior"
        );
    }
}

?>
