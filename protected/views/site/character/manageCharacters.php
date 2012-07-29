<?php $this->widget('UserFlashesBasic'); ?>

<h1>Manage characters</h1><BR />

<h2>You are currently playing as</h2><BR />

<?php foreach ($Characters as $Character) { 
    if($Character->active == 1) {
        $this->widget("CharacterProfileWidget", array(
            "character" => $Character
        ));
    } 
} ?>

<?php if(count($Characters) > 1) { ?>
    <h2>Your neglected sweetlings</h2><BR />

    <?php foreach ($Characters as $Character) { 
        if($Character->active == 0) {
            $this->widget("CharacterProfileWidget", array(
                "character" => $Character
            ));
        } 
    } 
} ?>