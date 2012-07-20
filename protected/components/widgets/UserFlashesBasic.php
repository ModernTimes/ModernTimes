<?php

/**
 * Displays UserFlash messages, if there are any
 * 
 * @package Widgets
 */

class UserFlashesBasic extends CWidget {

    /**
     * Renders the userFlashesBasic.php view file 
     */
    public function run() {
        $this->render("userFlashesBasic");
    }
}