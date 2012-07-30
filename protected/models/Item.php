<?php

Yii::import('application.models._base.BaseItem');
Yii::import('application.components.items.*');

/**
 * Can be "overridden" by specialnessBehavior classes
 * 
 * See BaseItem for a list of attributes and related Models.
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterModifierBehavior
 * @uses RequirementCheckerBehavior
 * @package System.Models
 */

class Item extends BaseItem {

    /**
     * Resolves basic usage mechanics on a given Character
     * @param Character $Character 
     */
    public function resolveUsage($Character) {
        $Character->changeHp($this->useHp);
        $Character->changeEnergy($this->useEnergy);
        
        // Effect
        if($this->useEffectID != null) {
            Yii::app()->tools->addEffect($Character, $this->useEffect, $this->useEffectDuration);
        }
    }
    
    
    /**
     * Returns an empty string, indicating that the default view files should
     * be used to generate the content for the popup of this item.
     * "Override" by SpecialnessBehavior classes if you want non-standard
     * popup content
     * @return string
     */
    public function getPopup() {
        return "";
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
                    'charactermodifier' => array(
                        'alias' => 'itemCharactermodifier' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'requirement' => array(
                        'alias' => 'itemRequirement' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'useEffect' => array(
                        'alias' => 'itemUseEffect' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    )
                )
            )
        );
    }

    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     "application.components.CharacterModifierBehavior",
                     "application.components.RequirementCheckerBehavior",
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