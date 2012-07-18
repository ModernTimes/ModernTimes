<?php

class GameController extends Controller {

    public $layout='//layouts/g_sidebar_standard';

    // standard action for the game controller is the map overview
    public function actionIndex() {
        $this->redirect(array('map'));
    }

    public function actions() {
        return array(
            'map'              => 'application.controllers.actions.MapAction',

            'mischief'         => 'application.controllers.actions.MischiefAction',
            'battleMonster'    => 'application.controllers.actions.BattleMonsterAction',
            'battleAction'     => 'application.controllers.actions.BattleActionAction',
            'encounter'        => 'application.controllers.actions.EncounterAction',
            
            'inventory'        => 'application.controllers.actions.inventory.InventoryAction',
            'autosell'         => 'application.controllers.actions.inventory.AutosellAction',
            'equip'            => 'application.controllers.actions.inventory.EquipAction',
            'unequip'          => 'application.controllers.actions.inventory.UnequipAction',
            
            'rest'             => 'application.controllers.actions.RestAction',
            
            'pablo'            => 'application.controllers.actions.PabloAction',
        );
    }
    
    public function actionCharacter() {
        $this->render('character', array("character" => CD()));
    }
    
    /**
     * Allows to fight a monster without going through an encounter.
     * Should only be used during development
     * ToDo: get rid of this in deployment
     */
    public function actionBattleMonsterDirectly($monsterID) {
        $battleMonsterAction = new BattleMonsterAction($this, "battleMonster");
        $battleMonsterAction->monsterID = $monsterID;
        $this->runAction($battleMonsterAction);
    }
    
    
    
    public function filters() {
        return array(
            'isRegistered', 
            // has active character
            'initCharacterDataComponent', 
            'noOngoingBattle',
            'noOngoingEncounter',
            'hasTurns + mischief, battleMonster, rest',
            'hasHp + mischief',
            // 'debugInfo'
            );
    }
    
    protected function beforeRender($view) {
        PQPLogRoute::logMemory("memory used before render");
        return true;
    }
    public function beforeAction($action) {
        PQPLogRoute::logMemory("memory used before game action");
        Yii::beginProfile("game action: " . $action->id);
        return true;
    }
    
    public function afterAction($action) {
        $character = CD();

        // Add GoodForNothing effect if character has 0 hp
        if($character->hp <= 0) {
            // Add GFN (ID 1) for 3 turns, unless it's already there
            Yii::app()->tools->addEffect(1, 3, array('addTurns' => false));
        }
        
        // d($character);
        // Save Character AR in case it changed
        // (whether or not AR has changed is checked by AR behavior automatically)
        Yii::app()->cd->save();

        Yii::endProfile("game action: " . $action->id);
        
        return true;
    }
    
    // All GameController actions require the user to be logged in
    public function filterIsRegistered($c) {
        // if(Yii::app()->user->checkAccess('registered')) {
        if(!Yii::app()->user->isGuest) {
            $c->run();
        } else {
            Yii::app()->request->redirect(Yii::app()->user->returnUrl);
        }
    }
    
    /**  
     * game actions need initialized CharacterData
     * If no active character can be found, the user is redirected to
     * character/create automatically at this point
     */
    public function filterInitCharacterDataComponent($c) {
        Yii::app()->cd->initialize();
        $c->run();
    }
    
    // Players mustn't cheat their way out of ongoing battles
    public function filterNoOngoingBattle($c) {
        if(CD()->ongoingBattleID !== null && 
           Yii::app()->controller->action->id != "battleAction") {

            $this->redirect(array('battleAction'));
            return;
        }
        $c->run();
    }
    // Players mustn't cheat their way out of ongoing encounters or encounter paths
    public function filterNoOngoingEncounter($c) {
        if(CD()->ongoingEncounterID !== null && 
           Yii::app()->controller->action->id != "encounter") {

            $this->redirect(array('encounter'));
            return;
        }
        $c->run();
    }    
    
    // Turn consuming actions require that the character has ... turns left!
    public function filterHasTurns($c) {
        if(CD()->turns == 0) {
            EUserFlash::setErrorMessage("You can't do any more mischief right now.", 'validate');
            $this->redirect(array('index'));
            return;
        }
        $c->run();
    }
    
    // Certain game actions require that the character has at least 1 hp
    public function filterHasHp($c) {
        if(CD()->hp <= 0) {
            EUserFlash::setErrorMessage("You are too exhausted to do any mischief right now.", 'validate');
            $this->redirect(array('index'));
            return;
        }
        $c->run();
    }
    
    public function filterDebugInfo($c) {
        Yii::trace("Session: " . var_export(Yii::app()->session, true));
        $c->run();
    }

}