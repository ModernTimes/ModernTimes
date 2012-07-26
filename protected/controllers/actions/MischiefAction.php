<?php
/**
 * Resolves doing mischief in a given area, i.e. either redirects to resolving 
 * an encounter or to start a battle against a monster
 * 
 * @uses Area
 * @uses BattleMonsterAction
 * @uses EncounterAction
 * @package Actions
 */

class MischiefAction extends CAction {

    /**
     * Lets the Area record generate an episode (monster or encounter), then
     * starts either EncounterAction or BattleMonsterAction
     * @param string $areaID ID of the area in which the Character wants to do
     * mischief. int, but represented as a string because of $GET
     */
    public function run($areaID) {
        // Syntax check: positive integer?
        $validSyntax = (!empty($areaID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($areaID)
                        && $areaID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect('index');
        }
        
        // Valid area?
        $area = Area::model()->with(
                    'requirement', 
                    'areaEncounters', 
                    'areaMonsters'
                )->findByPk((int)$areaID);
        if(!is_a($area, "Area")) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect('index');
        }

        // Does the Character meet the requirements for doing mischief here?
        $Character = CD();
        if(!$area->call("meetsRequirements", $Character)) {
            $this->controller->redirect('index');
        }

        // Will be used in some view files
        Yii::app()->session['lastArea'] = array(
            'id'   => $areaID,
            'name' => $area->name,
        );

        /**
         * BEWARE: ACTUAL BUSINESS LOGIC 
         */
        
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