<?php

Yii::import('application.models._base.BaseEquipment');

class Equipment extends BaseEquipment {
    
    // Attaches all Item Model callbacks to the character event handlers
    // Care: The giix Model generator adds a "0" after the item slot names, for whatever reason
    public function attachToCharacter($character) {
        if(is_a($this->weapon0, "Item")) {
            $this->weapon0->call("attachToCharacter", $character);
        }
        if(is_a($this->offhand0, "Item")) {
            $this->offhand0->call("attachToCharacter", $character);
        }
        if(is_a($this->accessoryA0, "Item")) {
            $this->accessoryA0->call("attachToCharacter", $character);
        }
        if(is_a($this->accessoryB0, "Item")) {
            $this->accessoryB0->call("attachToCharacter", $character);
        }
        if(is_a($this->accessoryC0, "Item")) {
            $this->accessoryC0->call("attachToCharacter", $character);
        }
    }
    
    public static function model($className=__CLASS__) {
            return parent::model($className);
    }
}