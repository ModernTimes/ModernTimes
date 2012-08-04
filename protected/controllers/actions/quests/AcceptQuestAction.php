<?php
/**
 * Accepts an available quest and redirects to $redirect
 * 
 * @todo Create additional success messages
 * 
 * @package Actions.Quests
 */

class AcceptQuestAction extends CAction {

    /**
     * See above
     */
    public function run($questID, $redirect = "index") {
        // positive integer
        $validSyntax = (!empty($questID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($questID)
                        && $questID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            $Character = CD();
            $CharacterQuest = $Character->getCharacterQuest($questID);
            if($CharacterQuest->state != "available") {
                EUserFlash::setErrorMessage("You can't accept that project.");
            } else {
                EUserFlash::setSuccessMessage("You accepted the following task: <b>" . 
                        $CharacterQuest->quest->name . "</b>.<BR />Don't mess it up!");
                $CharacterQuest->quest->setState("ongoing");
            }
        }
        $this->controller->redirect(array($redirect));
    }
}