<?php
/**
 * Rejects an available quest and redirects to $redirect
 * 
 * @package Actions.Quests
 */

class RejectQuestAction extends CAction {

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
                $CharacterQuest->quest->setState("rejected");
            }
        }
        $this->controller->redirect(array($redirect));
    }
}