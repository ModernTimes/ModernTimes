<?php

/**
 * Tutorial quest
 * 
 * Upon completion, the Character gets their initial items and skills.
 * 
 * This Quest is automatically added for new players with state = ongoing.
 * 
 * @todo Add starting items, skills, etc. of new classes or make a new file for
 * every class
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterQuests
 * @package Quests
 */

class TutorialQuest extends CBehavior {

    /**
     * Set the initial parameters for the Quest.
     * In this case: flags for each step
     */
    public function setInitialParams() {
            $this->owner->params['currentStep'] = 'overview';
            $this->owner->params['inventory'] = 0;
            $this->owner->params['prepInventory'] = 0;
            $this->owner->params['skills'] = 0;
            $this->owner->params['prepSkills'] = 0;
            $this->owner->saveParams();
    }
    
    /**
     * Returns a string representation of what is going on right now with
     * regard to this Quest
     * @return string
     */
    public function getDescStatus() {
        switch($this->owner->params['currentStep']) {
            case "inventory":
                return "<BR />You remember having some things in your closet. Click on 'Stuff' in the navigation bar to have a closer look. You should probably put on some of the things you find there. Unless you want to paint the town nakedly.";
                break;
            case "skills":
                return "<BR />You do have some talents, now that you think about it. Click on 'Skills' in the navigation bar, then click on your talent to see what happens.";
                break;
            default:
                return "";
                break;
        }
    }
    
    /**
     * Set the current step to $step
     * @param string $step enum(inventory|skills|etc)
     */
    public function startStep($step) {
        $this->owner->params['currentStep'] = $step;
    }
    /**
     * Sets params[step] = 1 and currentStep back to 'overview'
     * @param string $step enum(inventory|skills|etc)
     * @return bool true if step wasn't completed before, false otherwise
     */
    public function completeStep($step) {
        $stepBefore = $this->owner->params[$step];
        $this->owner->params[$step] = 1;
        $this->owner->params['currentStep'] = 'overview';
        return (!$stepBefore);
    }
    
    
    /**
     * Prepares the inventory step, if it has not been prepared before
     * Gives out initial items.
     * Does NOT call CharacterQuest->quest->saveParams !!
     */
    public function prepareStepInventory() {
        if(!$this->owner->CharacterQuest->quest->params["prepInventory"]) {
            $Item1 = Item::model()->findByPk(1);
            $Item2 = Item::model()->findByPk(2);
            $Item3 = Item::model()->findByPk(3);
            $this->owner->Character->gainItem($Item1, 1, "quest");
            $this->owner->Character->gainItem($Item2, 1, "quest");
            $this->owner->Character->gainItem($Item3, 1, "quest");
            $this->owner->CharacterQuest->quest->params["prepInventory"] = 1;
        }
    }
    
    /**
     * Prepares the skills step, if it hasn't been prepared before
     * Gives out initial skill
     * Does NOT call CharacterQuest->quest->saveParams !!
     */
    public function prepareStepSkills() {
        if(!$this->owner->CharacterQuest->quest->params["prepSkills"]) {
            $StartCharacterSkill = $this->owner->Character->getCharacterSkill(1);
            $StartCharacterSkill->available = 1;
            $StartCharacterSkill->save();
            $this->owner->CharacterQuest->quest->params["prepSkills"] = 1;
        }
    }
    
    /**
     * Attaches custom event handlers to a Character
     * @param Character $Character 
     */
    public function attachToCharacter($Character) {
        $Character->onEquipItem = array($this, 'reactToOnEquipItem');
        $Character->onUseSkill = array($this, 'reactToOnUseSkill');
    }
    
    /**
     * Detaches custom event handlers from a Character
     * @param Character $Character 
     */
    public function detachFromCharacter($Character) {
        $Character->detachEventHandler("onEquipItem", array($this, 'reactToOnEquipItem'));
        $Character->detachEventHandler("onUseSkill", array($this, 'reactToOnUseSkill'));
    }
    
    /**
     * Checks whether the character equipped one of the starting items
     * @uses Quest->saveParams
     * @param EquipItemEvent $event 
     */
    public function reactToOnEquipItem($event) {
        if(!$this->owner->params['inventory']) {
            $Item = $event->getItem();
            $startingItems = array(1,2,3);
            if(in_array($Item->id, $startingItems)) {
                if($this->completeStep("inventory")) {
                    EUserFlash::setSuccessMessage("Congratulations! You found your things.");
                    $this->owner->saveParams();
                }
            }
        }
    }
    
    /**
     * Checks whether the character used their basic non-combat skill
     * @uses Quest->saveParams
     * @param UseSkillEvent $event 
     */
    public function reactToOnUseSkill($event) {
        if(!$this->owner->params['skills']) {
            $Skill = $event->getSkill();
            $startingSkills = array(1);
            if(in_array($Skill->id, $startingSkills)) {
                if($this->completeStep("skills")) {
                    EUserFlash::setSuccessMessage("Yeah, that's it. Did you notice that '" . $Skill->name . "' gave you an effect that makes you more powerful? Effects are displayed under your character's profile on the left. The little number next to the effect's name indicates how many turns the effect will last.  You can move your mouse over the effect's name to get further information.");
                    $this->owner->saveParams();
                }
            }
        }
    }
    
    /**
     * Gives out all the rewards that the player hasn't collected yet
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnCompleted($event) {
        // Check which steps are still incomplete
        
        // Reset params and update CharacterQuest record
        $this->owner->reactToOnCompleted($event);
    }
    
}