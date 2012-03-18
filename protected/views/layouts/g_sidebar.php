<?php $this->beginContent('//layouts/game'); ?>

    <div class="row-fluid">
        <div class="span3">
        <!--Sidebar content-->

            <?php $this->widget('CharacterStatsWidget'); ?>

        </div>
        <div class="span9">
        <!--Body content-->

            <?php $this->widget('UserFlashesBasic'); ?>

            <div><?php echo $content; ?></div>
                                
            <div class="clear"></div>

            <!-- <div id="footer">
                    Modern Times. Early alpha playground
            </div> --><!-- footer -->

        </div>
    </div>
                            
<?php $this->endContent(); ?>