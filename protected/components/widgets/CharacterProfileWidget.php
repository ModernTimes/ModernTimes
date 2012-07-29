<?php

/**
 * Displays a little Character profile
 * 
 * @package Widgets
 */

class CharacterProfileWidget extends CWidget {

    /**
     * The Character record
     * @var Character
     */
    public $character;
    
    /**
     * Renders the characterProfile view file
     */
    public function run() {
        $this->render("characterProfile");
    }
}