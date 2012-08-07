<?php

Yii::import('application.models._base.BaseFavor');
Yii::import('application.components.favors.*');

/**
 * Holds information about favors.
 * 
 * Can be "overridden" by specialnessBehavior classes
 * 
 * See BaseFavor for a list of attributes and related Models.
 * 
 * @uses SpecialnessBehavior
 * @uses RequirementCheckerBehavior
 * @package System.Models
 */

class Favor extends BaseFavor {
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     "application.components.RequirementCheckerBehavior",
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