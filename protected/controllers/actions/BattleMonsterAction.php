<?php

class BattleMonsterAction extends CAction {

    public $monsterID;
    public $params;
    
    /*
     *  ToDo: - Check: Can only be called from inside the application
     */
    public function run() {
        $battle = new Battle;
        $battle->combatantA = CD();
        $battle->combatantB = Monster::model()->with(array(
            'monsterSkills' => array('with' => array(
                'skill' => array('with' => array(
                    'createEffect0'))
                ))
            ))->findByPk($this->monsterID);
        $battle->start();
        
        Yii::app()->tools->spendAction();
        
        $this->controller->layout = '//layouts/g_fullscreen';
        $this->controller->render('battle', array("battle" => $battle));
    }
}