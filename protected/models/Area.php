<?php

Yii::import('application.models._base.BaseArea');
Yii::import('application.components.areas.*');

class Area extends BaseArea
{
        /* ToDo: make use of area_encounters/monsters.prob 
         * returns an episode, which is an array:
         *  'type'   => 'encounter' OR 'monster'
         *  'id'     => encounterID OR monsterID
         *  'params' => array to pass on to BattleMonsterAction/ResolveEncounterAction
         */
        public function generateEpisode() {
            $rand = mt_rand(0,100);
            Yii::trace("RNG: " . $rand . ", combatProb: " . $this->combatProb * 100);
            if($rand <= $this->combatProb * 100) {
                $rand = mt_rand(0, count($this->areaMonsters)-1);
                return array(
                    'type'   => 'monster',
                    'id'     => $this->areaMonsters[$rand]->monsterID,
                    'params' => array(),
                );
            } else {
                $rand = mt_rand(0, count($this->areaEncounters)-1);
                return array(
                    'type'   => 'encounter',
                    'id'     => $this->areaEncounters[$rand]->encounterID,
                    'params' => array(),
                );
            }
        }
    
        public function behaviors() {
            return array("application.components.SpecialnessBehavior");
        }
    
        public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}