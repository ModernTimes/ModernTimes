<?php

Yii::import('application.models._base.BaseFavor');
Yii::import('application.components.favors.*');

/**
 * Holds information about favors and handles their execution.
 * 
 * Can be "overridden" by specialnessBehavior classes
 * 
 * See BaseFavor for a list of attributes and related Models.
 * 
 * @uses SpecialnessBehavior
 * @uses RequirementCheckerBehavior
 * @package System.Models
 */

class Favor extends BaseFavor {

    /**
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * Handles Character asking CharacterContact for this favor
     * @param Character $Character
     * @param CharacterContacts $CharacterContact
     * @return bool success
     */
    public function resolve($Character, $CharacterContact) {
        EUserFlash::setErrorMessage("This favor has not been implemented yet");
        return false;
    }
    
    /**
     * "Overrides" meetsRequirements of RequirementCheckerBehavior to include
     * checking for proper contact treatments
     * @uses RequirementCheckerBehavior->meetsRequirement
     * @param Character $Character
     * @param CharacterContacts $CharacterContact 
     * @return bool
     */
    public function meetsRequirements($Character, $CharacterContact, $generateMessages = true) {
        // Check Character-based requirements
        $meetsRequirements = $this->asa("RequirementChecker")->meetsRequirements($Character, $generateMessages);
        
        foreach($CharacterContact->statuses as $status) {
            switch($this->{"requirement" . ucfirst($status)}) {
                case 1:
                    if(!$CharacterContact->{$status}) {
                        if($generateMessages) {
                            EUserFlash::setErrorMessage($CharacterContact->name . " needs to be " . $status . " to do that");
                        }
                        $meetsRequirements = false;
                    }
                    break;
                case -1:
                    if($CharacterContact->{$status}) {
                        if($generateMessages) {
                            EUserFlash::setErrorMessage($CharacterContact->name . " must not be " . $status);
                        }
                        $meetsRequirements = false;
                    }
                default:
                    break;
            }
        }
        
        return $meetsRequirements;
    }
    
    /**
     * Basic getter
     * @param CharacterContacts $CharacterContact
     * @return int 
     */
    public function getBadConscience($CharacterContact) {
        return $this->badConscience;
    }
    
    public function byebye($CharacterContact) {
        return "You lost your grip over " . $CharacterContact->name . ". " . 
               "But who cares? " . ucfirst(_personal($CharacterContact->sex)) .
               " fulfilled " . _possessive($CharacterContact->sex) . " purpose.";
    }
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
                     "RequirementChecker" => "application.components.RequirementCheckerBehavior",
               );
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