<?php

Yii::import('application.models._base.BaseCharacterEncounters');

/**
 * Basic HAS_MANY association model
 * Which encounters are in the encounter stack for the character?
 * 
 * See BaseCharacterEncounters for a list of attributes and related Models
 * 
 * @see Character
 * @see Encounter
 * @package Character.Relations
 */

class CharacterEncounters extends BaseCharacterEncounters {
    
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