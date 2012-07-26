<?php
/**
 * Retrieves quest data and renders the quests screen
 * 
 * @package Actions
 */

class QuestsAction extends CAction {

    /**
     * see above
     */
    public function run() {
        $character = CD();

        $this->controller->render("quests", array(
            'CharacterQuests' => $character->characterQuests,
        ));
    }
}