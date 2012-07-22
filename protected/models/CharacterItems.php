<?php

Yii::import('application.models._base.BaseCharacterItems');

/**
 * Basic HAS_MANY association model
 * Which items does a character own, and how many of each?
 * 
 * See BaseCharacterItems for a list of attributes and related Models
 * 
 * @see Character
 * @see Item
 * @package Character.Relations
 */

class CharacterItems extends BaseCharacterItems {

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