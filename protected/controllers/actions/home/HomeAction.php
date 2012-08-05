<?php
/**
 * Home, sweet home
 * @package Actions.Places
 */

class HomeAction extends CAction {

    /**
     * Quests to be displayed in the "personal todo list"
     * @var array of CharacterQuests
     */
    public $currentCharacterQuests = array();
    
    /**
     * See above
     */
    public function run() {
        $Character = CD();
        
        // Wake up tutorial quest in home
        $tutorialQuestDisplay = "";
        if(!$Character->hasQuestCompleted(1)) {
            $tutorialQuestDisplay = $this->controller->renderPartial(
                    'home/questTutorial', 
                    array("CharacterQuest" => $Character->getCharacterQuest(1)), 
                    true);
            
            $this->controller->render('home/home', array(
                "tutorialQuestDisplay" => $tutorialQuestDisplay
            ));
        } else {

            $personalQuestIDs = array();
            foreach($Character->characterQuests as $CharacterQuest) {
                if(in_array($CharacterQuest->questID, $personalQuestIDs)) {
                    if($CharacterQuest->isVisible() && 
                            !$CharacterQuest->isFinished()) {

                        $this->currentCharacterQuests[] = $CharacterQuest;

                        if($CharacterQuest->state == "succeeded") {
                            $CharacterQuest->quest->setState("completed");
                        }
                    }
                }
            }

            $this->controller->render('home/home', array(
                "currentCharacterQuests" => $this->currentCharacterQuests,
            ));
        }
        
    }
}