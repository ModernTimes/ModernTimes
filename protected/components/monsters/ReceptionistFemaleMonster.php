<?php

/**
 * Smily flirtily or bitchily, depending on the sex of her opponent
 * 
 * @package Monsters
 */

class ReceptionistFemaleMonster extends CBehavior {

    /**
     * See above
     * @param Battle $battle
     * @return Skill
     */
    public function act($battle) {
        // 20% procrastinate
        $rand = mt_rand(0,100);
        if($rand <= 20) {
            return Battleskill::model()->findByPk(1);
        } else {
            // Male opponent: 7 Flirty smile
            if($battle->combatantA->sex == 'male') {
                return Battleskill::model()->findByPk(7);
            } 
            // Female opponent: 8 Bitchy smile
            else {
                return Battleskill::model()->findByPk(8);
            }
        }
    }    
}

?>
