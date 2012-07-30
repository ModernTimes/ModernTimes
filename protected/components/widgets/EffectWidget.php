<?php

/**
 * Displays an Effect (button style)
 * 
 * @uses Effect
 * @package Widgets
 */

class EffectWidget extends CWidget {

    /**
     * The Effect record to be displayed
     * @var Effect
     */
    public $effect;
    
    /**
     * Number of turns that the character possesses the displayed effect
     * @var int
     */
    public $turns = 0;
    
    /**
     * Additional styling information for the effect buttons
     * @var string
     */
    public $styles = "";
    
    /**
     * Renders the item.php view file 
     */
    public function run() {
        $this->render("effect");
    }
}