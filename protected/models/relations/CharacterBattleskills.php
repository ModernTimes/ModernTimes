<?php

Yii::import('application.models._base.BaseCharacterBattleskills');

/**
 * Basic HAS_MANY association model
 * Which battleskills are available to the character, and which ones are permed?
 * (unlocked for future play-throughs)
 * 
 * See BaseCharacterBattleskills for a list of attributes and related Models
 * 
 * @see Character
 * @see Battleskill
 * @package Character.Relations
 */

class CharacterBattleskills extends BaseCharacterBattleskills {

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
                    'battleskill' => array(
                        'alias' => 'characterBattleskillsBattleskill' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                )
            )
        );
    }

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}