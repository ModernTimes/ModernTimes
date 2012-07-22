<?php

/**
 * Start a battle against a monster
 * Cannot be called by user directly
 * 
 * @see Battle
 * @package Actions
 */

class BattleMonsterAction extends CAction {

    /**
     * ID of the Monster record that the character has to fight
     * @var int
     */
    public $monsterID;
    
    /**
     * Initializes the Battle record, starts the battle, spends a turn, 
     * and renders the battle view
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
        
        Yii::app()->tools->spendTurn();
        
        $this->controller->layout = '//layouts/g_fullscreen';
        $this->controller->render('battle', array("battle" => $battle));
    }
}