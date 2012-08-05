<?php
/**
 * Home, sweet home
 * @package Actions.Home
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
        
        if(!$Character->hasQuestCompleted(1)) {
            
        }
        
        $personalQuestIDs = array(1);
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
            "currentCharacterQuests" => $this->currentCharacterQuests
        ));
    }
}