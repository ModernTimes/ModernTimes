<?php

Yii::import('application.models._base.BaseCharacterQuests');

/**
 * Basic HAS_MANY association model
 * What is the status of all quests for a given character?
 * 
 * Is pretty much telecontrolled by Quest
 * 
 * See BaseCharacterQuests for a list of attributes and related Models
 * 
 * @see Character
 * @package Character.Relations
 */

class CharacterQuests extends BaseCharacterQuests {
    
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