<?php
/**
 * ToDo: The effectiveness of resting depends on 135134 factors -- that all
 *       have to be implemented.
 */

class RestAction extends CAction {

    public function run() {
        EUserFlash::setMessage("You rest.", '');
        
        CD()->increaseHp(15);
        CD()->increaseEnergy(15);
        
        Yii::app()->tools->spendTurn();

        // Don't forget to trigger the character data updates before the redirect
        $this->controller->afterAction($this);

        $this->controller->redirect(array('index'));
    }
}