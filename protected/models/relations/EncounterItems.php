<?php

Yii::import('application.models._base.BaseEncounterItems');

/**
 * Basic HAS_MANY association model
 * Which encounter drops which items with which probability?
 * 
 * See BaseEncounterItems for a list of attributes and related Models
 * 
 * @see Encounter
 * @see Item
 * @package System.Models.Relations
 */

class EncounterItems extends BaseEncounterItems {
    
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