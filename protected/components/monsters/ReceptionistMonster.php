<?php

/**
 * Smily flirtily or bitchily, depending on the sex of her opponent
 * 
 * @package Monsters
 */

class ReceptionistMonster extends CBehavior {

    /**
     * See above
     * @param Battle $battle
     * @return Skill
     */
    public function act($battle) {
        // 20% procrastinate (1)
        $rand = mt_rand(0,100);
        if($rand <= 20) {
            return Battleskill::model()->findByPk(1);
        } else {
            // Opponent opposite sex: Flirty smile (7)
            if($battle->combatantA->sex != $this->owner->sex) {
                return Battleskill::model()->findByPk(7);
            } 
            // Opponent same sex: Bitchy smile (8)
            else {
                return Battleskill::model()->findByPk(8);
            }
        }
    }    
}

?>
