<?php
/**
 * Gets rid of an item
 * Gives the character cash, favours, and kudos according to the item's
 * autosell values
 */

class AutosellAction extends CAction {

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

        $this->controller->redirect(array('inventory'));
    }
}