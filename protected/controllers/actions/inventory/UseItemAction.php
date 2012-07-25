<?php
/**
 * Uses a usable Item
 * 
 * @package Actions.inventory
 */

class UseItemAction extends CAction {

    /**
     * Checks if the Character actually owns such an item, then uses it
     * and redirects to InventoryAction
     * @param int $itemID ID of the Item to be used
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
            
            $validCharacterItem = false;
            foreach($Character->characterItems as $CharacterItem) {
                if($CharacterItem->item->id == $itemID &&
                   $CharacterItem->n > 0) {
                    
                    $validCharacterItem = true;
                    break;
                }
            }
            
            if(!$validCharacterItem) {
                EUserFlash::setErrorMessage("You don't have that.");
            } else {
                
                $transaction = Yii::app()->tools->getTransaction();
                try {

                    $CharacterItem->n --;
                    if($CharacterItem->n < 1) {
                        $CharacterItem->delete();
                    } else { 
                        $CharacterItem->save();
                    }
                    
                    /**
                     * Actual usage logic is delegated to the Item (or its
                     * SpecialnessBehavior class)
                     */
                    $CharacterItem->item->call("resolveUsage", $Character);
                    
                    $Character->save();

                    $transaction->commit();
                    EUserFlash::setMessage("You used 1 " . $CharacterItem->item->name);

                } catch(Exception $e) {
                    $transaction->rollback();
                    EUserFlash::setErrorMessage("Weird database shit happened.");
                }
            }
        }

        $this->controller->redirect(array('inventory'));
    }
}