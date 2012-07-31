<?php

/**
 * Notifier
 * @uses Quest
 * @package Events 
 */

class QuestChangeStateEvent extends CEvent {

    /**
     * Former state of the Quest
     * @var string enum(unavailable|available|ongoing|completed|rejected|failed)
     */
    public $stateBefore;
    
    /**
     * New state of the Quest
     * @var string enum(unavailable|available|ongoing|completed|rejected|failed)
     */
    public $stateAfter;
    
    /**
     * Constructor
     * @param mixed $sender Quest
     * @param string $stateBefore enum(unavailable|available|ongoing|completed|rejected|failed|succeeded)
     * @param string $stateAfter enum(unavailable|available|ongoing|completed|rejected|failed|succeeded)
     * @param array $params default array() (Quest params via $sender->params)
     */
    public function __construct($sender, $stateBefore, $stateAfter, $params = array()) {
        $this->stateBefore = $stateBefore;
        $this->stateAfter = $stateAfter;
        
        parent::__construct($sender, $params);
    }
}

?>
