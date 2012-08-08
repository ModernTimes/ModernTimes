<?php /*
 * shown on the left hand side of the game window
 * @todo improve familiar section
 */ ?>
<div id="characterStats">

    <table width="100%""><tr>
        <td><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/characters/<?php echo $this->character->class; ?>/<?php echo $this->character->sex; ?>-1.png" width="64" height="64"></td>
        <td align="center">
            <h3><?php echo $this->character['name']; ?></h3>
            <p><?php echo $this->character->getTitle(); ?></p>
        </td>
    </tr></table>

    <?php /* Level progress */ ?>
    <div class="progress progress-info" title="Level progress" align="left" style="height: 12px; margin-top: 5px">
        <div class="bar" style="width: <?php echo floor($this->character->getLevelProgress() * 100); ?>%"></div>
    </div>
    
    <hr />

    <?php /* Turns + Cash */ ?>
    <div style="margin-top: 15px; margin-left: 5px"><div class="row">
        <div class="span<?php echo ($this->character->cash > 100000 ? "5" : "6"); ?>" align="center">
            <span class="btn" title="Turns"><i class="icon-time"></i> <b>1<?php echo $this->character->turns; ?></b></span>
        </div><div class="span<?php echo ($this->character->cash > 100000 ? "7" : "6"); ?>" align="center">
            <div class='btn' title="Cash" style="padding-right: 12px; padding-left: 12px"><i class="icon-cash" style="position: relative; top: 0px"></i>&nbsp;<b><?php echo number_format($this->character->cash); ?></b>
            </div>
        </div>
    </div></div>

    <hr />

    <?php 
    /**
     * Bad conscience, HP + Energy bars
     */ 
    ?>
    <div class="row" style="margin-left: 5px; margin-top: 20px; position: relative; top: 10px" title="Bad conscience">
        <div class="span4">
            <div class='btn btn-mini'>&nbsp; <i class="icon-eye-close"></i>&nbsp;</div>
        </div>
        <div class="span8">
            <div style="height: 5px;"></div>
            <div class="progress" style="height: 11px;"><div class="bar" style="width: <?php echo floor($this->character->badConscience / $this->character->getBadConscienceMax() * 100); ?>%; background: black"></div></div>
        </div>
    </div>
    <div class="row" style="margin-left: 5px;" title="Health: <?php echo $this->character->hp . " / " . $this->character->getHpMax(); ?>">
        <div class="span4">
            <div class='btn btn-mini'><i class="icon-heart"></i> <?php echo $this->character->hp; ?></div>
        </div>
        <div class="span8">
            <div style="height: 5px;"></div>
            <div class="progress progress-danger" style="height: 11px;"><div class="bar" style="width: <?php echo floor($this->character->hp / $this->character->getHpMax() * 100); ?>%"></div></div>
        </div>
    </div>
    <div class="row" style="margin-left: 5px; position: relative; top: -10px;" title="Energy: <?php echo $this->character->energy . " / " . $this->character->getEnergyMax(); ?>">
        <div class="span4">
            <div class='btn btn-mini'><i class="icon-star"></i> <?php echo $this->character->energy; ?></div>
        </div>
        <div class="span8">
            <div style="height: 5px;"></div>
            <div class="progress" style="height: 11px;"><div class="bar" style="width: <?php echo floor($this->character->energy / $this->character->getEnergyMax() * 100); ?>%"></div></div>
        </div>
    </div>

    <hr style="position: relative; top: -10px" />
    
    
    <?php 
    /**
    * Active familiar
    */ 
    ?>
    <?php if (is_a($this->character->getFamiliar(), "Familiar")) { ?>
        <div align=center style="margin-top: 30px">
            <b><?php echo $this->character->getFamiliar()->name . "</b><BR />Level " . $this->character->getFamiliar()->getLevel() . " Secretary"; ?>
        </div>
        <!-- <div class="progress progress-info" style="height: 10px">
            <div class="bar" style="width: <?php echo floor($this->character->getFamiliar()->getLevelProgress() * 100); ?>%"></div>
        </div> -->
    <?php } ?>
<?php ?>

<?php // Active effects
if(count($this->character->characterEffects) > 0) { ?>
    <?php foreach ($this->character->characterEffects as $characterEffect) {
        // d($characterEffect);
        $this->widget("EffectWidget", 
                array("effect" => $characterEffect->effect,
                      "turns" => $characterEffect->turns,
                      "styles" => "margin-bottom: 3px;"));
    } ?>
<?php } ?>

</div>