<?php
/**
 * Consultant guild house
 * @package Actions.Places
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
        Yii::app()->session['lastPlace'] = array(
            'route' => array("consultantHQ"), 'name' => "McBooz&Bain Consulting Group",
        );
        
        $Character = CD();
        if($Character->class != "consultant") {
            EUserFlash::setErrorMessage("True: In real life, every smart-aleck youngster can be a consultant. In this game, we have to be a bit more restrictive, though.");
            $this->controller->redirect(array('index'));
        }
        // Tutorial quest completed
        if(!$Character->hasQuestCompleted(1)) {
            EUserFlash::setErrorMessage("You've not even awake ...");
            $this->controller->redirect(array('index'));
        }
        
        $consultantQuestIDs = array(9);
        $Character->loadQuests();
        foreach($Character->characterQuests as $CharacterQuest) {
            if(in_array($CharacterQuest->questID, $consultantQuestIDs)) {
                if($CharacterQuest->isVisible() && 
                        !$CharacterQuest->isFinished()) {

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