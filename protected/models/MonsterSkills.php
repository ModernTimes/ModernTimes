<?php

Yii::import('application.models._base.BaseMonsterSkills');

/**
 * Basic HAS_MANY association model
 * Which skills can a monster use, and with which probability does it use them?
 * 
 * See BaseMonsterSkills for a list of attributes and related Models
 * 
 * @see Monster
 * @see Skill
 * @package System.Models.Relations
 */

class MonsterSkills extends BaseMonsterSkills {
    
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