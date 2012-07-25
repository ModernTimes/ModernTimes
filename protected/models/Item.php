<?php

Yii::import('application.models._base.BaseItem');
Yii::import('application.components.items.*');

/**
 * Can be "overridden" by specialnessBehavior classes
 * 
 * See BaseItem for a list of attributes and related Models
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterModifierBehavior
 * @package System.Models
 */

class Item extends BaseItem {

    /**
     * Resolves basic usage mechanics on a given Character
     * @param Character $Character 
     */
    public function resolveUsage($Character) {
        
    }
    
    
    /**
     * Returns an empty string, indicating that the default view files should
     * be used to generate the content for the popup of this item.
     * "Override" by SpecialnessBehavior classes if you want non-standard
     * popup content
     * @return string
     */
    public function getPopup() {
        return "";
    }

    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     "application.components.CharacterModifierBehavior",
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