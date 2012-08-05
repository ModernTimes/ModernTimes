<?php
/**
 * Rest in your home to regenerate hp and energy
 * @todo The effectiveness of resting depends on 135134 factors -- that all
 *       have to be implemented.
 * @todo reduce duration of certain effects (drunk, high, etc.) 
 * (raise RestEvent and let these effects listen)
 * @package Actions
 */

class RestAction extends CAction {

    /**
     * See above
     */
    public function run() {
        EUserFlash::setMessage("You rest.", '');
        
        CD()->increaseHp(15);
        CD()->increaseEnergy(15);
        
        Yii::app()->tools->spendTurn();

        // Don't forget to trigger the character data updates before the redirect
        $this->controller->afterAction($this);

        $this->controller->redirect(array('home'));
    }
}