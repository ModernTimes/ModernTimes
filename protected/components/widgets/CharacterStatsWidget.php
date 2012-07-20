<?php

/**
 * Displays some important Character stats
 * 
 * @package Widgets
 */

class CharacterStatsWidget extends CWidget {

    /**
     * The Character record
     * @var Character
     */
    public $character;
    
    /**
     * The active Familiar record (if there is an active familiar)
     * @var Familiar 
     */
    public $familiar;
    
    /**
     * Retrieves the Character record and renders the characterStats view file
     */
    public function run() {
        $this->character = CD();
        $this->render("characterStats_leftColumn");
    }
}