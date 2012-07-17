<?php

Yii::import('application.models._base.BaseEncounterEncounters');

/**
 * Basic HAS_MANY association model
 * Which encounter can be reached from which encounter?
 */

class EncounterEncounters extends BaseEncounterEncounters
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}