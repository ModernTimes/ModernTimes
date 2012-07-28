<?php

Yii::import('application.models._base.BaseShop');
Yii::import('application.components.shops.*');

/**
 * Right now, shops just have a stock and a description. 
 * Can be "overridden" by specialnessBehavior classes.
 * 
 * See BaseShop for a list of attributes and related Models.
 * 
 * @uses SpecialnessBehavior
 * @uses RequirementCheckerBehavior
 * @package System.Models
 */

class Shop extends BaseShop {
    
    /**
     * Returns a basic description / welcome message of the shop
     * @return string
     */
    public function getDesc() {
        return $this->desc;
    }
    
    /**
     * Array of items that the shop has to offer (with prices)
     * @return array
     */
    public function getStock() {
        return $this->shopItems;
    }
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     "application.components.RequirementCheckerBehavior");
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
                    'requirement' => array(
                        'alias' => 'shopRequirement' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                    'shopItems' => array(
                        'alias' => 'shopShopItems' . self::getScopeCounter(),
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