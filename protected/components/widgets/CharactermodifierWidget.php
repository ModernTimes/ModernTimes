<?php

/**
 * Displays (or more often: returns) the Charactermodifier part of an
 * element's popup content, e.g. for Items and Effects
 * 
 * @uses Charactermodifier
 * @package Widgets
 */

class CharactermodifierWidget extends CWidget {

    /**
     * The Charactermodifier record that the display is based on
     * @var Charactermodifier
     */
    public $Charactermodifier;
    
    /**
     * Renders the charactermodifier.php view file 
     */
    public function run() {
        $this->render("charactermodifier");
    }
}