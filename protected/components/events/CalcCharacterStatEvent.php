<?php

/**
 * Proxy for BonusCollectionEvent, just to see if it's working 
 */

class CalcCharacterStatEvent extends CollectBonusEvent {
    
    /**
     * Constructor
     * @param mixed $sender obj or null
     * @oaram array $params
     */
    public function __construct($sender = null, $params = array()) {
        parent::__construct($sender, $params);
    }
}

?>
