<?php

Yii::import('application.models._base.BaseShopItems');


/**
 * Basic HAS_MANY association model
 * Which items are sold in which shops and for which price?
 * 
 * See BaseShopItems for a list of attributes and related Models
 * 
 * @see Shop
 * @see Item
 * @package System.Models.Relations
 */

class ShopItems extends BaseShopItems {
    
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
                    'item' => array(
                        'alias' => 'shopItemsItem' . self::getScopeCounter(),
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