<?php

Yii::import('application.models._base.BaseArea');
Yii::import('application.components.areas.*');

class Area extends BaseArea {

        /**
         * Returns an episode, which is an array of the form:
         * 'type'   => 'encounter' OR 'monster'
         * 'id'     => encounterID OR monsterID
         * 'params' => array to pass on to BattleMonsterAction/EncounterAction
         */
        public function generateEpisode() {
            $rand = mt_rand(0,100);
            Yii::trace("RNG: " . $rand . ", combatProb: " . $this->combatProb * 100);
            if($rand <= $this->combatProb * 100) {
                $l = new Lottery();
                $l->addParticipants($this->areaMonsters);
                $winner = $l->getWinner();
                if($winner == false) {
                    // exception
                }
                
                return array(
                    'type'   => 'monster',
                    'id'     => $winner->monsterID,
                    'params' => array(),
                );
            } else {
                $l = new Lottery();
                $l->addParticipants($this->areaEncounters);
                $winner = $l->getWinner();
                if($winner == false) {
                    // exception
                }
                return array(
                    'type'   => 'encounter',
                    'id'     => $winner->encounterID,
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