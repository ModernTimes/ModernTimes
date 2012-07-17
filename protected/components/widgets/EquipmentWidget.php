<?php

/**
 * Simple handler for the equipment view
 */

class EquipmentWidget extends CWidget {

    public $equipment;
    
    public function run() {
        $character = CD();
        $this->equipment = $character->getEquipment();
        $this->render("equipment");
    }
}