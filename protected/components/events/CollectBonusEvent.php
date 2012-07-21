<?php

/**
 * Simple CEvent with BonusCollectorBehavior
 * 
 * @uses BonusCollectorBehavior
 * @package Events 
 */

class CollectBonusEvent extends CEvent {

    /**
     * Constructor
     * @param mixed $sender obj or null
     * @oaram array $params
     * - float bonusAbs default = 0
     * - float bonusPerc default = 0
     */
    public function __construct($sender = null, $params = array()) {
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
        $this->asa("BonusCollector")->init(
                $params['bonusAbs'], 
                $params['bonusPerc']
        );
        unset($params['bonusAbs'], $params['bonusPerc']);

        parent::__construct($sender, $params);
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
