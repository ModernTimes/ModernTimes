<?php
/**
 * Retrieves quest data and renders the quests screen
 * 
 * @package Actions.Quests
 */

class QuestsAction extends CAction {

    /**
     * see above
     */
    public function run() {
        $Character = CD();
        $Character->loadQuests();

        $this->controller->render("quests", array(
            'CharacterQuests' => $Character->characterQuests,
        ));
    }
}