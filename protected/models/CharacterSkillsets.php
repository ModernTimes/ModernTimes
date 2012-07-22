<?php

Yii::import('application.models._base.BaseCharacterSkillsets');

/**
 * Basic HAS_MANY association model
 * The skillsets that a character has defined
 * Only one can be active at a given time
 * 
 * See BaseCharacterSkillsets for a list of attributes and related Models
 * 
 * @see Character
 * @see Skill
 * @package Character.Relations
 */

class CharacterSkillsets extends BaseCharacterSkillsets {
    
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