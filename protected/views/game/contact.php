<?php 
/**
 * @uses ContactWidget
 */ 
?>
<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">

    <h1 align="center" style="margin-bottom: 0.4em"><?php echo $CharacterContact->name; ?></h1>
    <p align="center" style="font-size: 1.8em"><?php echo $CharacterContact->contact->getTitle(); ?></p>
    
</div>