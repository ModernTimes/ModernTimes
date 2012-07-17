<?php

Yii::import('application.models._base.BaseAreaEncounters');

/**
 * Basic HAS_MANY association model
 * Which encounters can the area trigger, and with which probability?
 */

class AreaEncounters extends BaseAreaEncounters
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}