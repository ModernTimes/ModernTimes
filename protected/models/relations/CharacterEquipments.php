<?php

Yii::import('application.models._base.BaseCharacterEquipments');

/**
 * Basic HAS_MANY association model
 * Which equipment configurations has a character defined?
 * Only one can be active at a given time
 * 
 * See BaseCharacterEquipments for a list of attributes and related Models
 * 
 * Eager loads weapon, offhand, accessoryA, B, and C. Use resetScope() to
 * prevent that.
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
     * Returns the declaration of named scopes. A named scope represents a query
     * criteria that can be chained together with other named scopes and applied
     * to a query.
     * @link http://www.yiiframework.com/doc/api/1.1/CActiveRecord#scopes-detail
     * @return array the scope definition. The array keys are scope names
     */
    public function scopes() {
        return array(
            'withRelated' => array(
                'with' => array(
                    'weapon0' => array(
                        'alias' => 'characterEquipmentWeapon' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'offhand0' => array(
                        'alias' => 'characterEquipmentOffhand' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'accessoryA0' => array(
                        'alias' => 'characterEquipmentAccessoryA' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'accessoryB0' => array(
                        'alias' => 'characterEquipmentAccessoryB' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'accessoryC0' => array(
                        'alias' => 'characterEquipmentAccessoryC' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                )
            )
        );
    }

    /**
     * Factory method to get Model objects
     * @link http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}