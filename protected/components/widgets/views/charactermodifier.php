<?php 
/**
 * Used by CharactermodifierWidget
 */

if(!empty($this->Charactermodifier)) {
    echo "<p>";
    if($this->Charactermodifier->hp != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->hp) .
             $this->Charactermodifier->hp . " HP" . "</span><BR />";
    }
    if($this->Charactermodifier->hpPerc != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->hpPerc) .
             $this->Charactermodifier->hpPerc . "% HP" . "</span><BR />";
    }
    if($this->Charactermodifier->energy != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->energy) .
             $this->Charactermodifier->energy . " Energy" . "</span><BR />";
    }
    if($this->Charactermodifier->energyPerc != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->energyPerc) .
             $this->Charactermodifier->energyPerc . "% Energy" . "</span><BR />";
    }
    if($this->Charactermodifier->resoluteness != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->resoluteness) .
             $this->Charactermodifier->resoluteness . " Resoluteness" . "</span><BR />";
    }
    if($this->Charactermodifier->resolutenessPerc != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->resolutenessPerc) .
             $this->Charactermodifier->resolutenessPerc . "% Resoluteness" . "</span><BR />";
    }
    if($this->Charactermodifier->cunning != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->cunning) .
             $this->Charactermodifier->cunning . " Cunning" . "</span><BR />";
    }
    if($this->Charactermodifier->cunningPerc != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->cunningPerc) .
             $this->Charactermodifier->cunningPerc . "% Cunning" . "</span><BR />";
    }
    if($this->Charactermodifier->willpower != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->willpower) .
             $this->Charactermodifier->willpower. " Willpower" . "</span><BR />";
    }
    if($this->Charactermodifier->willpowerPerc != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->willpowerPerc) .
             $this->Charactermodifier->willpowerPerc . "% Willpower" . "</span><BR />";
    }
    if($this->Charactermodifier->dropItemPerc != 0) {
        echo $this->getColorPrefix($this->Charactermodifier->dropItemPerc) .
             $this->Charactermodifier->dropItemPerc. "% chance to find items" . "</span><BR />";
    }
    echo "</p>";
}
