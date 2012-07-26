<?php

Yii::import('application.models._base.BaseQuest');

/**
 * Can be "overridden" by SpecialnessBehavior classes
 * 
 * See BaseQuest for a list of attributes and related Models
 * 
 * @uses SpecialnessBehavior
 * package System.Models 
 */

class Quest extends BaseQuest {
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior");
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