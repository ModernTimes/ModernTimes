<?php
/**
 * Collects data and renders the inventory screen
 */

class InventoryAction extends CAction {

    public function run() {
        $this->controller->render("inventory");
    }
}