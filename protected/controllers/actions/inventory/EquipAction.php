<?php
/**
 * Equips an item in the proper equipment slot
 * If the slot is occupied, run UnequipAction as a child process
 * 
 * @todo check item requirements
 * 
 * @uses UnequipAction
 * @package Actions.Inventory
 */

class EquipAction extends CAction {

    /**
     * Check if the character owns the item, then equip it and redirect
     * to InventoryAction
     * @param int $itemID ID of the Item to be equipped
     */
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
            $CharacterItem = $Character->getCharacterItem($itemID);
            
            if($CharacterItem->n == 0) {
                EUserFlash::setErrorMessage("You don't have that.");
            } else {
                $Item = $CharacterItem->item;
                
                /**
                * Check: Is the item equippable?
                */
                $validTypes = array("weapon", "offhand", "accessory");
                if(!in_array($Item->type, $validTypes)) {
                    EUserFlash::setErrorMessage("That item is not equippable. You probably know that.");
                } else {
                    /**
                     * Check: Does the Character fulfill the requirements
                     * for equipping that item? 
                     */
                    if(!$Item->call("meetsRequirements", $Character)) {
                        // meetsRequirements generates more specific messages
                        // EUserFlash::setErrorMessage("You cannot equip that.");
                    } else {
                    
                        $transaction = Yii::app()->tools->getTransaction();
                        try {

                            /**
                            * Equipping implies that the item is not in the
                            * inventory anymore
                            */
                            $CharacterItem->n --;
                            if($CharacterItem->n < 1) {
                                $CharacterItem->delete();
                            } else { 
                                $CharacterItem->save();
                            }

                            $Equipment = $Character->getEquipment();

                            /**
                            * Find out which equipment slot the item should be
                            * equipped into
                            */
                            $slot = $Item->type;
                            /**
                            * Use the first open accessory slot
                            * If none is open, use the first and unequip the
                            * currently equipped item 
                            */
                            if($slot == "accessory") {
                                if(empty($Equipment->accessoryA)) {
                                    $slot = "accessoryA";
                                } elseif (empty($Equipment->accessoryB)) {
                                    $slot = "accessoryB";
                                } elseif (empty($Equipment->accessoryC)) {
                                    $slot = "accessoryC";
                                } else {
                                    $slot = "accessoryA";
                                }
                            }

                            // Detach all Charactermodifier event handlers
                            $Equipment->detachFromCharacter($Character);

                            // if there already is an item in the slot: unequip!
                            if(!empty($Equipment->{$slot})) {
                                $UnequipAction = new UnequipAction($this->controller, "unequip");
                                $UnequipAction->slot = $slot;
                                // to prevent starting a new transaction etc.
                                $UnequipAction->setChildAction();
                                $this->controller->runAction($UnequipAction);
                            }

                            // The actual equipping
                            $Equipment->{$slot . "ID"} = $Item->id;
                            $Equipment->{$slot} = $Item;
                            $Equipment->save();

                            // Re-Attach event handlers
                            $Equipment->attachToCharacter($Character);

                            // Don't forget to trigger the character data updates before the redirect
                            $this->controller->afterAction($this);

                            $transaction->commit();
                            EUserFlash::setMessage("You equipped your " . lcfirst($CharacterItem->item->name));

                        } catch(Exception $e) {
                            $transaction->rollback();
                            dd($e);
                            EUserFlash::setErrorMessage("Weird database shit happened.");
                        }
                    }
                }
            }
        }

        $this->controller->redirect(array('inventory'));
    }
}