<?php

Yii::import('application.models._base.BaseCharacterContacts');

/**
 * Basic HAS_MANY association model
 * Which contacts does the character have?
 * 
 * See BaseCharacterContacts for a list of attributes and related Models
 * 
 * @see Character
 * @see Contact
 * @package Character.Relations
 */

class CharacterContacts extends BaseCharacterContacts {
    
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