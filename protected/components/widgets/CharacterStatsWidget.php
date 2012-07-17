<?php

/*
 * Simply handler for the characterStats view
 */

class CharacterStatsWidget extends CWidget {

    public $character;
    public $familiar;
    
    public function run() {
        $this->character = CD();
        $this->render("characterStats_leftColumn");
    }
}