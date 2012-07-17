<?php

Yii::import('application.models._base.BaseEncounterItems');

/**
 * Basic HAS_MANY association model
 * Which encounter drops which items with which probability?
 */

class EncounterItems extends BaseEncounterItems
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}