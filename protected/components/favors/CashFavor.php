<?php

/**
 * Cash = gain cash depending on the level and area of influence
 * @package Favors 
 */

class CashFavor extends CBehavior {
    
    /**
     * See above
     * @param Character $Character
     * @param CharacterContacts $CharacterContact 
     * @return bool success
     */
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
        
        return true;
    }
    
    /**
     * Returns the amount of badConscience that this favor will cause
     * @param CharacterContact $CharacterContact
     * @return int
     */
    public function getBadConscience($CharacterContact) {
        return $CharacterContact->contact->levelOfInfluence;
    }
}

?>
