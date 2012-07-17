<?php

Yii::import('application.models._base.BaseEffect');
Yii::import('application.components.effects.*');

/**
 * Right now, effects are just charactermodifiers with a certain duration in 
 * turns. They can be "overridden" by specialnessBehavior classes.
 */

class Effect extends BaseEffect {

    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     'characterModifier'=>array(
                        'class'=>"application.components.CharacterModifierBehavior")
                     );
    }

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}