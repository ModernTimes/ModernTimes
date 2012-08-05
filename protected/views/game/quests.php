<?php /**
 * Displays a list of current and completed quests
 * @used by QuestsAction
 */
?>

<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">

    <h1 align="center" style="margin-bottom: 0.4em">Todo</h1>

    <?php 
    $ongoingTodos = 0;
    foreach($CharacterQuests as $CharacterQuest) {
        if($CharacterQuest->isVisible() && 
                $CharacterQuest->isOngoing()) {
            
            $this->widget('QuestWidget', array(
                "CharacterQuest" => $CharacterQuest
            )); 
            $ongoingTodos++;
        }
    } 
    if($ongoingTodos == 0) {
        echo "<p>You have no unfinished business right now.</p>";
    }
    ?>
        
    <h2 align="center" style="margin: 1em 0 0.4em 0">Past projects</h2>

    <?php foreach($CharacterQuests as $CharacterQuest) {
        if($CharacterQuest->isVisible() && 
                $CharacterQuest->isFinished()) {
            
            $this->widget('QuestWidget', array(
                "CharacterQuest" => $CharacterQuest
            )); 
        }
    } ?>
    
</div>