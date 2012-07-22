<?php

Yii::import('application.models._base.BaseArea');
Yii::import('application.components.areas.*');

/**
 * Models areas in the game, i.e. spots to do mischief in.
 * Can generate episodes, i.e. decide if the Character is confronted with
 * an Encounter or has to fight a monster.
 * 
 * See BaseArea for a list of attributes and related Models
 *
 * @uses SpecialnessBehavior
 * @package System.Models
 */

class Area extends BaseArea {

    /**
     * Returns an episode, which is an array of the form:
     * 'type'   => 'encounter' OR 'monster'
     * 'id'     => encounterID OR monsterID
     * 'params' => array to pass on to BattleMonsterAction/EncounterAction
     * @todo turn Episodes into a component
     * @todo ask for a Lottery object to make dependency injection possible
     * @todo once combat or encounter is decided, call new generateEpisode
     * or generateCombat methods, for easier testing
     * @uses Lottery
     * @return array
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

    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior");
    }

    /**
     * Factory method to get Model objects
     * @link http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
            return parent::model($className);
    }
}