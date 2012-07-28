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
                    'skill' => array(
                        'alias' => 'monsterSkillsSkill' . self::getScopeCounter(),
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