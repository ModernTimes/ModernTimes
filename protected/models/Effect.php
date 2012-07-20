<?php

Yii::import('application.models._base.BaseEffect');
Yii::import('application.components.effects.*');

/**
 * Right now, effects are just charactermodifiers with a certain duration in 
 * turns. They can be "overridden" by specialnessBehavior classes.
 * 
 * See BaseEffect for a list of attributes and related Models
 * 
 * @see SpecialnessBehavior
 * @see CharacterModifierBehavior
 * @see Charactermodifier
 * @package System.Models
 */

class Effect extends BaseEffect {

    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @see SpecialnessBehavior
     * @see CharacterModifierBehavior
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
     * @see http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}