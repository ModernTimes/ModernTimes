<?php
/**
 * Partner @ MBBCG
 * @package Actions.Consultant
 */

class ConsultantQuestGiverAction extends CAction {

    /**
     * See above
     */
    public function run() {
        $Character = CD();
        $consultantQuestIDs = array(9);
        
        $questNews = "I have no new tasks for you. Be gone!";
        foreach($Character->characterQuests as $CharacterQuest) {
            if(in_array($CharacterQuest->questID, $consultantQuestIDs)) {
                switch($CharacterQuest->state) {
                    // newly available quests: print introduction
                    case "available":
                        $questNews = "NEW QUEST BEGINS !!!";
                        $CharacterQuest->quest->setState("ongoing");
                        break;
                    case "succeeded":
                        $questNews = "QUEST COMPLETED !!!";
                        $CharacterQuest->quest->setState("completed");
                        break;
                    case "ongoing":
                        $questNews = "QUEST ONGOING !!!";
                        break;
                    default:
                        break;
                }
            }
        }
        
        EUserFlash::setMessage($this->controller->renderPartial(
                "consultant/questGiver", 
                array(
                    "questNews" => $questNews
                ), 
                true));
        
        $this->controller->redirect(array('consultantHQ'));
    }
}