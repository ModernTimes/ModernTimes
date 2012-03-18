<div class="hero-unit" style="padding-top: 0px;">
    <h1 align="center" style="margin-bottom: 30px">Commercial area</h1>

    <p>
        <div class="btn-group"><span class="btn"><i class='icon-time'></i> 1</span>
        <?php echo CHtml::link("Kunde I", array('/game/doMischief', 'areaID' => 1), array('class'=>'btn btn-warning')); ?></div>
    </p>
    
    <p>
        <div class="btn-group"><span class="btn"><i class='icon-road'></i>&nbsp;</span>
        <?php echo CHtml::link("McBain & Booze Consulting Group", array('game/go', 'region' => "mbbcg"), array('class'=>'btn btn-success')); ?></div>
    </p>

    <hr>
    <p>
        <div class="btn-group"><span class="btn"><i class='icon-road'></i>&nbsp;</span>
        <?php echo CHtml::link("Back to Megacity", array('game/go', 'region' => "megacity"), array('class'=>'btn btn-success')); ?></div>
    </p>

</div>