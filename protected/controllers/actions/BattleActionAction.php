<?php

/**
 * Act in an ongoing battle, 
 * either by using a skill or an item
 * ToDo: implement item actions
 */

class BattleActionAction extends BattleAction {

    public function run($skillID = "", $itemID = "") {
        $character = CD();
        if($character->ongoingBattleID === null) {
            EUserFlash::setErrorMessage("You are not engaged in any battle right now.", 'validate');
            $this->controller->redirect(array('index'));
        }
        
        if(empty($skillID) && !empty($_GET['skillID'])) {
            $skillID = (int) $_GET['skillID'];
        }
        if(empty($skillID)) {
            $this->renderBattle();
            return;
        }
        
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
        
        // ToDo: repeat for Items

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