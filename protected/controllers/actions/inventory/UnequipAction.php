<?php
/**
 * Unequips an equipped item and puts it back into the inventory
 * 
 * @package Actions.Inventory
 */

class UnequipAction extends CAction {

    /**
     * name of the item slot to be unequipped
     * @var string
     */
    public $slot;
    
    /**
     * Specifies whether or not this action is run as a child process of
     * some other action. If so, this action does not redirect, render, etc.
     * @var bool
     */
    private $_childAction = false;
    
    /**
     * Unequips an equipped item and puts it back into the inventory
     * @param string $slot enum(weapon|offhand|accessoryA|etc)
     * @throws Exception if run as a child process, does not handle db
     * exceptions on its own but throws them around to be handled by the parent
     * process
     */
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
                $Item = $Equipment->{$slot};
                $transaction = Yii::app()->tools->getTransaction();
                try {

                    $Equipment->{$slot . "ID"} = null;
                    $Equipment->{$slot} = null;
                    $Equipment->save();

                    /**
                     * Unequipping implies that the item goes back to the
                     * inventory
                     */
                    $Character->gainItem($Item, 1, "unequip");

                    // Notify the world that something was unequipped
                    $event = new EquipItemEvent($Character, $Item, $slot);
                    $Character->onUnequipItem($event);
                    
                    if(!$this->_childAction) {
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
    
    /**
     * Basic setter
     * @param bool $state
     */
    public function setChildAction($state = true) {
        $this->_childAction = $state;
    }
}