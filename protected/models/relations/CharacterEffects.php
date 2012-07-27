<?php

Yii::import('application.models._base.BaseCharacterEffects');

/**
 * Basic HAS_MANY association model
 * Which effects are currently attached to a character?
 * 
 * See BaseCharacterEffects for a list of attributes and related Models
 * 
 * @see Character
 * @see Effects
 * @package Character.Relations
 */

class CharacterEffects extends BaseCharacterEffects {
    
    /**
     * Increases the duration by $turns turns
     * @param int $turns 
     */
    public function increaseDuration($turns) {
        $this->turns += (int) $turns;
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