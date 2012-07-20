<?php

/**
 * Demonstration class to show how items can be customized with the
 * specialnessBehavior pattern
 * 
 * $this->owner is an Item record
 * 
 * @see Item
 * @see SpecialnessBehavior
 * @package Items
 */

class TestItem extends CBehavior {

    /**
     * Attaches $this->owner's Charactermodifier record to a Character
     * @see CharacterModifierBehavior
     * @param Character $Character 
     * @return void
     */
    public function attachToCharacter($Character) {
        /**
         * First, get the Item's standard mechanics, like 
         * parent::attachToCharacter
         * You can leaves this out if you want to define the Item's
         * mechanics from scratch
         */
        $this->owner->attachToCharacter($Character);
        
        /**
         * Then, define some additional stuff that the item is supposed to do 
         */
        $Character->onCalcHp = array($this, 'reactToOnCalcHp');
    }

    /**
     * Additonal event handler. This is what makes TestItem special
     * @param CEvent $event 
     * @return void
     */
    public function reactToOnCalcHp($event) { 
        // $event->params['bonusAbs'] += 235;
    }
}