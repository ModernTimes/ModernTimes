<?php

/**
 * Notifier
 * @see CharacterEffects
 * @package Events 
 */

class GainEffectEvent extends CEvent {

    /**
     * The CharacterEffects that was added
     * @var CharacterEffects
     */
    private $_CharacterEffect;
    
    /**
     * Constructor
     * @param mixed $sender obj or null
     * @param mixed $CharacterEffect CharacterEffects or null
     * @param array $params
     */
    public function __construct($sender = null, $CharacterEffect = null, $params = array()) {
        $this->_CharacterEffect = $CharacterEffect;
        parent::__construct($sender, $params);
    }
    
    /**
     * Basic getter
     * @return CharacterEffects
     */
    public function getCharacterEffect() {
        return $this->_CharacterEffect;
    }
}

?>
