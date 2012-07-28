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
     * Returns the declaration of named scopes. A named scope represents a query
     * criteria that can be chained together with other named scopes and applied
     * to a query.
     * @link http://www.yiiframework.com/doc/api/1.1/CActiveRecord#scopes-detail
     * @return array the scope definition. The array keys are scope names
     */
    public function scopes() {
        return array(
            'withRelated' => array(
                'with' => array(
                    'effect' => array(
                        'alias' => 'characterEffectsEffect' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                )
            )
        );
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