<?php

Yii::import('application.models._base.BaseRecipe');

/**
 * Basic version of the Recipe class
 * Used to check which items can be combined, and what the resulting item is
 * 
 * See BaseRecipe for a list of attributes and related Models.
 * 
 * @see Item
 * @package System.Models
 */

class Recipe extends BaseRecipe {
    
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
                    'item1' => array(
                        'alias' => 'recipeItem1' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'item2' => array(
                        'alias' => 'recipeItem2' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'itemResult' => array(
                        'alias' => 'recipeItemResult' . self::getScopeCounter(),
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