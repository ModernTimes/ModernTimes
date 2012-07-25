<?php

/**
 * Displays an Item group (like weapons, accessories, etc.)
 * 
 * @uses CharacterItems
 * @package Widgets
 */

class ItemGroupWidget extends CWidget {

    /**
     * Array of CharacterItems records
     * does not have to be filtered by Item->type. itemGroup view file will do
     * that
     * @var array
     */
    public $CharacterItems;
    
    /**
     * The item group (type) to be displaced
     * @var string enum('weapon'|'accessory'|'usable'|etc.)
     */
    public $itemType;
    
    /**
     * Renders the itemGroup.php view file 
     */
    public function run() {
        $this->render("itemGroup");
    }
}