<?php

Yii::import('application.models._base.BaseEncounterEncounters');

/**
 * Basic HAS_MANY association model
 * Which encounter can be reached from which encounter?
 * 
 * See BaseEncounterEncounters for a list of attributes and related Models
 * 
 * @see Encounter
 * @package System.Models.Relations
 */

class EncounterEncounters extends BaseEncounterEncounters {
    
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