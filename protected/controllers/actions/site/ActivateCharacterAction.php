<?php
/**
 * Marks a character as active (and the currently active one as inactive)
 * 
 * @package Actions.Character management
 */

class ActivateCharacterAction extends CAction {

    /**
     * See above
     * @param int $characterID ID of the Character to be activated
     */
    public function run($characterID) {
        // positive integer
        $validSyntax = (!empty($characterID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($characterID)
                        && $characterID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            $Character = Character::model()->find(
                'userID=:userID AND id=:characterID',
                array(':userID' => Yii::app()->user->id,
                      ':characterID' => $characterID)
            );
            
            if(!is_a($Character, "Character")) {
                EUserFlash::setErrorMessage("Got 'ya! That character isn't yours.");
            } else {
                if($Character->active) {
                    EUserFlash::setErrorMessage("That character is already active.");
                } else {
                    $transaction = Yii::app()->tools->getTransaction();
                    try {
                        // Set all other active Characters active = 0
                        $numberOfDeactivatedCharacters = Character::model()->updateAll(
                            array("active" => 0),
                            'userID=:userID AND active=1',
                            array(':userID'=>Yii::app()->user->id)
                        );

                        $Character->active = 1;
                        $Character->update();

                        $transaction->commit();
                        EUserFlash::setMessage("You are now playing as " . $Character->name . ", a " . $Character->getTitle() . ".");
                    } catch(Exception $e) {
                        $transaction->rollback();
                        EUserFlash::setErrorMessage("We really would have liked to 
                            activate your character, but some weird database shit 
                            happened. We promise to look into it, even if it's boring.
                            Promised.");
                    }
                }
            }
        }

        $this->controller->redirect(array('manageCharacters'));
    }
}