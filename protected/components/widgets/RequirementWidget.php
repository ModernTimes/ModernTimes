<?php

/**
 * Displays (or more often: returns) the Requirement part of an
 * element's popup content, e.g. for Items
 * 
 * @uses Requirement
 * @package Widgets
 */

class RequirementWidget extends CWidget {

    /**
     * The Requirement record that the display is based on
     * @var Requirement
     */
    public $Requirement;
    
    /**
     * Renders the requirement.php view file 
     */
    public function run() {
        $this->render("requirement");
    }
}