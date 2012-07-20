<?php

Yii::import('application.models._base.BaseCharacterSkills');

/**
 * Basic HAS_MANY association model
 * Which skills are available to the character, and which ones are permed?
 * (unlocked for future play-throughs)
 * 
 * See BaseCharacterSkills for a list of attributes and related Models
 * 
 * @see Character
 * @see Skill
 * @package Character.Relations
 */

class CharacterSkills extends BaseCharacterSkills {
    
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