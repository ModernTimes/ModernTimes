<?php

/**
 * Displays a Quest.
 * Adds links to accept or reject the item, depending on its state
 * 
 * @uses Quest
 * @uses CharacterQuests
 * @package Widgets
 */

class QuestWidget extends CWidget {

    /**
     * The CharacterQuests record to be displayed
     * @var CharacterQuests
     */
    public $CharacterQuest;
    
    /**
     * Renders the item.php view file 
     */
    public function run() {
        $this->render("quest");
    }
}