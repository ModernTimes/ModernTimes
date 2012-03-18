<?php

class GameController extends Controller {

    public $layout='//layouts/g_sidebar';

    public function actionIndex() {
        $this->redirect(array('go'));
    }

    public function actions() {
        return array(
            'go'              => 'application.controllers.actions.GoAction',
            'doMischief'      => 'application.controllers.actions.DoMischiefAction',
            'battleMonster'   => 'application.controllers.actions.BattleMonsterAction',
            'battleAction'    => 'application.controllers.actions.BattleActionAction',
            
            /* 'action2'=>array(
                            'class'=>'path.to.AnotherActionClass',
                            'propertyName'=>'propertyValue',
                    ), */
        );
    }
    
    public function actionCharacter() {
        $this->render('character', array("character" => CD()));
    }
    
    // ToDo: get rid of this in deployment
    public function actionBattleMonsterDirectly($monsterID) {
        $battleMonsterAction = new BattleMonsterAction($this, "battleMonster");
        $battleMonsterAction->monsterID = $monsterID;
        $this->runAction($battleMonsterAction);
    }
    
    
    
    public function filters() {
        return array('isRegistered', 'initCharacterDataComponent', 
            'checkOngoingBattle'
            // has active character
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
        
        // Save Character AR in case it changed
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
    
    /*  If no active character can be found, the user is redirected to
     *  character/create
     */
    public function filterInitCharacterDataComponent($c) {
        Yii::app()->cd->initialize();
        $c->run();
    }
    
    public function filterCheckOngoingBattle($c) {
        if(CD()->ongoingBattleID != 0 && 
           Yii::app()->controller->action->id != "battleAction") {

            $this->redirect(array('battleAction'));
            return;
        }
        $c->run();
    }
    
    public function filterDebugInfo($c) {
        Yii::trace("Session: " . var_export(Yii::app()->session, true));
        $c->run();
    }

}