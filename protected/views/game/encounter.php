<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">
    <h1 align="center" style="margin-bottom: 0.4em"><?php echo $encounter->name; ?></h1>
    
    <p><?php echo $encounter->msg; ?></p>
    
    <?php foreach($encounter->encounterEncounters as $choice) {
        echo $choice->choiceName . "<BR />";
    } ?>
    
    <?php $this->widget('UserFlashesBasic'); ?>
</div>