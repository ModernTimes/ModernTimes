<?php

Yii::import('application.models._base.BaseCharacterEquipments');

/**
 * Basic HAS_MANY association model
 * Which equipment configurations has a character defined?
 * Only one can be active at a given time
 * 
 * See BaseCharacterEquipments for a list of attributes and related Models
 * 
 * @see Character
 * @see Item
 * @package Character.Relations
 */

class CharacterEquipments extends BaseCharacterEquipments {
    
    /**
     * Attaches all Item model callbacks to the character event handlers
     * Care: The giix Model generator adds a "0" after the item slot names, 
     *       for whatever reason
     * @param Character $Character 
     */
    public function attachToCharacter($Character) {
        if(is_a($this->weapon0, "Item")) {
            $this->weapon0->call("attachToCharacter", $Character);
        }
        if(is_a($this->offhand0, "Item")) {
            $this->offhand0->call("attachToCharacter", $Character);
        }
        if(is_a($this->accessoryA0, "Item")) {
            $this->accessoryA0->call("attachToCharacter", $Character);
        }
        if(is_a($this->accessoryB0, "Item")) {
            $this->accessoryB0->call("attachToCharacter", $Character);
        }
        if(is_a($this->accessoryC0, "Item")) {
            $this->accessoryC0->call("attachToCharacter", $Character);
        }
    }

    /**
     * Detaches all Item model callbacks from the character event handlers
     * @param Character $Character 
     */
    public function detachFromCharacter($Character) {
        if(is_a($this->weapon0, "Item")) {
            $this->weapon0->call("detachFromCharacter", $Character);
        }
        if(is_a($this->offhand0, "Item")) {
            $this->offhand0->call("detachFromCharacter", $Character);
        }
        if(is_a($this->accessoryA0, "Item")) {
            $this->accessoryA0->call("detachFromCharacter", $Character);
        }
        if(is_a($this->accessoryB0, "Item")) {
            $this->accessoryB0->call("detachFromCharacter", $Character);
        }
        if(is_a($this->accessoryC0, "Item")) {
            $this->accessoryC0->call("detachFromCharacter", $Character);
        }
    }
    
    /**
     * Factory method to get Model objects
     * @see http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}