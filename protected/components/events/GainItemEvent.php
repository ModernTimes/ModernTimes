<?php

/**
 * Notifier
 * @see Item
 * @package Events 
 */

class GainItemEvent extends CEvent {

    /**
     * The Items record that was added
     * @var CharacterEffects
     */
    private $_Item;
    
    /**
     * Number of items added
     * @var int
     */
    private $_n;
    
    /**
     * Constructor
     * @param mixed $sender obj or null
     * @param mixed $Item Item or null
     * @param int $n default 1
     * @param array $params
     */
    public function __construct($sender = null, $Item = null, $n = 1, $params = array()) {
        $this->_Item = $Item;
        $this->_n = $n;
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
     * @return int 
     */
    public function getN() {
        return $this->_n;
    }
}

?>
