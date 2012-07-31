<?php

/**
 * Act in an ongoing battle, 
 * either by using a Skill or an Item
 * @todo implement item actions
 * 
 * @package Actions.Battle
 */

class BattleActionAction extends BattleAction {

    /**
     * Checks if the battle action is legitimate and renders the battle view
     * @todo syntax checks for skillID and itemID
     * @uses Battle->playerAction
     * @param string $battleskillID treated as int, only string because of $GET
     * @param string $itemID treated as int, only string because of $GET
     */
    public function run($battleskillID = "", $itemID = "") {
        $character = CD();
        if($character->ongoingBattleID === null) {
            EUserFlash::setErrorMessage("You are not engaged in any battle right now.", 'validate');
            $this->controller->redirect(array('index'));
        }
        
        if(empty($battleskillID) && !empty($_GET['battleskillID'])) {
            $battleskillID = $_GET['battleskillID'];
        }
        
        // syntax checks
        
        if(empty($battleskillID)) {
            $this->renderBattle();
            return;
        }
        
        // @todo add hasSkill function to Character
        foreach($character->characterBattleskills as $characterBattleskill) {
            if($characterBattleskill->battleskillID == $battleskillID &&
                    $characterBattleskill->available) {

                // Enough energy?
                if($character->energy < $characterBattleskill->battleskill->costEnergy) {
                    EUserFlash::setErrorMessage("You do not have enough energy for that", 'validate');
                    break;
                } else {
                    $playerAction = $characterBattleskill->battleskill;
                    break;
                }
            }
        }
        
        // @todo repeat for Items

        if(!isset($playerAction)) {
            EUserFlash::setErrorMessage("It seems as if your last battle action was invalid.", 'validate');
            $this->renderBattle();
            return;
        }
        $battleID = $character->ongoingBattleID;
        $this->_battle = Battle::reconstructBattle($battleID);
        if($this->_battle !== false) {
            $this->_battle->playerAction($playerAction);
            $this->renderBattle();
        }
    }
}