<?php
/**
 * Retrieves item data and renders the inventory screen
 * 
 * @package Actions.inventory
 */

class InventoryAction extends CAction {

    /**
     * Retrieves item data and renders the inventory.php view file
     */
    public function run() {
        $character = CD();
        $character->loadItems();

        $this->controller->render("inventory", array(
            'CharacterItems' => $character->characterItems,
        ));
    }
}