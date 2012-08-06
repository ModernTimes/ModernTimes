<?php

/**
 * Starts a fight with a dummy monster
 * 
 * @uses TutorialQuest
 * @package Actions.Quests.Tutorial 
 */

class QuestTutorialFightAction extends CAction {
    
    /**
     * See above 
     */
    public function run() {
        $Character = CD();
        $CharacterQuest = $Character->getCharacterQuest(1);
        
        if($CharacterQuest->state == 'completed') {
            EUserFlash::setErrorMessage("You already woke up successfully. Remember?");
            $this->controller->redirect(array("home"));
        } else {
            // step already completed?
            if($CharacterQuest->quest->params["battleskills"]) {
                EUserFlash::setErrorMessage("You already fought that fight.");
                $this->controller->redirect(array("home"));
            } else {
                
                $battleMonsterAction = new BattleMonsterAction($this->controller, "battleMonster");
                $battleMonsterAction->monsterID = $CharacterQuest->quest->getMonsterID();
                $battleMonsterAction->callFromWithinApplication = true;
                $this->controller->runAction($battleMonsterAction);
            }
        }
    }
}

?>
