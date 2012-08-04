<?php
if(!empty($this->CharacterQuest) &&
        $this->CharacterQuest->visible) {
    
    echo "<div class='row well' style='margin: 5px'><div class='span" . 
            ($this->CharacterQuest->state == 'available' ? '9' : '12') . "'>";
    switch($this->CharacterQuest->state) {
        case "available":
            echo "<span class='label label-warning'>Wanna do it?";
            break;
        case "ongoing":
            echo "<span class='label label-warning'>Right on it";
            break;
        case "succeeded":
            echo "<span class='label label-success'>You did it!";
            break;
        case "completed":
            echo "<span class='label label-success'>Done!";
            break;
        case "failed":
            echo "<span class='label label-important'>You sucked at this one";
            break;
        case "rejected":
            echo "<span class='label label-important'>You didn't want this";
            break;
        default:
            echo "<span class='label label-warning'>" . ucfirst($this->CharacterQuest->state);
            break;
    }
    echo "</span> ";
    
    echo "<span style='font-size: 1.2em; font-weight: bold'>" . $this->CharacterQuest->quest->name . "</span><BR />";
    echo $this->CharacterQuest->quest->call("getDesc");
    echo "</div>";
    if($this->CharacterQuest->state == 'available') {
        echo "<div class='span3' style=' text-align: center'>";
        echo CHtml::link("Accept", 
                "./acceptQuest?questID=" . $this->CharacterQuest->questID . "&redirect=consultantHQ", 
                array(
                    'class' => 'btn btn-primary',
                    'style' => 'margin: 10px 0px 5px 0px; vertical-align: bottom'
                ));
        if($this->CharacterQuest->quest->rejectable) {
            echo "<BR />";
            echo CHtml::link("Reject", 
                    "./rejectQuest?questID=" . $this->CharacterQuest->questID . "&redirect=consultantHQ", 
                    array(
                        'class' => 'btn btn-primary btn-danger btn-mini',
                        // 'style' => 'margin: 10px 10px 5px 5px; vertical-align: bottom'
                    ));
        }
        echo "</div>";
    }
    echo "</div>";
}
?>
