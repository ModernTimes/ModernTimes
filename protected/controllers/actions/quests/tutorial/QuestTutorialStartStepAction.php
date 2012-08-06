<?php

/**
 * Starts a task within the Tutorial quest
 * 
 * @uses TutorialQuest
 * @package Actions.Quests.Tutorial 
 */

class QuestTutorialStartStepAction extends CAction {
    
    /**
     * See above 
     */
    public function run($step) {
        $Character = CD();
        $CharacterQuest = $Character->getCharacterQuest(1);
        
        // Valid step identifier?
        if(!in_array($step, $CharacterQuest->quest->getSteps())) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            if($CharacterQuest->state == 'completed') {
                EUserFlash::setErrorMessage("You already woke up successfully. Remember?");
            } else {
                // step already completed?
                if($CharacterQuest->quest->params[$step]) {
                    EUserFlash::setErrorMessage("You already remembered that.");
                } else {
                    // Other step not completed yet?
                    if(in_array($CharacterQuest->quest->params['currentStep'], $CharacterQuest->quest->getSteps())) {
                        EUserFlash::setErrorMessage($CharacterQuest->quest->getDescStatus());
                    } else {

                        // Start the step
                        $CharacterQuest->quest->startStep($step);
                        // Flash current step explanation
                        EUserFlash::setSuccessMessage($CharacterQuest->quest->call("getDescStatus"));
                        // Prepare the step                        /
                        call_user_func(array($CharacterQuest->quest, "prepareStep" . ucfirst($step)));
                        // Save the quest state
                        $CharacterQuest->quest->saveParams();
                    }
                }
            }
        }
        
        $this->controller->redirect(array("home"));
    }
}

?>
