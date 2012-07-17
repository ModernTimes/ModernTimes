<?php

Yii::import('application.models._base.BaseCharacterEffects');

/**
 * Basic HAS_MANY association model
 * Which effects are currently attached to a character?
 */

class CharacterEffects extends BaseCharacterEffects
{
    public function increaseDuration($turns) {
        $this->turns += (int) $turns;
    }

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}