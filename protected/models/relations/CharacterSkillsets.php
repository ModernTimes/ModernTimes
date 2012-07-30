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
                    'pos1' => array(
                        'alias' => 'characterSkillsetPos1' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'pos2' => array(
                        'alias' => 'characterSkillsetPos2' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'pos3' => array(
                        'alias' => 'characterSkillsetPos3' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'pos4' => array(
                        'alias' => 'characterSkillsetPos4' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'pos5' => array(
                        'alias' => 'characterSkillsetPos5' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'pos6' => array(
                        'alias' => 'characterSkillsetPos6' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'pos7' => array(
                        'alias' => 'characterSkillsetPos7' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'pos8' => array(
                        'alias' => 'characterSkillsetPos8' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'pos9' => array(
                        'alias' => 'characterSkillsetPos9' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'pos10' => array(
                        'alias' => 'characterSkillsetPos10' . self::getScopeCounter(),
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