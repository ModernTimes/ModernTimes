<?php

Yii::import('application.models._base.BaseCharacterFamiliars');

/**
 * Basic HAS_MANY association model
 * Which familiars does a character have?
 * Only one can be active at a given time
 */

class CharacterFamiliars extends BaseCharacterFamiliars
{
    // Calculate based on xp
    public function getLevel() {
        return floor(sqrt($this->xp));
    }

    // Returns level progression in %
    public function getLevelProgress() {
        return sqrt($this->xp) - $this->getLevel();
    }
    
    
    public static function model($className=__CLASS__) {
		return parent::model($className);
    }
}