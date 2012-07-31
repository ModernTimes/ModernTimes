<?php

/**
 * Displays user-based actions in the main menu (login, logout, etc.)
 * 
 * @package Widgets
 */

class UserMenuWidget extends CWidget {

    /**
     * Renders the userMenuWidget.php view file 
     */
    public function run() {
        $this->render("userMenu");
    }
}