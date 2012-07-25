<?php

Yii::import('application.models._base.BaseShop');
Yii::import('application.components.shops.*');

/**
 * Right now, shops just have a stock and a description. 
 * Can be "overridden" by specialnessBehavior classes.
 * 
 * See BaseShop for a list of attributes and related Models
 * 
 * @uses SpecialnessBehavior
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
     * Just returns true, but can be "overridden" by SpecialnessBehavior
     * classes.
     * Has to generate a EUSerFlashMessage in case it returns false
     * @param Character $Character
     * @return boolean true
     */
    public function meetsRequirements($Character) {
        return true;
    }
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior");
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