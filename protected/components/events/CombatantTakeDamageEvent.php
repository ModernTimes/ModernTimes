<?php

/**
 * Notifier + BonusCollector
 * Informs that the Combatant is about to take damage
 * @todo Enforce the sender to have CombatantBehavior
 *
 * @uses BonusCollectorBehavior
 * @uses DamageStorageBehavior
 * @package Events
 */

class CombatantTakeDamageEvent extends CEvent {
    
    /**
     * Constructor
     * @param mixed $sender obj or null
     * @param float $damage
     * @param string $damageType enum(normal|special) default normal
     * @param type $params default array()
     */
    public function __construct($sender, $damage = 0, $damageType = "normal", $params = array()) {
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

        parent::__construct($sender, $params);
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
