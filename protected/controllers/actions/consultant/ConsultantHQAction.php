<?php
/**
 * Consultant guild house
 * @package Actions.Consultant
 */

class ConsultantHQAction extends CAction {

    /**
     * See above
     */
    public function run() {
        $Character = CD();
        if($Character->class == "consultant") {
            $this->controller->render('consultant/hq');
        } else {
            EUserFlash::setMessage("True: In real life, every smart-aleck youngster can be a consultant. In this game, we have to be a bit more restrictive, though.");
            $this->controller->redirect(array('index'));
        }
    }
}