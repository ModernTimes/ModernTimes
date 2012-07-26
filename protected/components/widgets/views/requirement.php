<?php 
/**
 * Used by RequirementWidget
 */

if(!empty($this->Requirement)) {
    echo "<p style='font-size: 0.8em'>";
    if($this->Requirement->class != "none") {
        echo "Only for " . $this->Requirement->class . "s<BR />";
    }
    if($this->Requirement->level > 0) {
        echo "Requires level " . $this->Requirement->level . "<BR />";
    }
    if($this->Requirement->mainstat > 0) {
        echo "Requires a mainstat of " . $this->Requirement->mainstat . "<BR />";
    }
    if($this->Requirement->resoluteness > 0) {
        echo "Requires " . $this->Requirement->resoluteness . " resoluteness<BR />";
    }
    if($this->Requirement->willpower > 0) {
        echo "Requires " . $this->Requirement->willpower. " willpower<BR />";
    }
    if($this->Requirement->cunning > 0) {
        echo "Requires " . $this->Requirement->cunning . " cunning<BR />";
    }
    echo "</p>";
}
