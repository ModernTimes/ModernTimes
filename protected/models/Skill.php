<?php

Yii::import('application.models._base.BaseSkill');
Yii::import('application.components.skills.*');

/**
 * Represents and resolves non-battle skills
 * 
 * See BaseSkill for a list of attributes and related Models.
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterModifierBehavior
 * @package System.Models
 */

class Skill extends BaseSkill {

    /**
     * Resolves the Skill using basic skill mechanics
     * @param Character $Character
     */
    public function resolve($Character) {
    }
    
    /**
     * Basic getter
     * msgResolved is usually used as the main message in BattleMessages
     * @return string
     */
    public function getMsgResolved() {
        return $this->msgResolved;
    }
    /**
     * There might be a different message in case the duration of an effect
     * was increased (instead of a new effect getting in place)
     * @uses getMsgResolved
     * @return string
     */
    public function getMsgIncreasedDuration() {
        return (!empty($this->effectMsgIncreasedDuration) ? 
                    $this->effectMsgIncreasedDuration :
                    $this->getMsgResolved());
    }

    /**
     * Returns a string that can be used as the ocntent of a popup for this
     * Skill
     * @return string
     */
    public function getPopup() {
        return "<p>" . $this->desc . 
               ($this->costEnergy > 0 ? "<BR />&nbsp;<BR /><span class='btn btn-mini'><i class='icon-star'></i> " . $this->costEnergy . "</span>" : "") . 
               "</p>";
    }

    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array(
            "application.components.SpecialnessBehavior",
            "application.components.CharacterModifierBehavior",
        );
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
                    'charactermodifier' => array(
                        'alias' => 'skillCharactermodifier' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                )
            )
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