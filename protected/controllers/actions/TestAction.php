<?php

/**
 * The purpose if this action class is to test new features without having to 
 * mess around with actual game functions
 * This file should not be committed via git
 * 
 * @package Actions
 */
class TestAction extends CAction {

    /**
     * Your action logic 
     */
    public function run() {
        $Character = CD();
        
        $this->controller->forward("index");
    }
}

?>
