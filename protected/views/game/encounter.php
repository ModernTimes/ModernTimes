<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">
    <h1><?php echo $encounter->name; ?></h1>
    
    <div>
        <?php echo $encounter->msg; ?>
    </div>
    
    <?php foreach($encounter->encounterEncounters as $choice) {
        echo $choice->choiceName . "<BR />";
    } ?>
    
    <?php $this->widget('UserFlashesBasic'); ?>
</div>