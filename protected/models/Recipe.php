<?php

Yii::import('application.models._base.BaseRecipe');

/**
 * Basic version of the Recipe class
 * Used to check which items can be combined, and what the resulting item is
 */

class Recipe extends BaseRecipe {
    
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}