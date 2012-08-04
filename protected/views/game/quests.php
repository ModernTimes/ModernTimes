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
        if($CharacterQuest->visible &&
                ($CharacterQuest->state == "ongoing" ||
                 $CharacterQuest->state == "succeeded")) {
            
            echo "<p style=\"margin-bottom: 1.6em\">" . 
                $CharacterQuest->quest->call('getDesc') . 
                "</p>";
            $ongoingTodos++;
        }
    } 
    if($ongoingTodos == 0) {
        echo "<p>You have no unfinished business right now.</p>";
    }
    ?>

    <h2 align="center" style="margin-bottom: 0.4em">Past projects</h2>

    <?php foreach($CharacterQuests as $CharacterQuest) {
        if($CharacterQuest->visible && 
                ($CharacterQuest->state == "completed" ||
                 $CharacterQuest->state == "failed" ||
                 $CharacterQuest->state == "rejected")) {
            
            echo "<p style=\"margin-bottom: 1.6em\">" . 
                "<span class='label'>" . ucfirst($CharacterQuest->state) . "</span> " .
                $CharacterQuest->quest->call('getDesc') . 
                "</p>";
        }
    } ?>
    
</div>