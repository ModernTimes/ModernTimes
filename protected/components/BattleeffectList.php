<?php

class BattleeffectList extends CTypedList {
    public function __construct () {
        parent::__construct("Battleeffect");
    }

    public function contains($item, $sameHero = true) {
        return $this->indexOf($item, $sameHero)>=0;
    }
    public function remove($item, $sameHero = true) {
        if(($index=$this->indexOf($item, $sameHero))>=0)
        {
            $this->removeAt($index);
            return $index;
        }
        else
            return false;        
    }
    
    /*
    public function indexOf($item) {
        if(($index=array_search($item,$this->_d,true))!==false)
            return $index;
        else
            return -1;
    } */
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