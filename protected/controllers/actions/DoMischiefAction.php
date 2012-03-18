<?php

class DoMischiefAction extends CAction {

    public function run($areaID) {
        if(CD()->hp <= 0) {
            EUserFlash::setErrorMessage("You are too exhausted to do any mischief right now.", 'validate');
            $this->controller->redirect(array('index'));
        }
        if(CD()->actions == 0) {
            EUserFlash::setErrorMessage("You can't do any more mischief right now.", 'validate');
            $this->controller->redirect(array('index'));
        }
        
        $area = Area::model()->with('areaEncounters', 'areaMonsters')->findByPk($areaID);
        
        // ToDo: IF everything is ok ...
                
        // Will be used in some view files
        Yii::app()->session['lastArea'] = array(
            'id'   => $areaID,
            'name' => $area->name,
        );

        /*
         *  'type'   => 'encounter' OR 'monster'
         *  'id'     => encounterID OR monsterID
         *  'params' => array to pass on
         */
        $episode = $area->call("generateEpisode");
        
        if($episode['type'] == 'monster') {
            $battleMonsterAction = new BattleMonsterAction($this->controller, "battleMonster");
            $battleMonsterAction->monsterID = $episode['id'];
            $this->controller->runAction($battleMonsterAction);
        } else {
            echo "ENCOUNTER";
        }
    }
}