<?php

/**
 * Can be attached to any Model class with a requirementID attribute.
 * Provides a method which checks if a Character fulfills a number of
 * requirements as specified by the Requirement record indicated by
 * the requirementiD attribute of the owner model record.
 * If a model record needs to check requirements with an algorithm different
 * from the basic one provided by this Behavior, we need to define a
 * SpecialnessBehavior class for that record which specifies a meetsRequirements
 * method.
 * 
 * @uses Requirement
 * @package System
 */

class RequirementCheckerBehavior extends CModelBehavior {
    
    /**
     * Checks whether a Character fulfills the requirements specified by the
     * owner's Requirement model.
     * @param Character $Character
     * @param bool $generateMessages
     * @return boolean 
     */
    function meetsRequirements($Character, $generateMessages = true) {
        $Requirement = $this->owner->requirement;
        if(!is_a($Requirement, "Requirement")) {
            return true;
        }
        
        if(is_a($Requirement->quest, "Quest")) {
            if(!$Character->hasQuestCompleted($Requirement->quest)) {
                if($generateMessages) {
                    EUserFlash::setErrorMessage("Only for characters who have completed the quest \"" . $Requirement->quest->name . "\"");
                }
                return false;
            }
        }
        
        switch($Requirement->class) {
            case "banker":
            case "consultant":
                if($Character->class != $Requirement->class) {
                    if($generateMessages) {
                        EUserFlash::setErrorMessage("Only " . $Requirement->class . "s can do that");
                    }
                    return false;
                }
                break;
            case "resoluteness":
            case "willpower":
            case "cunning":
                if($Character->getClassType() != $Requirement->class) {
                    if($generateMessages) {
                        EUserFlash::setErrorMessage(ucfirst($Character->class) . "s can't do that");
                    }
                    return false;
                }
                break;
            default:
                break;
        }
        switch($Requirement->sex) {
            case "male":
            case "female":
                if($Character->sex != $Requirement->sex) {
                    if($generateMessages) {
                        EUserFlash::setErrorMessage("Only for " . $Requirement->sex . " characters");
                    }
                    return false;
                }
                break;
            default:
                break;
        }
        
        if($Requirement->level > 0) {
            if($Character->getLevel() < $Requirement->level) {
                if($generateMessages) {
                    EUserFlash::setErrorMessage("You need to be level " . $Requirement->level . " to do that");
                }
                return false;
            }
        }
        if($Requirement->resoluteness > 0) {
            if($Character->getResolutenessBuffed() < $Requirement->resoluteness) {
                if($generateMessages) {
                    EUserFlash::setErrorMessage("You need to have " . $Requirement->resoluteness . " resoluteness to do that");
                }
                return false;
            }
        }
        if($Requirement->willpower > 0) {
            if($Character->getWillpowerBuffed() < $Requirement->willpower) {
                if($generateMessages) {
                    EUserFlash::setErrorMessage("You need to have " . $Requirement->willpower . " willpower to do that");
                }
                return false;
            }
        }
        if($Requirement->cunning > 0) {
            if($Character->getCunningBuffed() < $Requirement->cunning) {
                if($generateMessages) {
                    EUserFlash::setErrorMessage("You need to have " . $Requirement->cunning . " cunning to do that");
                }
                return false;
            }
        }
        if($Requirement->mainstat > 0) {
            if($Character->getMainstatBuffed() < $Requirement->mainstat) {
                if($generateMessages) {
                    EUserFlash::setErrorMessage("You need to have " . $Requirement->mainstat . " " . $Character->getClassType() . " to do that");
                }
                return false;
            }
        }
        
        return true;
    }
}