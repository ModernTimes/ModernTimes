<?php 
/**
 * Used by CharactermodifierWidget
 */

if(!empty($this->Charactermodifier)) {
    echo "<p>";
    if($this->Charactermodifier->hp != 0) {
        echo $this->addColor($this->Charactermodifier->hp, 
             $this->Charactermodifier->hp . " HP") . "<BR />";
    }
    if($this->Charactermodifier->hpPerc != 0) {
        echo $this->addColor($this->Charactermodifier->hpPerc,
             $this->Charactermodifier->hpPerc . "% HP") . "<BR />";
    }
    if($this->Charactermodifier->energy != 0) {
        echo $this->addColor($this->Charactermodifier->energy,
             $this->Charactermodifier->energy . " Energy") . "<BR />";
    }
    if($this->Charactermodifier->energyPerc != 0) {
        echo $this->addColor($this->Charactermodifier->energyPerc,
             $this->Charactermodifier->energyPerc . "% Energy") . "<BR />";
    }
    if($this->Charactermodifier->resoluteness != 0) {
        echo $this->addColor($this->Charactermodifier->resoluteness,
             $this->Charactermodifier->resoluteness . " Resoluteness") . "<BR />";
    }
    if($this->Charactermodifier->resolutenessPerc != 0) {
        echo $this->addColor($this->Charactermodifier->resolutenessPerc,
             $this->Charactermodifier->resolutenessPerc . "% Resoluteness") . "<BR />";
    }
    if($this->Charactermodifier->cunning != 0) {
        echo $this->addColor($this->Charactermodifier->cunning,
             $this->Charactermodifier->cunning . " Cunning") . "<BR />";
    }
    if($this->Charactermodifier->cunningPerc != 0) {
        echo $this->addColor($this->Charactermodifier->cunningPerc,
             $this->Charactermodifier->cunningPerc . "% Cunning") . "<BR />";
    }
    if($this->Charactermodifier->willpower != 0) {
        echo $this->addColor($this->Charactermodifier->willpower,
             $this->Charactermodifier->willpower. " Willpower") . "<BR />";
    }
    if($this->Charactermodifier->willpowerPerc != 0) {
        echo $this->addColor($this->Charactermodifier->willpowerPerc,
             $this->Charactermodifier->willpowerPerc . "% Willpower") . "<BR />";
    }
    if($this->Charactermodifier->dropItemPerc != 0) {
        echo $this->addColor($this->Charactermodifier->dropItemPerc,
             $this->Charactermodifier->dropItemPerc. "% chance to find items") . "<BR />";
    }
    
    if($this->Charactermodifier->critChancePerc != 0) {
        echo $this->addColor($this->Charactermodifier->critChancePerc,
             $this->Charactermodifier->critChancePerc. "% critical strikes") . "<BR />";
    }

    $damageTypes = array("normal", "envy", "greed", "gluttony", "lust", "pride", "sloth", "wrath");
    foreach($damageTypes as $damageType) {
        if($this->Charactermodifier->{"damage" . ucfirst($damageType) . "Abs"} != 0) {
            echo $this->addColor($this->Charactermodifier->{"damage" . ucfirst($damageType) . "Abs"},
                $this->Charactermodifier->{"damage" . ucfirst($damageType) . "Abs"} . " " . $damageType . " damage") . "<BR />";
        }
        if($this->Charactermodifier->{"damage" . ucfirst($damageType) . "Perc"} != 0) {
            echo $this->addColor($this->Charactermodifier->{"damage" . ucfirst($damageType) . "Perc"},
                $this->Charactermodifier->{"damage" . ucfirst($damageType) . "Perc"} . "% " . $damageType . " damage") . "<BR />";
        }
    }
    
    if($this->Charactermodifier->resistanceAbs != 0) {
        echo $this->addColor($this->Charactermodifier->resistanceAbs,
             $this->Charactermodifier->resistanceAbs. " protection from any damage",
             false)
             . "<BR />";
    }
    foreach($damageTypes as $damageType) {
        if($this->Charactermodifier->{"resistanceLevel" . ucfirst($damageType)} != 0) {
            echo $this->addColor($this->Charactermodifier->{"resistanceLevel" . ucfirst($damageType)},
                    Yii::app()->tools->getResistanceLevelLabel($this->Charactermodifier->{"resistanceLevel" . ucfirst($damageType)}) . " protection from " . $damageType . " damage",
                    false)
                . "<BR />";
        }
    }
    
    echo "</p>";
}
