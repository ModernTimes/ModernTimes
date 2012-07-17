<?php

/**
 * Displays an item
 */

class ItemWidget extends CWidget {

    /**
     * @var Item $item
     */
    public $item;
    
    /**
     * adds additional links like "equip" or "unequip", depending on the
     * context in which the item is to be displayed
     * @var enum(free, inventory, equipment) $context
     */
    public $context = "free";

    /**
     * Number of items that the character possesses
     * Only relevant in context == inventory
     * @var int $n
     */
    public $n = 0;
    
    public function run() {
        $this->render("item");
    }
}