<?php

/**
 * Displays the current equipment of the Character
 * 
 * @package Widgets
 */

class EquipmentWidget extends CWidget {

    /**
     * The active CharacterEquipment
     * @var CharacterEquipment
     */
    public $equipment;
    
    /**
     * Retrieves the equipment data and renders the equipment.php view file 
     */
    public function run() {
        // Get the active CharacterEquipment model
        $character = CD();
        $this->equipment = $character->getEquipment();
        
        $this->render("equipment");
    }
}