<?php

/**
 * Cash = gain cash depending on the level and area of influence
 * @package Favors 
 */

class CashFavor extends CBehavior {
    
    public function resolve($Character, $CharacterContact) {
        $Character->gainCash(
            $CharacterContact->contact->levelOfInfluence * 50,
            "exploitation"
        );
        $Character->gainBadConscience(
            $this->owner->badConscience, 
            "exploitation"
        );
        $Character->save();
        
        $CharacterContact->delete();
        
        EUserFlash::setSuccessMessage(
           "You exploited " . $CharacterContact->name . " by taking " . 
            _possessive($CharacterContact->sex) . " money. " . 
            $this->owner->byebye($CharacterContact)
        );
    }
}

?>
