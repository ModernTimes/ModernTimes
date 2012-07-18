<?php
/**
 * Equips an item in the proper equipment slot
 */

class EquipAction extends CAction {

    public function run($itemID) {
        // positive integer
        $validSyntax = (!empty($itemID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($itemID)
                        && $itemID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            /**
             * Check: Does the character have an item with that id?
             */
            
            $Character = CD();
            $Character->loadItems();
            
            $validCharacterItem = false;
            foreach($Character->characterItems as $CharacterItem) {
                if($CharacterItem->item->id == $itemID &&
                   $CharacterItem->n > 0) {
                    
                    $Item = $CharacterItem->item;
                    $validCharacterItem = true;
                    break;
                }
            }
            
            if(!$validCharacterItem) {
                EUserFlash::setErrorMessage("You don't have that.");
            } else {
                /**
                * Check: Is the item equippable?
                */
                
                $slot = $Item->type;
                $validSlots = array("weapon", "offhand", "accessoryA", "accessoryB", "accessoryC");
                if(!in_array($slot, $validSlots)) {
                    EUserFlash::setErrorMessage("That item is not equippable. You probably know that.");
                } else {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $CharacterItem->n --;
                        if($CharacterItem->n < 1) {
                            $CharacterItem->delete();
                        } else { 
                            $CharacterItem->save();
                        }

                        $Equipment = $Character->getEquipment();

                        // Detach event handlers
                        if(!empty($Equipment->{$slot})) {
                            // ...
                        }
                        $Equipment->{$slot} = $Item->id;
                        $Equipment->{$slot . "0"} = $Item;
                        // Re-attach event handlers

                        // Don't forget to trigger the character data updates before the redirect
                        $this->controller->afterAction($this);

                        $transaction->commit();
                        EUserFlash::setMessage("You equipped " . $CharacterItem->item->name);

                    } catch(Exception $e) {
                        $transaction->rollback();
                        EUserFlash::setErrorMessage("Weird database shit happened.");
                    }
                }
            }
        }

        $this->controller->redirect(array('inventory'));
    }
}