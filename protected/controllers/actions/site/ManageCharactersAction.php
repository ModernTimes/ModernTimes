<?php

/**
 * Collects Character data and renders manageCharacters.php view file
 * 
 * @uses Character
 * @package Actions.Character management
 */

class ManageCharactersAction extends CAction {

    /**
     * See above
     */
    public function run() {
        $Characters = Character::model()->findAll(
            'userID=:userID',
            array(':userID'=>Yii::app()->user->id)
        );
        $this->controller->render('character/manageCharacters', array(
            'Characters' => $Characters)
        );
    }    
}

?>
