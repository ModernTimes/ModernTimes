<?php

/**
 * Start a battle against a monster
 * Cannot be called by user directly
 */

class BattleMonsterAction extends CAction {

    public $monsterID;
    public $params;
    
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
        
        Yii::app()->tools->spendTurn();
        
        $this->controller->layout = '//layouts/g_fullscreen';
        $this->controller->render('battle', array("battle" => $battle));
    }
}