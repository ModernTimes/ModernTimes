<?php

/**
 * Displays a dropdown menu with active non-battle skills
 * 
 * @package Widgets
 */

class CharacterSkillMenuWidget extends CWidget {

    /**
     * The Character record
     * @var Character
     */
    public $character;
    
    /**
     * Retrieves the Character record and renders the characterSkillMenu 
     * view file
     */
    public function run() {
        $this->character = CD();
        $this->render("characterSkillMenu");
    }
}