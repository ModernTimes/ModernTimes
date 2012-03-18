<?php

Yii::import('application.models._base.BaseFamiliar');

class Familiar extends BaseFamiliar
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