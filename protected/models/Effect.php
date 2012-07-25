<?php

Yii::import('application.models._base.BaseEffect');
Yii::import('application.components.effects.*');

/**
 * Right now, effects are just charactermodifiers with a certain duration in 
 * turns. They can be "overridden" by specialnessBehavior classes.
 * 
 * See BaseEffect for a list of attributes and related Models
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterModifierBehavior
 * @uses Charactermodifier
 * @package System.Models
 */

class Effect extends BaseEffect {

    /**
     * Returns an empty string, indicating that the default view files should
     * be used to generate the content for the popup of this effect.
     * "Override" by SpecialnessBehavior classes if you want non-standard
     * popup content
     * @return string
     */
    public function getPopup() {
        return "";
    }
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     'characterModifier'=>array(
                        'class'=>"application.components.CharacterModifierBehavior")
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