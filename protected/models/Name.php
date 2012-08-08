<?php

Yii::import('application.models._base.BaseName');

/**
 * Provides access to a list of names with types boy, girl, and surname.
 * 
 * See BaseName for a list of attributes and related Models.
 * 
 * @package System.Models
 */

class Name extends BaseName {
    
    /**
     * Creates a random name for a given sex
     * @param string $sex enum[male|female)
     * return string 
     */
    public static function createName($sex) {
        $listFirstnames = self::model()->findAll("type='" . ($sex == 'male' ? 'boy' : 'girl') . "'");
        $listSurnames = self::model()->findAll("type='surname'");
        shuffle($listFirstnames);
        shuffle($listSurnames);
        return $listFirstnames[0]->name . " " . $listSurnames[0]->name;
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