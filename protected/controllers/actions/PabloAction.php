<?php
/**
 * The nice drug dealer at St. James's park.
 * Just a skeleton, not implemented yet.
 * @todo implement
 * 
 * @package Actions
 */

class PabloAction extends CAction {

    /**
     * Renders the shops/pablo.php view file 
     */
    public function run() {
        $this->controller->render("shops/pablo");
    }
}