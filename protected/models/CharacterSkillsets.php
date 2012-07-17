<?php

Yii::import('application.models._base.BaseCharacterSkillsets');

/**
 * Basic HAS_MANY association model
 * The skillsets that a character has defined
 * Only one can be active at a given time
 */

class CharacterSkillsets extends BaseCharacterSkillsets {
    
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}