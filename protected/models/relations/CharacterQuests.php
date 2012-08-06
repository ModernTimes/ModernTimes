<?php

Yii::import('application.models._base.BaseCharacterQuests');

/**
 * Basic HAS_MANY association model
 * What is the status of all quests for a given character?
 * 
 * Is pretty much telecontrolled by Quest
 * 
 * See BaseCharacterQuests for a list of attributes and related Models
 * 
 * @see Character
 * @package Character.Relations
 */

class CharacterQuests extends BaseCharacterQuests {
    
    /**
     * Checks if the CharacterQuest is visible 
     * @return bool
     */
    public function isVisible() {
        return ($this->visible && $this->state != "unavailable");
    }
    
    /**
     * Checks if the CharacterState is finished
     * @return boolean 
     */
    public function isFinished() {
        if($this->state == "completed" ||
                $this->state == "rejected" ||
                $this->state == "failed") {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Checks if the CharacterQuest has started
     * @return boolean 
     */
    public function hasStarted() {
        if($this->state != "unavailable" &&
                $this->state != "available") {
            
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Checks if CharacterQuest is ongoing
     * @uses hasStarted
     * @uses isFinished
     * @return bool
     */
    public function isOngoing() {
        return ($this->hasStarted() && !$this->isFinished());
    }
    
    /**
     * Returns the declaration of named scopes. A named scope represents a query
     * criteria that can be chained together with other named scopes and applied
     * to a query.
     * @link http://www.yiiframework.com/doc/api/1.1/CActiveRecord#scopes-detail
     * @return array the scope definition. The array keys are scope names
     */
    public function scopes() {
        return array(
            'withRelated' => array(
                'with' => array(
                    'quest' => array(
                        'alias' => 'characterQuestsQuest' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                )
            ),
        );
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