<?php

Yii::import('application.models._base.BaseCharacterItems');

/**
 * Basic HAS_MANY association model
 * Which items does a character own, and how many of each?
 */

class CharacterItems extends BaseCharacterItems
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}