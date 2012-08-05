<?php

/**
 * Notifier
 * Is also used for onUnequip stuff
 * @see Item
 * @package Events 
 */

class EquipItemEvent extends CEvent {

    /**
     * The Items record that was equipped
     * @var Item or null
     */
    private $_Item;
    
    /**
     * Slot in which the item was added
     * @var string or null
     */
    private $_slot;
    
    /**
     * Constructor
     * @param mixed $sender obj or null
     * @param mixed $Item Item or null
     * @param string $slot default null
     * @param array $params
     */
    public function __construct($sender = null, $Item = null, $slot = null, $params = array()) {
        $this->_Item = $Item;
        $this->_slot = $slot;
        parent::__construct($sender, $params);
    }
    
    /**
     * Basic getter
     * @return Item
     */
    public function getItem() {
        return $this->_Item;
    }
    
    /**
     * Basic getter
     * @return string or null 
     */
    public function getSlot() {
        return $this->_slot;
    }
}

?>
