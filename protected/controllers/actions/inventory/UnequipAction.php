<?php
/**
 * Unequips an equipped item and puts it back into the inventory
 */

class UnequipAction extends CAction {

    /**
     * name of the item slot to be unequipped
     * @var string
     */
    public $slot;
    
    private $_childAction = false;
    
    public function run($slot = null) {
        if(empty($slot)) {
            $slot = $this->slot;
        }
        
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
                $transaction = Yii::app()->tools->getTransaction();
                try {

                    $Equipment->{$slot} = null;
                    $Equipment->save();

                    /**
                     * Unequipping implies that the item goes back to the
                     * inventory
                     */
                    $Character->gainItem($Item);

                    if(!$this->_childAction) {
                        // Don't forget to trigger the character data updates before the redirect
                        $this->controller->afterAction($this);

                        $transaction->commit();
                    }
                    EUserFlash::setMessage("You put away your " . $Item->name);

                } catch(Exception $e) {
                    // if childAction: let motherAction deal with this shit
                    if($this->_childAction) {
                        throw $e;
                    } else {
                        $transaction->rollback();
                        EUserFlash::setErrorMessage("Weird database shit happened.");
                    }
                }
            }
        }

        if(!$this->_childAction) {
            $this->controller->redirect(array('inventory'));
        }
    }
    
    public function setChildAction($state = true) {
        $this->_childAction = $state;
    }
}