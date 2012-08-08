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
        Yii::app()->session['lastPlace'] = array(
            'route' => array("contacts"), 'name' => "Contacts"
        );
        
        $character = CD();
        $character->loadContacts();

        $this->controller->render("contacts", array(
            'CharacterContacts' => $character->characterContacts
        ));
    }
}