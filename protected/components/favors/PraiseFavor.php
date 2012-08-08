<?php

/**
 * Praise = gain kudos in the contact's area of influence
 * @package Favors 
 */

class PraiseFavor extends CBehavior {
    
    public function resolve($Character, $CharacterContact) {
        $Character->gainKudos(
            $CharacterContact->contact->areaOfInfluence,
            $CharacterContact->contact->levelOfInfluence * 2 - 1,
            "exploitation"
        );
        $Character->gainBadConscience(
            $this->owner->badConscience, 
            "exploitation"
        );
        $Character->save();
        
        $CharacterContact->delete();
        
        EUserFlash::setSuccessMessage(
           "You exploited " . $CharacterContact->name . " by making " . 
            _objective($CharacterContact->sex) . " praise you " . 
            $CharacterContact->contact->getAreaOfInfluenceLabel2() . ". " .
            $this->owner->byebye($CharacterContact)
        );
    }
}

?>
