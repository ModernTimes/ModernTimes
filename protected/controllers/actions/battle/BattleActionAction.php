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
        $Character = CD();
        $Character->loadSkillsets();
        
        if($Character->ongoingBattleID === null) {
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
        foreach($Character->characterBattleskills as $CharacterBattleskill) {
            if($CharacterBattleskill->battleskillID == $battleskillID &&
                    $CharacterBattleskill->available) {

                // Enough energy?
                if($Character->energy < $CharacterBattleskill->battleskill->costEnergy) {
                    EUserFlash::setErrorMessage("You do not have enough energy for that", 'validate');
                    break;
                } else {
                    $playerAction = $CharacterBattleskill->battleskill;
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
        $battleID = $Character->ongoingBattleID;
        $this->_battle = Battle::reconstructBattle($battleID);
        if($this->_battle !== false) {
            $this->_battle->playerAction($playerAction);
            $this->renderBattle();
        }
    }
}