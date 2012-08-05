<h1>Home, sweet home</h1><BR />

<?php 
    if(!empty($tutorialQuestDisplay)) {
        echo $tutorialQuestDisplay;
    }
?>

<h2>Personal todos</h2>

<?php
$wokenUp = false;
if(count($currentCharacterQuests) > 0) {
    foreach($currentCharacterQuests as $CharacterQuest) {
        if($CharacterQuest->questID == 1 && 
                $CharacterQuest->state == "completed") {
            $wokenUp = true;
        }
        $this->widget('QuestWidget', array(
            "CharacterQuest" => $CharacterQuest
        )); 
    }
} else {
    echo "<p>You don't have any personal projects right now.</p>";
}

if($wokenUp) {
    echo "<div class='btn-group'>
            <button class='btn btn-large'><i class='icon-time'></i>&nbsp;</button>
            <button class='btn btn-large btn-success'>Rest</button>
        </div>";
}
?>