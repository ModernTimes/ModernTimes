<?php
/**
 * Retrieves a CharacterContacts record and renders a menu for that contact
 * 
 * @package Actions.Contacts
 */

class ContactAction extends CAction {

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
        } else {
            // Does CharacterContact exist?
            $CharacterContact = CharacterContacts::model()->findByPk($charactercontactID);
            if(!is_a($CharacterContact, "CharacterContacts")) {
                EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
                $this->controller->redirect(array("contacts"));
            } else {
                $Character = CD();
            
                if($CharacterContact->characterID != $Character->id) {
                    EUserFlash::setErrorMessage("That contact does not belong to you.");
                    $this->controller->redirect(array("contacts"));
                } else {

                    Yii::app()->session['lastPlace'] = array(
                        'route' => array("contact", "charactercontactID" => $charactercontactID),
                        'name'  => "Contact: " . $CharacterContact->name
                    );

                    $this->controller->render("contact", array(
                        'Character' => $Character,
                        'CharacterContact' => $CharacterContact
                    ));
                }
            }
        }
    }
}