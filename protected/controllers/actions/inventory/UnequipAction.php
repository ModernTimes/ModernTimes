<?php
/**
 * Unequips an equipped item and puts it back into the inventory
 */

class UnequipAction extends CAction {

    public function run($slot) {
        $validSlots = array("weapon", "offhand", "accessoryA", "accessoryB", "accessoryC");
        $validSyntax = (in_array($slot, $validSlots));
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            $Character = CD();
            $Equipment = $Character->getEquipment();
            
            if(empty($Equipment->{$slot})) {
                EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            } else {
                $Item = $Equipment->{$slot . "0"};
                $transaction = Yii::app()->db->beginTransaction();
                try {

                    $Equipment->{$slot} = null;
                    $Equipment->save();

                    $Character->gainItem($Item);

                    // Don't forget to trigger the character data updates before the redirect
                    $this->controller->afterAction($this);

                    $transaction->commit();
                    EUserFlash::setMessage("You put away your " . $Item->name);

                } catch(Exception $e) {
                    $transaction->rollback();
                    EUserFlash::setErrorMessage("Weird database shit happened.");
                }
            }
        }

        $this->controller->redirect(array('inventory'));
    }
}