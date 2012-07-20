<?php

Yii::import('application.models._base.BaseAreaMonsters');

/**
 * Basic HAS_MANY association model
 * Which monster are in an area, and with which probability do they appear?
 * 
 * See BaseAreaMonsters for a list of attributes and related Models
 * 
 * @see Area
 * @see Monster
 * @package System.Models.Relations
 */

class AreaMonsters extends BaseAreaMonsters {

    /**
     * Factory method to get Model objects
     * @see http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}