<?php $this->beginContent('//layouts/game'); ?>

    <div class="row-fluid">
        <div class="span2">
        <!--Sidebar content-->

            <?php $this->widget('CharacterStatsWidget'); ?>

        </div>
        <div class="span10">
        <!--Body content-->

            <div><?php echo $content; ?></div>
                                
            <div class="clear"></div>

            <!-- <div id="footer">
                    Modern Times. Early alpha playground
            </div> --><!-- footer -->

        </div>
    </div>
                            
<?php $this->endContent(); ?>