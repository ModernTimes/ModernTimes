<?php

/**
 * Use an active non-battle skill
 * @package Actions
 */

class UseSkillAction extends BattleAction {

    /**
     * See above
     * @param string $skillID int, only string because of $GET
     */
    public function run($skillID = "") {
        // positive integer
        $validSyntax = (!empty($skillID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($skillID)
                        && $skillID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            $Character = CD();
            $CharacterSkill = $Character->getCharacterSkill($skillID);
            if(!$CharacterSkill->available) {
                EUserFlash::setErrorMessage("You haven't mastered that skill. Nice try, though.");
            } else {
                $CharacterSkill->skill->resolveUsage($Character);
            }
        }
        
        $this->controller->redirect("index");
    }
 }