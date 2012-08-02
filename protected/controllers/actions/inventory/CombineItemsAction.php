<?php
/**
 * Combines two items into a new one as long as there is a recipe
 * @todo Chose among different "that doesn't work" messages, all from
 * different adventure games
 * 
 * @package Actions.Inventory
 */

class CombineItemsAction extends CAction {

    /**
     * See above
     * @param int $item1ID ID of the first item
     * @param int $item2ID ID of the first item
     */
    public function run($item1ID, $item2ID) {
        // positive integer
        $validSyntax = (!empty($item1ID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($item1ID)
                        && $item1ID > 0 &&
                        !empty($item2ID)
                        && ctype_digit($item2ID)
                        && $item2ID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            $Character = CD();
            $Character->loadItems();
            $CharacterItem1 = $Character->getCharacterItem($item1ID);
            $CharacterItem2 = $Character->getCharacterItem($item2ID);
            
            if($CharacterItem1->n == 0 || $CharacterItem2->n == 0) {
                EUserFlash::setErrorMessage("You don't have that.");
            } else {
                
                // Is there a recipe for these ingredients?
                $Recipe = Recipe::model()->with('itemResult')->find(
                    '(t.item1ID=:item1ID AND t.item2ID=:item2ID) OR
                     (t.item2ID=:item1ID AND t.item1ID=:item2ID)', 
                    array(':item1ID'=>$item1ID, ':item2ID' => $item2ID)
                );
                if(!is_a($Recipe, "Recipe")) {
                    EUserFlash::setMessage("That doesn't work.");
                } else {
                
                    $transaction = Yii::app()->tools->getTransaction();
                    try {

                        $CharacterItem1->n --;
                        $CharacterItem2->n --;
                        if($CharacterItem1->n < 1) {
                            $CharacterItem1->delete();
                        } else { 
                            $CharacterItem1->save();
                        }
                        if($CharacterItem2->n < 1) {
                            $CharacterItem2->delete();
                        } else { 
                            $CharacterItem2->save();
                        }
                        
                        $Character->gainItem($Recipe->itemResult);
                        
                        $CharacterRecipe = $Character->getCharacterRecipe($Recipe);
                        $CharacterRecipe->n++;
                        $CharacterRecipe->save();

                        $transaction->commit();
                        
                        /**
                        EUserFlash::setMessage("You combine a " . $CharacterItem1->item->name . "." . 
                            "and a " . $CharacterItem2->item->name . " and get a " . $Recipe->itemResult->name);
                        */
                    } catch(Exception $e) {
                        d($e);
                        $transaction->rollback();
                        EUserFlash::setErrorMessage("Weird database shit happened.");
                    }
                }
            }
        }

        $this->controller->redirect(array('inventory'));
    }
}