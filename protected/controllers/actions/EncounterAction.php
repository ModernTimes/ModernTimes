<?php
/**
 * Resolves an encounter
 * Cannot be called by user directly, so callFromWithinApplication has to be
 * set true before run() can be executed
 */

class EncounterAction extends CAction {

    public $encounterID;
    public $callFromWithinApplication;

    public $encounter;
    // public $params;
    
    public function run() {
        /**
         * Encounters can't be requested by the user directly, at least not 
         * the first step of an encounter path
         */
        if(CD()->ongoingEncounterID == null && !$this->callFromWithinApplication) {
            EUserFlash::setErrorMessage("Invalid choice", 'validate');
            $this->controller->redirect('index');
        }
        
        if(empty($this->encounterID)) {
            if(!empty($_GET['encounterID'])) {
                $this->encounterID = (int) $_GET['encounterID'];
            } elseif (!empty(CD()->ongoingEncounterID)) {
                $this->encounterID = CD()->ongoingEncounterID;
            }
        }
           
        
        $this->encounter = Encounter::model()->with(array(
            'effect' => array(
                'with' => array(
                    'charactermodifier'
                )
            ),
            // ToDo: we need only one of these two. But which one?
            'encounterEncounters',
            'encounterEncounters1',
            'encounterItems'
        ))->findByPk($this->encounterID);
        
        if(!is_a($this->encounter, "Encounter")) {
            // exception
        }

        // legitimate = can the player arrive at this encounter, given the current
        // and previous encounters?
        if(!$this->legitimateEncounter()) {
            EUserFlash::setErrorMessage("Invalid choice", 'validate');
            Yii::app()->controller->redirect(array('game/encounter', array('encounterID' => CD()->ongoingEncounterID)));
        }
        
        
        // Resolve the encounter
        // d($this->encounter);
        
        $this->encounter->run();
        
        $this->controller->layout = '//layouts/g_sidebar';
        $this->controller->render('encounter', array("encounter" => $this->encounter));
    }

    public function legitimateEncounter() {
        // No ongoing encounter = fine
        if(CD()->ongoingEncounterID != null) {
            // current encounter = to_id from last encounter = fine
            // encounterEncounters instead?
            foreach($this->encounter->encounterEncounters1 as $previousEncounter) {
                if($previousEncounter->fromEncounterID == CD()->ongoingEncounterID) {
                    return true;
                }
            }
            // No previous encounter with to_id = current encounter = bad
            return false;
        }
        return true;
    }
}