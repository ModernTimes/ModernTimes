<?php

/**
 * Simple handler for the equipment view
 */

class EquipmentWidget extends CWidget {

    /**
     * @var CharacterEquipment $equipment
     */
    public $equipment;
    
    public function run() {
        // Get the active CharacterEquipment model
        $character = CD();
        $this->equipment = $character->getEquipment();
        
        $this->render("equipment");
    }
}