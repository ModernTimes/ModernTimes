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
    
    function meetsRequirements($Character) {
        $Requirement = $this->owner->requirement;
        if(!is_a($Requirement, "Requirement")) {
            return true;
        }
        
        switch($Requirement->class) {
            case "banker":
            case "consultant":
                if($Character->class != $Requirement->class) {
                    EUserFlash::setErrorMessage("Only " . $Requirement->class . "s can do that");
                    return false;
                }
                break;
            case "resoluteness":
            case "willpower":
            case "cunning":
                if($Character->getClassType() != $Requirement->class) {
                    EUserFlash::setErrorMessage(ucfirst($Character->class) . "s can't do that");
                    return false;
                }
                break;
            default:
                break;
        }
        
        if($Requirement->level > 0) {
            if($Character->getLevel() < $Requirement->level) {
                EUserFlash::setErrorMessage("You need to be level " . $Requirement->level . " to do that");
                return false;
            }
        }
        if($Requirement->resoluteness > 0) {
            if($Character->getResolutenessBuffed() < $Requirement->resoluteness) {
                EUserFlash::setErrorMessage("You need to have " . $Requirement->resoluteness . " resoluteness to do that");
                return false;
            }
        }
        if($Requirement->willpower > 0) {
            if($Character->getWillpowerBuffed() < $Requirement->willpower) {
                EUserFlash::setErrorMessage("You need to have " . $Requirement->willpower . " willpower to do that");
                return false;
            }
        }
        if($Requirement->cunning > 0) {
            if($Character->getCunningBuffed() < $Requirement->cunning) {
                EUserFlash::setErrorMessage("You need to have " . $Requirement->cunning . " cunning to do that");
                return false;
            }
        }
        if($Requirement->mainstat > 0) {
            if($Character->getMainstatBuffed() < $Requirement->mainstat) {
                EUserFlash::setErrorMessage("You need to have " . $Requirement->mainstat . " " . $Character->getClassType() . " to do that");
                return false;
            }
        }
        
        return true;
    }
}