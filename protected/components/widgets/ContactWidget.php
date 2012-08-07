<?php

/**
 * Displays a Contact
 * 
 * @uses Contact
 * @package Widgets
 */

class ContactWidget extends CWidget {

    /**
     * The CharacterContact record to be displayed
     * @var CharacterContact
     */
    public $CharacterContact;
    
    /**
     * margin-right of the display, in px
     * @var int
     */
    public $marginRight = 10;
    
    /**
     * Width and height of the item graphic, in px
     * @var int
     */
    public $width = 48;
    
    /**
     * @var string enum(free|contacts)
     */
    public $context = "free";

    /**
     * Renders the item.php view file 
     */
    public function run() {
        $this->render("contact");
    }
}