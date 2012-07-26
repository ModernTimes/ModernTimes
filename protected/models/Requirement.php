<?php

Yii::import('application.models._base.BaseRequirement');

/**
 * Requirement model class
 * Used to check if a Character fulfills certain requirements
 * 
 * See BaseRequirement for a list of attributes and related Models
 * 
 * @package System.Models
 */

class Requirement extends BaseRequirement {
    
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