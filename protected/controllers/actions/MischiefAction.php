<?php
/**
 * resolves doing mischief in a given area, i.e. either redirects to resolving 
 * an encounter or to start a battle against a monster
 */

class MischiefAction extends CAction {

    public function run($areaID) {
        $area = Area::model()->with('areaEncounters', 'areaMonsters')->findByPk((int)$areaID);
        
        /**
         * ToDo: IF everything is ok =
         * - Character's mainstat >= reqMainstat, 
         * - also call area's checkSpecialReq function (can be defined by 
         *   special behavior classes
         */
               
        // Will be used in some view files
        Yii::app()->session['lastArea'] = array(
            'id'   => $areaID,
            'name' => $area->name,
        );

        /**
         * 'type'   => 'encounter' OR 'monster'
         * 'id'     => encounterID OR monsterID
         * 'params' => array to pass on
         */
        $episode = $area->call("generateEpisode");
        
        if($episode['type'] == 'monster') {
            $battleMonsterAction = new BattleMonsterAction($this->controller, "battleMonster");
            $battleMonsterAction->monsterID = $episode['id'];
            $this->controller->runAction($battleMonsterAction);
        } else {
            $encounterAction = new EncounterAction($this->controller, "encounter");
            $encounterAction->encounterID = $episode['id'];
            $encounterAction->callFromWithinApplication = true;
            $this->controller->runAction($encounterAction);
        }
    }
}