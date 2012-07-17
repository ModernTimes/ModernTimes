<?php

Yii::import('application.models._base.BaseItem');
Yii::import('application.components.items.*');

class Item extends BaseItem {

    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     "application.components.CharacterModifierBehavior",
               );
    }
    
    public static function model($className=__CLASS__) {
            return parent::model($className);
    }
}