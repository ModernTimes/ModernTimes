<?php

class BattleMessageWidget extends CWidget {

    public $msg;
    
    public function run() {
        // d($this->msg);
        $this->render("battlemessage");
    }
}