<?php /**
 * Displays a list of current and completed quests
 * @used by QuestsAction
 */
?>

<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">

    <h1 align="center" style="margin-bottom: 0.4em">Todo</h1>

    <?php foreach($CharacterQuests as $CharacterQuest) {
        echo "<p style=\"margin-bottom: 1.6em\">" . 
             "(" . ucfirst($CharacterQuest->state) . ") " .
             $CharacterQuest->quest->call('getDesc') . 
             "</p>";
    } ?>
    
</div>