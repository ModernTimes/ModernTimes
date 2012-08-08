<?php

/**
 * Cash = gain cash depending on the level and area of influence
 * @package Favors 
 */

class CashFavor extends CBehavior {
    
    /**
     * Array with cash gain factors for different areas of influence
     * @var array
     */
    private $_areaCashGainFactors = array(
        'finance' => 3,
        'realEconomy' => 1.5,
        'police' => 0.5,
    );
    
    /**
     * See above
     * @param Character $Character
     * @param CharacterContacts $CharacterContact 
     * @return bool success
     */
    public function resolve($Character, $CharacterContact) {
        $Character->gainCash(
            $CharacterContact->contact->levelOfInfluence * 25
                * pow(2, $CharacterContact->contact->levelOfInfluence)
                * (isset($this->_areaCashGainFactors[$CharacterContact->contact->areaOfInfluence]) 
                        ? $this->_areaCashGainFactors[$CharacterContact->contact->areaOfInfluence] 
                        : 1),
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
            _possessive($CharacterContact->sex) . " money. "
        );
        $CharacterContact->byebye();
        
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
