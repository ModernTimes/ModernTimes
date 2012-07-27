<?php
/**
 * Resolves an encounter
 * Cannot be called by user directly, so callFromWithinApplication has to be
 * set true before run() can be executed
 * 
 * @uses Encounter
 * @package Actions
 */

class EncounterAction extends CAction {

    /**
     * ID of the Encounter record that the character is to ... encounter
     * @see Encounter
     * @var int
     */
    public $encounterID;
    
    /**
     * Has to be set to true by some other action
     * Prevents the action from being called by users directly
     * @var bool
     */
    public $callFromWithinApplication = false;

    /**
     * The encounter to be ... encountered
     * Can be set instead of encounterID to skip Model record retrieval
     * @var Encounter
     */
    public $encounter;
    
    /**
     * Checks if the Encounter is legitimate and renders the encounter view 
     */
    public function run() {
        $Character = CD();
        /**
         * Encounters can't be requested by the user directly, at least not 
         * the first step of an encounter path
         * @todo Syntax checks
         */
        if($Character->ongoingEncounterID == null && !$this->callFromWithinApplication) {
            EUserFlash::setErrorMessage("Invalid choice", 'validate');
            $this->controller->redirect('index');
        }
        
        if(empty($this->encounterID) && empty($this->encounter)) {
            if(!empty($_GET['encounterID'])) {
                // @todo syntax checks
                $this->encounterID = (int) $_GET['encounterID'];
            } elseif (!empty(CD()->ongoingEncounterID)) {
                $this->encounterID = CD()->ongoingEncounterID;
            }
        }
        
        if(empty($this->encounter)) {
            $this->encounter = Encounter::model()->with(array(
                'effect' => array(
                    'with' => array(
                        'charactermodifier'
                    )
                ),
                'encounterEncounters',
                'encounterItems'
            ))->findByPk($this->encounterID);
        }
        
        if(!is_a($this->encounter, "Encounter")) {
            // exception
        }

        // legitimate = can the player arrive at this encounter, given the current
        // and previous encounters?
        if(!$this->legitimateEncounter($Character)) {
            EUserFlash::setErrorMessage("Invalid choice", 'validate');
            Yii::app()->controller->redirect(array('game/encounter', array('encounterID' => CD()->ongoingEncounterID)));
        }
        
        
        // Resolve the encounter
        // d($this->encounter);
        
        $this->encounter->run($Character);
        
        $this->controller->layout = '//layouts/g_sidebar';
        $this->controller->render('encounter', array("encounter" => $this->encounter));
    }

    /**
     * Checks if $this->encounter is legitimate, i.e. if the Character can
     * actually be at this point in an Encounter path
     * @return boolean 
     */
    public function legitimateEncounter($Character) {
        // No ongoing encounter = fine
        if($Character->ongoingEncounterID != null) {
            // current encounter = to_id from last encounter = fine
            // encounterEncounters instead?
            foreach($this->encounter->encounterEncounters1 as $previousEncounter) {
                if($previousEncounter->fromEncounterID == $Character->ongoingEncounterID) {
                    return true;
                }
            }
            // No previous encounter with to_id = current encounter = bad
            return false;
        }
        return true;
    }
}