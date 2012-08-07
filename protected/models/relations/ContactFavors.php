<?php

Yii::import('application.models._base.BaseContactFavors');

/**
 * Basic HAS_MANY association model
 * Which favors can a contact grant?
 * 
 * See BaseContactFavors for a list of attributes and related Models
 * 
 * @see Contact
 * @see Favor
 * @package System.Models.Relations
 */

class ContactFavors extends BaseContactFavors {
    
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