<?php

Yii::import('application.models._base.BaseAreaMonsters');

/**
 * Basic HAS_MANY association model
 * Which monster are in an area, and with which probability do they appear?
 */

class AreaMonsters extends BaseAreaMonsters
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}