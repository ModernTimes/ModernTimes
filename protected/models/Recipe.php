<?php

Yii::import('application.models._base.BaseRecipe');

/**
 * Basic version of the Recipe class
 * Used to check which items can be combined, and what the resulting item is
 * 
 * See BaseRecipe for a list of attributes and related Models
 * 
 * @see Item
 * @package System.Models
 */

class Recipe extends BaseRecipe {
    
    /**
     * Factory method to get Model objects
     * @see http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}