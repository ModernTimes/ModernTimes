<?php
/**
 * The nice drug dealer at St. James's park
 */

class PabloAction extends CAction {

    public function run() {
        $this->controller->render("shops/pablo");
    }
}