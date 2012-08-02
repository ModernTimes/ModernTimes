<?php
/**
 * Retrieves item and recipe data and renders the inventory screen
 * @todo Save last active tab and return to that tab in inventory screen
 * 
 * @package Actions.Inventory
 */

class InventoryAction extends CAction {

    /**
     * See above
     */
    public function run() {
        $character = CD();
        $character->loadItems();
        $character->loadRecipes();

        $this->controller->render("inventory", array(
            'CharacterItems' => $character->characterItems,
            'CharacterRecipes' => $character->characterRecipes,
        ));
    }
}