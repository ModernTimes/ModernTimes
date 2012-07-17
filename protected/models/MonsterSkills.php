<?php

Yii::import('application.models._base.BaseMonsterSkills');

/**
 * Basic HAS_MANY association model
 * Which skills can a monster use, and with which probability does it use them?
 */

class MonsterSkills extends BaseMonsterSkills
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}