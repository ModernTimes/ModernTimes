<h1>McBooz&Bain Consulting Group</h1><BR />

<div style="width: 60%">
    <h2>Project database</h2>

    <?php 
    /* <h2>Dr. Andy Banerji</h2> */ 

    if(count($currentCharacterQuests) > 0) {
        foreach($currentCharacterQuests as $CharacterQuest) {
            $this->widget('QuestWidget', array(
                "CharacterQuest" => $CharacterQuest
            )); 
        }
    } else {
        echo "<p>There are no projects going on right now.</p>";
    }
    ?>
</div>