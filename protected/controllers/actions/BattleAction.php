<?php

/**
 * Provides a render function that other battle-related action classes can use
 */

class BattleAction extends CAction {

    protected $_battle;
    
    public function renderBattle() {
        if(!is_a($this->_battle, "Battle")) {
            $battleID = CD()->ongoingBattleID;
            if(!($this->_battle = Battle::reconstructBattle($battleID))) {
                // throw exception
            }
        }

        $this->controller->layout = '//layouts/g_fullscreen';
        $this->controller->render('battle', array("battle" => $this->_battle));
    }
}