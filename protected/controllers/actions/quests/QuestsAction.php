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
        Yii::app()->session['lastPlace'] = array(
            'route' => array("quests"), 'name' => "your todos"
        );
        
        $Character = CD();
        $Character->loadQuests();

        $this->controller->render("quests", array(
            'CharacterQuests' => $Character->characterQuests,
        ));
    }
}