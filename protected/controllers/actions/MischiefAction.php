<?php
/**
 * Resolves doing mischief in a given area, i.e. either redirects to resolving 
 * an encounter or to start a battle against a monster.
 * 
 * If there are Encounters in the encounter queue, those are always handled
 * first.
 * 
 * @uses Area
 * @uses CharacterEncounters
 * @uses BattleMonsterAction
 * @uses EncounterAction
 * @package Actions
 */

class MischiefAction extends CAction {

    /**
     * See above
     * @param string $areaID ID of the area in which the Character wants to do
     * mischief. int, but represented as a string because of $GET
     */
    public function run($areaID) {
        $Character = CD();

        // Check for Encounters in the encounter queue first
        foreach($Character->characterEncounters as $CharacterEncounter) {
            if($CharacterEncounter->delay == 0) {
                $encounterAction = new EncounterAction($this->controller, "encounter");
                $encounterAction->encounter = $CharacterEncounter->encounter;
                $encounterAction->callFromWithinApplication = true;
                $CharacterEncounter->delete();
                $this->controller->runAction($encounterAction);
                return;
            }
        }
        
        // Syntax check: positive integer?
        $validSyntax = (!empty($areaID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($areaID)
                        && $areaID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect('index');
        }
        
        $Area = Area::model()->with(array(
            'requirement' => array(
                'scopes' => 'withRelated'
            ),
            'areaEncounters',
            'areaMonsters'
        ))->findByPk($areaID);
        
        // Valid area?
        if(!is_a($Area, "Area")) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect('index');
        }

        // Does the Character meet the requirements for doing mischief here?
        if(!$Area->call("meetsRequirements", $Character)) {
            $this->controller->redirect('index');
        }

        // Will be used in some view files
        Yii::app()->session['lastArea'] = array(
            'id'   => $areaID,
            'name' => $Area->name,
        );

        /**
         * BEWARE: ACTUAL BUSINESS LOGIC 
         */
        
        /**
        * 'type'   => 'encounter' OR 'monster'
        * 'id'     => encounterID OR monsterID
        * 'params' => array to pass on
        */
        $episode = $Area->call("generateEpisode");

        if($episode['type'] == 'monster') {
            $battleMonsterAction = new BattleMonsterAction($this->controller, "battleMonster");
            $battleMonsterAction->monsterID = $episode['id'];
            $battleMonsterAction->callFromWithinApplication = true;
            $this->controller->runAction($battleMonsterAction);
        } else {
            $encounterAction = new EncounterAction($this->controller, "encounter");
            $encounterAction->encounterID = $episode['id'];
            $encounterAction->callFromWithinApplication = true;
            $this->controller->runAction($encounterAction);
        }
    }
}