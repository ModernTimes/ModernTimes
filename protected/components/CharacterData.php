<?php

class CharacterData extends CApplicationComponent
{
    // Here goes the Character model
    private $_model = null;
    
    // Called by Yii preloader
    // Used to initialize alias for Yii::app()->cd->_()
    public function init() {
        if (!function_exists('CD')) {
            function CD() {
                return Yii::app()->cd->_();
                // $argv = func_get_args();
                // call_user_func_array(array("CharacterData", '_'), $argv);
            }
        }
    }
    
    /*
     *  Called by GameController before any game actions are started
     *  ToDo: Only read the complete character record from the DB,
     *        if some 'changed' parameter was set in the meantime
     */
    public function initialize () {
        if(is_a(Yii::app()->session['CD'], "Character")) {
            // If: changed-paramter was set in DB
            if(true) {
                Yii::log("Character info was changed since last action. Well, it probably hasn't, but let's pretend.");
                $this->load();
            } else {
                Yii::log("Character info has not been changed since last action. Use session info.");
                $this->_model = Yii::app()->session['CD'];
            }
        } else {
            Yii::log("No Character session data found");
            $this->load();
        }
    }
    
    public function load() {
        $this->_model = Character::model()->with(array(
            // Care: The giix Model generator adds a "0" after the item slot names, for whatever reason
            'equipments'=>array('with' => array('weapon0','offhand0','accessoryA0','accessoryB0','accessoryC0'), 'condition'=>"`equipments`.`active`=1"),
            'familiars'=>array('condition'=>"`familiars`.`active`=1"),
            // ToDo: with slot1, slot2, ...
            'skillsets'=>array('condition'=>"`skillsets`.`active`=1"),
	    // 'characterItems' => array('with' => array('item')),
	    'characterSkills' => array('with' => array('skill' => array('with' => array('createEffect0'))), 
                                       'condition' => "available = 1"),
            'characterEffects'=>array('with' => array('effect')),
        ))->find('t.userID=:userID AND t.active=1', 
                 array(':userID'=>Yii::app()->user->id));

        // If no active character can be found: redirect
        // ToDo: Fix character/create
        if(!is_a($this->_model, "Character")) {
            Yii::app()->controller->redirect(array('site/index'));
            // Yii::app()->controller->redirect(array('character/create'));
        }
        
        // Let Equipment Model attach all Item event handlers to the Character class
        $equipment = $this->_model->getEquipment();
        $equipment->attachToCharacter($this->_model);
        
        foreach($this->_model->characterEffects as $characterEffect) {
            $characterEffect->effect->call("attachToCharacter", $this->_model);
        }
        
        PQPLogRoute::logMemory($this, "Completely loaded character data model");
        
        $this->saveSession();
    }
    
    // ToDo: Add further search criteria
    public function loadItems() {
        $this->_model->loadItems();
    }

    // Returns the Character model
    public function _() {
        return $this->_model;
    }
    
    public function save() {
        if($this->_model->attributesChanged()) {
            $this->_model->save();
            $this->saveSession();
            Yii::trace("CharacterData: Character model saved");
        } else {
            Yii::trace("CharacterData: Character model not saved, since it has not been modified");
        }
    }
    
    // ToDo: Since the Character record is red in full for every request,
    //       there is no need to use the session ...
    public function saveSession() {
        Yii::app()->session['CD'] = $this->_model;
    }
}