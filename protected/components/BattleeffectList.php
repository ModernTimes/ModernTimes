<?php

/**
 * A CTypedList to manage active Battleeffects
 */

class BattleeffectList extends CTypedList {
    public function __construct () {
        parent::__construct("Battleeffect");
    }

    /**
     * Checks if the list contains an item (a Battleeffect).
     * @param Battleeffect $item, needle
     * @param bool $sameHero, if true: Battleeffect's hero has to be item's 
     *                                 hero.
     *                        if false: Checks if the list contains the item, 
     *                                  no matter which combattant the item is 
     *                                  attached to
     */                       
    public function contains($item, $sameHero = true) {
        return $this->indexOf($item, $sameHero) >= 0;
    }

    /** 
     * Removes a specific item (a Battleeffect) from the list. 
     * @param Battleeffect $item, the item to be removed
     * @param bool $sameHero, if true: hero of the Battleeffect to be
     *                                 removed has to be == item's hero.
     *                        if false: removes the first Battleeffect of the 
     *                                  given type from the list, no matter to 
     *                                  which combattant it is attached
     */                       
    public function remove($item, $sameHero = true) {
        if(($index = $this->indexOf($item, $sameHero)) >= 0) {
            $this->removeAt($index);
            return $index;
        }
        else
            return false;        
    }
    
    /**
     * returns the first position of a given item (a Battleeffect) in the list. 
     * @param Battleeffect $item, the needle
     * @param bool $sameHero, if true: hero of Battleeffect to be removed
     *                                 has to be == item's hero
     *                        if false: returns the first position of $item
     *                                  no matter which combattant it is 
     *                                  attached to
     */
    /*
    public function indexOf($item) {
        if(($index=array_search($item,$this->_d,true))!==false)
            return $index;
        else
            return -1;
    }
    */
    public function indexOf($item, $sameHero = true) {
        for($i = 0; $i < $this->getCount(); $i++) {
            if($this->itemAt($i)->id == $item->id) {
                if($sameHero) {
                    if ($this->itemAt($i)->heroString == $item->heroString) {
                        return $i;
                    }
                } else {
                    return $i;
                }
            }
        }
        return -1;
    }
}