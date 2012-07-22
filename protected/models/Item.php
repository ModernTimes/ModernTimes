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