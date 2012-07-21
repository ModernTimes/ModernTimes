<?php

/**
 * Event is raised by Character to find out how some stat is to be adjusted
 * because of Items, Effects, etc. It is handled by active Charactermodifier
 * records, which can increase or decrease bonusAbs (absolute bonus) and 
 * bonusPerc (percentage based bonus represented in percentage points). 
 * Character then calculates an adjusted stat with the following formula:
 * 
 * statAdjusted = (stat * (bonusPerc+100)/100) + bonusAbs
 * 
 * @see Character
 * @see CharacterModifierBehavior
 * @package Events
 */

class CalcCharacterStatEvent extends CEvent {

    /**
     * Additive bonus
     * statAdjusted = (stat * (bonusPerc+100)/100) + bonusAbs
     * @var float
     */
    private $_bonusAbs = 0;
    
    /**
     * Multiplicative bonus in percentage points
     * statAdjusted = (stat * (bonusPerc+100)/100) + bonusAbs
     * @var type 
     */
    private $_bonusPerc = 0;
    
    /**
     * Constructor
     * @param Character $sender
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
        
        $this->_bonusAbs = $params['bonusAbs'];
        $this->_bonusPerc = $params['bonusPerc'];
        unset($params['bonusAbs'], $params['bonusPerc']);

        if(is_a($sender, "Character")) {
            parent::__construct($sender, $params);
        } else {
            parent::__construct(null, $params);
        }
    }
    
    /**
     * Increases $this->_bonusAbs
     * $this->_bonusAbs can only be modified additively
     * @param float $amount 
     */
    public function increaseBonusAbs($amount = 0) {
        $this->_bonusAbs += $amount;
    }
    /**
     * Decreases $this->_bonusAbs
     * $this->_bonusAbs can only be modified additively
     * @param float $amount 
     */
    public function decreaseBonusAbs($amount = 0) {
        $this->_bonusAbs -= $amount;
    }
    
    /**
     * Increases $this->_bonusPerc
     * $this->_bonusPerc can only be modified additively !!!
     * @param float $amount 
     */
    public function increaseBonusPerc($amount = 0) {
        $this->_bonusPerc += $amount;
    }
    /**
     * Decreases $this->_bonusPerc
     * $this->_bonusPerc can only be modified additively !!!
     * @param float $amount 
     */
    public function decreaseBonusPerc($amount = 0) {
        $this->_bonusPerc -= $amount;
    }

    /**
     * Basic getter
     * @return float
     */
    public function getBonusAbs() {
        return $this->_bonusAbs;
    }

    /**
     * Basic getter
     * @return float
     */
    public function getBonusPerc() {
        return $this->_bonusPerc;
    }
}

?>