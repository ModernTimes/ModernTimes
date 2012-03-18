<div class="hero-unit" style="padding-top: 0px;">
    <h1 align="center" style="margin-bottom: 30px">Megacity</h1>
    
    <?php /* http://maps.googleapis.com/maps/api/staticmap?
     * center=51.505751,-0.127029&zoom=13&size=650x500&&maptype=terrain&sensor=false
     * &style=feature:road|element:labels|visibility:off
     * &style=feature:all|element:all|hue:0x888888 */ 
    
    /* Police: http://maps.google.com/maps?q=182+Bishopsgate,+London,+United+Kingdom&hl=en&ll=51.51782,-0.080153&spn=0.00216,0.004544&sll=51.517576,-0.079786&layer=c&cbp=13,136.58,,1,0.43&cbll=51.51782,-0.080153&hnear=City+Of+London+Police,+182+Bishopsgate,+London+EC2M+4NP,+United+Kingdom&t=h&z=18&panoid=BFxGWr8sG-WwWkuKJ7CKbQ */
    ?>
    
    <div style="padding: 0px; width: 600px; height: 500px; background-image: url(<?php echo Yii::app()->getBaseUrl(); ?>/images/areas/megacity.png)">
        <div style="position: relative; top: 80px; left: 300px;">
            <div class="btn-group"><span class="btn"><i class='icon-road'></i>&nbsp;</span>
            <?php echo CHtml::link("Commercial area", array('game/go', 'region' => "commercial"), array('class'=>'btn btn-success')); ?></div>
        </div>

        <div style="position: relative; top: 330px; left: 25px">
            <div class="btn-group"><span class="btn"><i class='icon-road'></i>&nbsp;</span>
            <?php echo CHtml::link("Your home", array('game/go', 'region' => "home"), array('class'=>'btn btn-success')); ?></div>
        </div>
    </div>
    

    <!-- <hr>
    <p>
        <div class="btn-group"><span class="btn"><i class='icon-road'></i>&nbsp;</span>
        <?php echo CHtml::link("Back to world view", array('game/go', 'region' => "world"), array('class'=>'btn btn-success')); ?></div>
    </p>  -->
    
</div>