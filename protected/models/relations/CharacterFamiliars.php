<?php

Yii::import('application.models._base.BaseCharacterFamiliars');

/**
 * Basic HAS_MANY association model
 * Which familiars does a character have?
 * Only one can be active at a given time
 * 
 * See BaseCharacterFamiliars for a list of attributes and related Models
 * 
 * @see Character
 * @package Character.Relations
 */

class CharacterFamiliars extends BaseCharacterFamiliars
{
    /**
     * Returns the level of the familiar
     * @return int
     */
    public function getLevel() {
        return floor(sqrt($this->xp));
    }

    /**
     * Returns level progression in % (0.25 for 25%)
     * @return float
     */
    public function getLevelProgress() {
        $level = $this->getLevel();
        $xpCurrentToNextLevel = pow($level, 2) - pow($level, 2);
        $xpThisLevel = $this->xp - pow($level, 2);
        return $xpThisLevel / $xpCurrentToNextLevel;
    }
    
    
    /**
     * Factory method to get Model objects
     * @link http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}