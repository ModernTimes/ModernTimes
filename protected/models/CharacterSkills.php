<?php

Yii::import('application.models._base.BaseCharacterSkills');

/**
 * Basic HAS_MANY association model
 * Which skills are available to the character, and which ones are permed?
 * (unlocked for future play-throughs)
 */

class CharacterSkills extends BaseCharacterSkills {
    
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}