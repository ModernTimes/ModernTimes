<?php
/**
 * Gets rid of an Item
 * Gives the character cash, favours, and kudos according to the Item's
 * autosell values
 * 
 * @package Actions.Inventory
 */

class AutosellAction extends CAction {

    /**
     * Checks if the Character actually owns such an item, then sells it
     * and redirects to InventoryAction
     * @param int $itemID ID of the Item to be sold
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
            $Character = CD();
            $Character->loadItems();
            $CharacterItem = $Character->getCharacterItem($itemID);
            
            if($CharacterItem->n == 0) {
                EUserFlash::setErrorMessage("You don't have that.");
            } else {
                if(!$CharacterItem->item->autosellable) {
                    EUserFlash::setErrorMessage("You can't sell that.");
                } else {
                
                    $transaction = Yii::app()->tools->getTransaction();
                    try {

                        $CharacterItem->n --;
                        if($CharacterItem->n < 1) {
                            $CharacterItem->delete();
                        } else { 
                            $CharacterItem->save();
                        }

                        $gainCash = $Character->gainCash($CharacterItem->item->autosellCash, "autosell");

                        // Don't forget to trigger the character data updates before the redirect
                        $this->controller->afterAction($this);

                        $transaction->commit();
                        EUserFlash::setMessage("You sold 1 " . $CharacterItem->item->name . "." . 
                                ($gainCash == 0
                                    ? "<BR />You didn't think that you'd get something for that crap, did you?"
                                    : ""));

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