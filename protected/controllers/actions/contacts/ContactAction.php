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
        $character = CD();
        $character->loadContacts();

        foreach($character->characterContacts as $CharacterContact) {
            if($CharacterContact->id == $charactercontactID) {
                break;
            }
        }
        
        $this->controller->render("contact", array(
            'CharacterContact' => $CharacterContact
        ));
    }
}