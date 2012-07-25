<?php 
/**
 * Used by Charactermodifier
 */

if(!empty($this->Charactermodifier)) {
    echo "<p>";
    if($this->Charactermodifier->hp > 0) {
        echo $this->Charactermodifier->hp . " HP" . "<BR />";
    }
    if($this->Charactermodifier->hpPerc != 0) {
        echo "<BR />" . $this->Charactermodifier->hpPerc . "% HP" . "<BR />";
    }
    if($this->Charactermodifier->energy > 0) {
        echo $this->Charactermodifier->energy . " Energy" . "<BR />";
    }
    if($this->Charactermodifier->energyPerc != 0) {
        echo "<BR />" . $this->Charactermodifier->energyPerc . "% Energy" . "<BR />";
    }
    if($this->Charactermodifier->resoluteness > 0) {
        echo $this->Charactermodifier->resoluteness . " Resoluteness" . "<BR />";
    }
    if($this->Charactermodifier->resolutenessPerc != 0) {
        echo "<BR />" . $this->Charactermodifier->resolutenessPerc . "% more resolute" . "<BR />";
    }
    if($this->Charactermodifier->cunning > 0) {
        echo $this->Charactermodifier->cunning . " Cunning" . "<BR />";
    }
    if($this->Charactermodifier->cunningPerc != 0) {
        echo $this->Charactermodifier->cunningPerc . "% more cunning" . "<BR />";
    }
    if($this->Charactermodifier->willpower > 0) {
        echo $this->Charactermodifier->willpower. " Willpower" . "<BR />";
    }
    if($this->Charactermodifier->willpowerPerc != 0) {
        echo $this->Charactermodifier->willpowerPerc . "% more willpowery" . "<BR />";
    }
    if($this->Charactermodifier->dropItemPerc > 0) {
        echo $this->Charactermodifier->dropItemPerc. "% chance to find items" . "<BR />";
    }
    echo "</p>";
}
