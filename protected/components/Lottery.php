<?php

/*
 *  Determines a winner object based on the number of lots that each
 *  participating object has.
 *  Could be extended to do more lottery related stuff later on
 *  ToDo: extend from CAttributeList (or whatever), to use getRidOf-functions etc
 */

class Lottery extends CComponent {

    // public $type;
    
    public $participants = array();
    
    // Lots can come in percentages as well, like 0.02
    public $lotsTotal = 0;
    
    /*
    public function __construct($type = 'weighted') {
        $this->type = $type;
    }
    */
    
    // Expects an array with entries of HAS-MANY-relationship representing ARs,
    // like MonsterSkills entries, or MonsterItems, AreaEncounters, etc.
    public function addParticipants($ARs, $lotColumn = 'prob') {
        foreach($ARs as $AR) {
            $this->addParticipant($AR, $AR->{$lotColumn});
        }
    }
    
    public function addParticipant($obj, $lots = 1) {
        $this->participants[] = array(
            'participant' => $obj,
            'lots' => (float) $lots,
        );
        $this->lotsTotal += (float) $lots;
    }
    
    // Lots are all lined up, then the RNG determines which lot, 
    // counted from the start, is going to be the winner
    public function getWinner() {
        // So that the users of this class don't have to check themselves
        if($this->lotsTotal == 0) { return false; }

        // * 1,000,000, to make sure that floating lots are handled right
        $rand = mt_rand(1, $this->lotsTotal * 1000000);
        $currentLot = 0;

        foreach($this->participants as $participant) {
            $currentLot += $participant['lots'] * 1000000;
            if($currentLot >= $rand) {
                return $participant['participant'];
            }
        }
        return false; // should never happen
    }
}