<?php

/**
 * Displays a BattleMessage
 * 
 * @uses BattleMessage
 * @package Widgets
 */

class BattleMessageWidget extends CWidget {

    /**
     * The BattleMessage to be rendered
     * @var BattleMessage
     */
    public $msg;
    
    /**
     * hero
     * @var mixed Character or Monster
     */
    public $hero;
    
    /**
     * enemy
     * @var mixed Character or Monster
     */
    public $enemy;
    
    /**
     * Renders the battlemessage.php view file
     */
    public function run() {
        // d($this->msg);
        $this->render("battlemessage");
    }
    
    /**
     * Parses a msg so that hero's and enemy's names and sexes are
     * considered appropriately
     * - %1$s: hero's name
     * - %2$s: personal pronoun for hero
     * - %3$s: possessive pronoun for hero
     * - %4$s: objective pronoun for hero
     * - %5$s: enemy's name
     * - %6$s: personal pronoun for enemy
     * - %7$s: possessive pronoun for enemy
     * - %8$s: objective pronoun for enemy
     * @param string $msg
     * @param mixed $hero
     * @param mixed $enemy 
     */
    public function parseMsg($msg) {
        return sprintf($msg, $this->hero->name, 
                             _personal($this->hero->sex),
                             _possessive($this->hero->sex),
                             _objective($this->hero->sex),
                             $this->enemy->name, 
                             _personal($this->enemy->sex),
                             _possessive($this->enemy->sex),
                             _objective($this->enemy->sex));
    }    
}