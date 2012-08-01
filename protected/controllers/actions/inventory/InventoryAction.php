<?php
/**
 * Retrieves item data and renders the inventory screen
 * @todo Save last active tab and return to that tab in inventory screen
 * 
 * @package Actions.Inventory
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