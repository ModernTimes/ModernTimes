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
    
    /**
     * Returns a HTML mantle depending on $number
     * Used by charactermodifier.php view file
     * @param float $number
     * @param string $string
     * @param bool $plusSign whether a plus sign should be added for positive
     * numbers
     * @return string 
     */
    public function addColor($number, $string, $plusSign = true) {
        if($number > 0) {
            return "<span style='color: green'>" . ($plusSign ? "+" : "") . $string . "</span>";
        } else {
            return "<span style='color: red'>" . $string . "</span>";
        }
    }    
}