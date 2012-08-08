<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">
    
<h1>Home, sweet home</h1><BR />

<?php 
if(!empty($tutorialQuestDisplay)) {
    echo $tutorialQuestDisplay;
} else {

    echo "<h2>Personal todos</h2>";

    if(count($currentCharacterQuests) > 0) {
        foreach($currentCharacterQuests as $CharacterQuest) {
            $this->widget('QuestWidget', array(
                "CharacterQuest" => $CharacterQuest
            )); 
        }
    } else {
        echo "<p>You don't have any personal projects right now.</p>";
    }

    echo "<a href='" . CHtml::normalizeUrl(array('rest')) . "' class='nounderline'><div class='btn-group'>
            <button class='btn btn-large'><i class='icon-time'></i>&nbsp;</button>
            <button class='btn btn-large btn-success'>Rest</button>
        </div></a>";
}
?>

</div>