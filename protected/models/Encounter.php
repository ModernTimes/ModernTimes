<?php

Yii::import('application.models._base.BaseEncounter');

class Encounter extends BaseEncounter
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}