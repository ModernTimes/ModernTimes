<?php

/**
 * Provides a render function that other battle-related action classes can use
 * 
 * @package Actions.Battle
 */

class BattleAction extends CAction {

    /**
     * The Battle record
     * @var Battle
     */
    protected $_battle;
    
    /**
     * Renders the battle.php view file with $this->_battle
     * If $this->_battle is not defined, it tries to reconstruct the
     * ongoing battle as defined by CD()->ongoingBattleID
     */
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