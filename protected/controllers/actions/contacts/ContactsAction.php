<?php
/**
 * Retrieves contacts data and renders the contacts overview screen
 * 
 * @package Actions.Contacts
 */

class ContactsAction extends CAction {

    /**
     * See above
     */
    public function run() {
        $character = CD();
        $character->loadContacts();

        $this->controller->render("contacts", array(
            'CharacterContacts' => $character->characterContacts
        ));
    }
}