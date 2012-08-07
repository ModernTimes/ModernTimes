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
        Yii::app()->session['lastPlace'] = array(
            'route' => array("inventory"), 'name' => "your stuff"
        );

        $character = CD();
        $character->loadItems();
        $character->loadRecipes();

        $this->controller->render("inventory", array(
            'CharacterItems' => $character->characterItems,
            'CharacterRecipes' => $character->characterRecipes,
        ));
    }
}