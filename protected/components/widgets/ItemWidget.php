<?php

/**
 * Displays an Item
 * adds additional links like "equip" or "unequip", depending on the
 * context in which the item is to be displayed
 * 
 * @uses Item
 * @package Widgets
 */

class ItemWidget extends CWidget {

    /**
     * The Item record to be displayed
     * @var Item
     */
    public $item;
    
    /**
     * Width and height of the item graphic, in px
     * @var int
     */
    public $width = 48;
    
    /**
     * margin-right of the item displays, in px
     * @var int
     */
    public $marginRight = 10;
    
    /**
     * @var string enum(free|inventory|equipment)
     */
    public $context = "free";

    /**
     * Number of items that the character possesses
     * Only relevant in context == inventory
     * @var int
     */
    public $n = 0;
    
    /**
     * Equipment slot in which the item is displayed
     * Relevant for unequip action
     * Only relevant in context == equipment
     * @var string
     */
    public $equipmentSlot = "";
    
    /**
     * Renders the item.php view file 
     */
    public function run() {
        $this->render("item");
    }
}