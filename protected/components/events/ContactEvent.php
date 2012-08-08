<?php

/**
 * Notifier
 * @see Contact
 * @package Events 
 */

class ContactEvent extends CEvent {

    /**
     * The CharacterContacts record
     * @var CharacterContacts
     */
    private $_CharacterContact;
    
    /**
     * Constructor
     * @param mixed $sender obj or null
     * @param mixed $CharacterContact CharacterContacts or null
     * @param array $params
     */
    public function __construct($sender = null, $CharacterContact = null, $params = array()) {
        $this->_CharacterContact = $CharacterContact;
        parent::__construct($sender, $params);
    }
    
    /**
     * Basic getter
     * @return CharacterContacts
     */
    public function getCharacterContact() {
        return $this->_CharacterContact;
    }
    
    /**
     * Basic getter
     * @return int 
     */
    public function getContact() {
        return $this->_CharacterContact->contact;
    }
}

?>
