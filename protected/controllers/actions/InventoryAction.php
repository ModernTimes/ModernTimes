<?php
/**
 * Collects items and renders the inventory screen
 */

class InventoryAction extends CAction {

    public function run() {
        $character = CD();
        
        $itemDataProvider = new CActiveDataProvider(
            CharacterItems::model()->with(
                    'item'
            )
        );

        $this->controller->render("inventory", array(
            'itemDataProvider' => $itemDataProvider,
        ));
    }
}