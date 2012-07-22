<?php

/**
 * Can be attached to an event to enable that event to store damage data
 * (amount + type)
 * 
 * @package Events.Behaviors
 */

class DamageStorageBehavior extends CBehavior {

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
     * Whether the behavior has already been initialized.
     * (It can only be initialized once, to prevent access to init function
     * by something other than owner.)
     * @var bool
     */
    private $_initialized = false;
    
    /**
     * Initiates the storage
     * @param float $amount default = 0
     * @param string $type enum(normal|special) default: normal
     */
    public function init($amount = 0, $type = "normal") {
        if(!$this->_initialized) {
            $this->_damageAmount = $amount;
            $this->_damageType = $type;
            $this->_initialized = true;
        }
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

}

?>