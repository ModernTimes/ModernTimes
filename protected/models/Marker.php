<?php

Yii::import('application.models._base.BaseMarker');

/**
 * Holds information about markers that appear on the GoogleMap
 * 
 * See BaseMarker for a list of attributes and related Models
 * 
 * @uses RequirementCheckerBehavior
 * @package System.Models
 */

class Marker extends BaseMarker {

    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.RequirementCheckerBehavior");
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