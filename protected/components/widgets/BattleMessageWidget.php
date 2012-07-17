<?php

/*
 *  Pretty simply so far, but can be used to encapsulate more complex battlemessages´display behavior later on
 */

class BattleMessageWidget extends CWidget {

    public $msg;
    
    public function run() {
        // d($this->msg);
        $this->render("battlemessage");
    }
}