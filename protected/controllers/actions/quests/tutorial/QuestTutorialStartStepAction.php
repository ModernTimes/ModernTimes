<?php

/**
 * Starts a task within the Tutorial quest
 * 
 * @uses TutorialQuest
 * @package Actions.Quests.Tutorial 
 */

class QuestTutorialStartStepAction extends CAction {
    
    /**
     * Array with string identifiers for the steps involved in this quest
     * @var array
     */
    private $_steps = array("inventory", "skills");
    
    /**
     * See above 
     */
    public function run($step) {
        // Valid step identifier?
        if(!in_array($step, $this->_steps)) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            $Character = CD();
            $CharacterQuest = $Character->getCharacterQuest(1);
            if($CharacterQuest->state == 'completed') {
                EUserFlash::setErrorMessage("You already woke up successfully. Remember?");
            } else {
                // step already completed?
                if($CharacterQuest->quest->params[$step]) {
                    EUserFlash::setErrorMessage("You already remembered that.");
                } else {
                    // Other step not completed yet?
                    if(in_array($CharacterQuest->quest->params['currentStep'], $this->_steps)) {
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
