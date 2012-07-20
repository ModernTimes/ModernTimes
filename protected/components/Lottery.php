<?php

/**
 * Determines a winner object based on the number of lots that each
 * participating object has been assigned during registration.
 * Main usage: decide which encounter to use in an area which has several 
 * possible encounters (same for other models with HAS_MANY relationships with 
 * a prob attribute)
 * 
 * @todo extends CAttributeList in order to inherit getRidOf-functions
 * 
 * @package System.Tools
 */

class Lottery extends CComponent {


    /**
     * list of participants in the lottery. Participants are
     *   array('participant' => $obj,
     *         'lots' => (float) $lots),
     * @var array
     */
    public $participants = array();
    
    /**
     * total lots in the pool
     * Lots can come in decimals as well, like 0.02
     * @var float
     */
    public $lotsTotal = 0;
    
    /**
     * Useful wrapper for addParticipant in case the participants are
     * represented by certain ActiveRelation objects
     * @param array $ARs array of ActiveRelation objects
     * The AR objects have to represent HAS-MANY-relationships, and they must
     * have an attribute representing the number of lots that each element gets
     * in the lottery.
     * @see AreaEncounters
     * @see MonsterItems
     * @param string $lotColumn the column name of the AR objects that holds
     * the number of lots that each object is to receive in the lottery
     */
    public function addParticipants($ARs, $lotColumn = 'prob') {
        foreach($ARs as $AR) {
            $this->addParticipant($AR, $AR->{$lotColumn});
        }
    }
    
    /**
     * Adds a new participant to the lottery, with a given number of lots
     * @param mixed $obj can be anything
     * @param float $lots number of lots that the registered object has in
     * the lottery
     * @return void
     */
    public function addParticipant($obj, $lots = 1) {
        $this->participants[] = array(
            'participant' => $obj,
            'lots' => (float) $lots,
        );
        $this->lotsTotal += (float) $lots;
    }
    
    /**
     * Determines the winner of the lottery based on the number of lots that
     * each participant has. Lots and their owner objects are all lined up, then
     * the RNG determines the position of the winning lot.
     * @return mixed whatever variable was registered as a participant
     */
    public function getWinner() {
        if($this->lotsTotal == 0) { return false; }

        // * 1,000,000, to make sure that lots in decimal form are handled right
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