<?php

class BattleAction extends CAction {

    protected $_battle;
    
    public function renderBattle() {
        if(!is_a($this->_battle, "Battle")) {
            $battleID = CD()->ongoingBattleID;
            if(!$this->_battle = Battle::reconstructBattle($battleID)) {
                // throw exception
            }
        }

        // $test = base64_encode(serialize($this->_battle));
        // d($this->_battle->objectState);
        
        $this->controller->layout = '//layouts/g_fullscreen';
        $this->controller->render('battle', array("battle" => $this->_battle));
    }
}