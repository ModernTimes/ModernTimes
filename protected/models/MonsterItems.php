<?php

Yii::import('application.models._base.BaseMonsterItems');

/**
 * Basic HAS_MANY association model
 * Which items does a monster drop, and with which probability?
 * 
 * See BaseMonsterItems for a list of attributes and related Models
 * 
 * @see Monster
 * @see Item
 * @package System.Models.Relations
 */

class MonsterItems extends BaseMonsterItems {
    
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