<?php

/**
 * Displays a BattleMessage
 * 
 * @see BattleMessage
 * @package Widgets
 */

class BattleMessageWidget extends CWidget {

    /**
     * The BattleMessage to be rendered
     * @var BattleMessage
     */
    public $msg;
    
    /**
     * Renders the battlemessage.php view file
     */
    public function run() {
        // d($this->msg);
        $this->render("battlemessage");
    }
}