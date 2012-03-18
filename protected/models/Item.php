<?php

Yii::import('application.models._base.BaseItem');
Yii::import('application.components.items.*');

class Item extends BaseItem {

    /*
     * BACKGROUND STUFF
     */
    
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     'characterModifier'=>array(
                        'class'=>"application.components.CharacterModifierBehavior"),
                     );
    }
    
    public static function model($className=__CLASS__) {
            return parent::model($className);
    }
}