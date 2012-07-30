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
     * @param Character $Character 
     */
    public function attachToCharacter($Character) {
        if(!empty($this->weaponID)) {
            $this->weapon->call("attachToCharacter", $Character);
        }
        if(!empty($this->offhandID)) {
            $this->offhand->call("attachToCharacter", $Character);
        }
        if(!empty($this->accessoryAID)) {
            $this->accessoryA->call("attachToCharacter", $Character);
        }
        if(!empty($this->accessoryBID)) {
            $this->accessoryB->call("attachToCharacter", $Character);
        }
        if(!empty($this->accessoryCID)) {
            $this->accessoryC->call("attachToCharacter", $Character);
        }
    }

    /**
     * Detaches all Item model callbacks from the character event handlers
     * @param Character $Character 
     */
    public function detachFromCharacter($Character) {
        if(!empty($this->weaponID)) {
            $this->weapon->call("detachFromCharacter", $Character);
        }
        if(!empty($this->offhandID)) {
            $this->offhand->call("detachFromCharacter", $Character);
        }
        if(!empty($this->accessoryAID)) {
            $this->accessoryA->call("detachFromCharacter", $Character);
        }
        if(!empty($this->accessoryBID)) {
            $this->accessoryB->call("detachFromCharacter", $Character);
        }
        if(!empty($this->accessoryCID)) {
            $this->accessoryC->call("detachFromCharacter", $Character);
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
                    'weapon' => array(
                        'alias' => 'characterEquipmentWeapon' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'offhand' => array(
                        'alias' => 'characterEquipmentOffhand' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'accessoryA' => array(
                        'alias' => 'characterEquipmentAccessoryA' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'accessoryB' => array(
                        'alias' => 'characterEquipmentAccessoryB' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'accessoryC' => array(
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