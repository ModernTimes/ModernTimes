<?php

/**
 * Displays an item
 */

class ItemWidget extends CWidget {

    /**
     * @var Item
     */
    public $item;
    
    /**
     * adds additional links like "equip" or "unequip", depending on the
     * context in which the item is to be displayed
     * @var enum(free, inventory, equipment)
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
    
    public function run() {
        $this->render("item");
    }
}