<?php

Yii::import('application.models._base.BaseContact');
Yii::import('application.components.contacts.*');

/**
 * Holds information about contact types.
 * 
 * Can be "overridden" by specialnessBehavior classes
 * 
 * See BaseContact for a list of attributes and related Models.
 * 
 * @uses SpecialnessBehavior
 * @package System.Models
 */

class Contact extends BaseContact {
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
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