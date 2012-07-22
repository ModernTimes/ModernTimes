<?php

/**
 * Notifier + BonusCollector
 * Handles $amount of stat to be gained, and the source of this fortunate event
 *  * 
 * @uses BonusCollectorBehavior
 * @package Events 
 */

class GainStatEvent extends CEvent {

    /**
     * How much of whatever someone is gaining is gained?
     * @var float
     */
    private $_amount;
    
    /**
     * The source of this fortunate event
     * @var string enum(other|battle|encounter|quest|autosell)
     */
    private $_source;
    
    /**
     * Constructor
     * @param mixed $sender obj or null
     * @oaram array $params
     * - float bonusAbs default = 0
     * - float bonusPerc default = 0
     * - float amount default = 0
     * - string source enum(other|battle|encounter|quest|autosell) default other
     */
    public function __construct($sender = null, $params = array()) {
        $params = array_merge(
            // The default options
            array(
                'bonusAbs' => 0,
                'bonusPerc' => 0,
                'amount' => 0,
                'source' => "other"
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
        $this->_amount = $params['amount'];
        switch($params['source']) {
            case "battle":
            case "encounter":
            case "quest":
            case "autosell":
                $this->_source = $params['source'];
                break;
            default:
                $this->_source = "other";
                break;
        }
        unset($params['amount'], $params['souce']);

        parent::__construct($sender, $params);
    }
    
    /**
     * Basic getter
     * @return float
     */
    public function getAmount() {
        return $this->_amount;
    }
    
    /**
     * Basic gettter
     * @return string
     */
    public function getSource() {
        return $this->_source;
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
