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
     * Factory method to get Model objects
     * @link http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}