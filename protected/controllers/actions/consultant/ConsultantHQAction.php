<?php
/**
 * Consultant guild house
 * @package Actions.Consultant
 */

class ConsultantHQAction extends CAction {

    /**
     * Quests to be displayed in the "project database"
     * @var array of CharacterQuests
     */
    public $currentCharacterQuests = array();
    
    /**
     * See above
     */
    public function run() {
        $Character = CD();
        if($Character->class != "consultant") {
            EUserFlash::setMessage("True: In real life, every smart-aleck youngster can be a consultant. In this game, we have to be a bit more restrictive, though.");
            $this->controller->redirect(array('index'));
        } else {
            $consultantQuestIDs = array(9);

            foreach($Character->characterQuests as $CharacterQuest) {
                if(in_array($CharacterQuest->questID, $consultantQuestIDs)) {
                    if($CharacterQuest->state == "available" ||
                            $CharacterQuest->state == "succeeded" ||
                            $CharacterQuest->state == "ongoing") {

                        /**
                         * Make sure to get all attributes, including those
                         * that were left out in CharacterData
                         */
                        $CharacterQuest->quest->refresh();
                        $this->currentCharacterQuests[] = $CharacterQuest;

                        if($CharacterQuest->state == "succeeded") {
                            $CharacterQuest->quest->setState("completed");
                        }
                    }
                }
            }

            $this->controller->render('consultant/hq', array(
                "currentCharacterQuests" => $this->currentCharacterQuests
            ));
        }
    }
}