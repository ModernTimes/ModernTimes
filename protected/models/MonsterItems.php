<?php

Yii::import('application.models._base.BaseMonsterItems');

/**
 * Basic HAS_MANY association model
 * Which items does a monster drop, and with which probability?
 */

class MonsterItems extends BaseMonsterItems
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}