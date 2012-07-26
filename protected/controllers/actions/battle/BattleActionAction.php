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
     * @param string $skillID treated as int, only string because of $GET
     * @param string $itemID treated as int, only string because of $GET
     */
    public function run($skillID = "", $itemID = "") {
        $character = CD();
        if($character->ongoingBattleID === null) {
            EUserFlash::setErrorMessage("You are not engaged in any battle right now.", 'validate');
            $this->controller->redirect(array('index'));
        }
        
        if(empty($skillID) && !empty($_GET['skillID'])) {
            $skillID = $_GET['skillID'];
        }
        
        // syntax checks
        
        if(empty($skillID)) {
            $this->renderBattle();
            return;
        }
        
        // @todo add hasSkill function to Character
        foreach($character->characterSkills as $characterSkill) {
            if($characterSkill->skill->skillType == "combat" &&
               $characterSkill->skill->id == $skillID) {

                // Energy cost
                if($character->energy < $characterSkill->skill->costEnergy) {
                    EUserFlash::setErrorMessage("You do not have enough energy for that", 'validate');
                    $this->renderBattle();
                    return;
                }
                $character->energy -= $characterSkill->skill->costEnergy;
                
                $playerAction = $characterSkill->skill;
            }
        }
        
        // @todo repeat for Items

        if(!isset($playerAction)) {
            EUserFlash::setErrorMessage("It seems as if your last battle action was invalid.", 'validate');
            $this->renderBattle();
            return;
        }
       
        $battleID = CD()->ongoingBattleID;
        $this->_battle = Battle::reconstructBattle($battleID);
        if($this->_battle != false) {
            $this->_battle->playerAction($playerAction);
            $this->renderBattle();
        }
    }
}