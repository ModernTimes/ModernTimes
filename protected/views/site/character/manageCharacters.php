<?php $this->widget('UserFlashesBasic'); ?>

<!-- <h1>Manage characters</h1><BR /> -->

<h2 align="center">You are currently playing as</h2><BR />

<center><?php foreach ($Characters as $Character) { 
    if($Character->active == 1) {
        $this->widget("CharacterProfileWidget", array(
            "character" => $Character
        ));
    } 
} ?></center>

<hr>
<p align="center"><?php echo CHtml::link("Create a new character", "createCharacter", array(
    'class' => 'btn btn-large'
)); ?></p><hr>

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