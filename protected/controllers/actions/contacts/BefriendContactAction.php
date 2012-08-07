<?php
/**
 * Befriends a contact according to the befriending-algorithm. (Don't ask!)
 * 
 * @package Actions.Contacts
 */

class BefriendContactAction extends CAction {

    /**
     * See above
     */
    public function run($charactercontactID) {
        // positive integer
        $validSyntax = (!empty($charactercontactID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($charactercontactID)
                        && $charactercontactID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect(array("contacts"));
        }
        
        // Does CharacterContact belong to Character?
        $Character = CD();
        $CharacterContact = CharacterContacts::model()->findByPk($charactercontactID);
        if($CharacterContact->characterID != $Character->id) {
            EUserFlash::setErrorMessage($CharacterContact->name . " does not belong to you.");
            $this->controller->redirect(array("contacts"));
        }
        
        // Is CharacterContact not already treated?
        if($CharacterContact->isTreated()) {
            EUserFlash::setErrorMessage($CharacterContact->name . " is already " . $CharacterContact->getStatus());
            $this->controller->redirect(array("contact", "charactercontactID" => $charactercontactID));
        }
        
        /**
         * BEWARE: Actual business logic 
         */
        $transaction = Yii::app()->tools->getTransaction();
        try {

            Yii::app()->tools->spendTurn();
            
            $CharacterContact->befriended = 1;
            $CharacterContact->save();
            
            $transaction->commit();
            EUserFlash::setSuccessMessage("You became friends with " . $CharacterContact->name . ".");

        } catch(Exception $e) {
            $transaction->rollback();
            d($e);
            EUserFlash::setErrorMessage("Weird database shit happened.");
        }
        
        $this->controller->redirect(array("contact", "charactercontactID" => $charactercontactID));
    }
}