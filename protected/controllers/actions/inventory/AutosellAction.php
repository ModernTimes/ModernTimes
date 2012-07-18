<?php
/**
 * Gets rid of an item
 * Gives the character cash, favours, and kudos according to the item's
 * autosell values
 */

class AutosellAction extends CAction {

    public function run($itemID) {
        $validInput = (!empty($itemID)
                       // are all characters digits? rules out decimal numbers
                       && ctype_digit($itemID)
                       && $itemID >= 1);
        if(!$validInput) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            $Character = CD();
            $Character->loadItems();
            
            $validCharacterItem = false;
            foreach($Character->characterItems as $CharacterItem) {
                if($CharacterItem->item->id == $itemID) {
                    $validCharacterItem = true;
                    break;
                }
            }
            
            if(!$validCharacterItem) {
                EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            } else {
                
                if($CharacterItem->n < 1) {
                    EUserFlash::setErrorMessage("You don't own that.");
                } else {
                    
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        
                        $CharacterItem->n --;
                        $CharacterItem->save();
                        
                        $Character->gainCash($CharacterItem->item->autosellCash);
                        $Character->gainFavours($CharacterItem->item->autosellFavours);
                        $Character->gainKudos($CharacterItem->item->autosellKudos);

                        // Don't forget to trigger the character data updates before the redirect
                        $this->controller->afterAction($this);

                        $transaction->commit();
                        EUserFlash::setMessage("You sold 1 " . $CharacterItem->item->name);
                        
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