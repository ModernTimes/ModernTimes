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
            $CharacterContact = CharacterContacts::model()->withRelated()->findByPk($charactercontactID);
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
                    
                    $ContactFavors = $CharacterContact->contact->contactFavors;
                    $GeneralFavors = Favor::model()->findAll('generalFavor=1');
                    // d(array_merge($ContactFavors, $GeneralFavors));

                    $this->controller->render("contact", array(
                        'Character' => $Character,
                        'CharacterContact' => $CharacterContact,
                        'Favors' => array_merge($GeneralFavors, $ContactFavors)
                    ));
                }
            }
        }
    }
}