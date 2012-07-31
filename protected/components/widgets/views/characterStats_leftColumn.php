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

    <div class="progress progress-info" title="Level progress" align="left" style="height: 12px; margin-top: 5px">
        <div class="bar" style="width: <?php echo floor($this->character->getLevelProgress() * 100); ?>%"></div>
    </div>
    
    <div align="center" style="margin-top: 15px">
        <span class="btn btn-large" title="Turns"><i class="icon-time"></i> <b><?php echo $this->character->turns; ?></b></span>
    </div>



    <?php 
    /**
     * HP + Energy bars
     */ 
    ?>
    <div class="row" style="margin-left: 5px; margin-top: 20px;" title="Health: <?php echo $this->character->hp . " / " . $this->character->getHpMax(); ?>">
        <div class="span4">
            <div class='btn btn-mini'><i class="icon-heart"></i> <?php echo $this->character->hp; ?></div>
        </div>
        <div class="span8">
            <div style="height: 5px;"></div>
            <div class="progress progress-danger" style="height: 11px;"><div class="bar" style="width: <?php echo floor($this->character->hp / $this->character->getHpMax() * 100); ?>%"></div></div>
        </div>
    </div>
    <div class="row" style="margin-left: 5px; position: relative; top: -10px" title="Energy: <?php echo $this->character->energy . " / " . $this->character->getEnergyMax(); ?>">
        <div class="span4">
            <div class='btn btn-mini'><i class="icon-star"></i> <?php echo $this->character->energy; ?></div>
        </div>
        <div class="span8">
            <div style="height: 5px;"></div>
            <div class="progress" style="height: 11px;"><div class="bar" style="width: <?php echo floor($this->character->energy / $this->character->getEnergyMax() * 100); ?>%"></div></div>
        </div>
    </div>
    
    <?php
    /**
     * Cash, favours, kudos 
     */
    ?>
    <table cellspacing="3" style="margin: 0px 0px 4px 10px;">
        <tr>
            <td width="50"><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/cash.png" width="24" height="24" style="vertical-align: middle" title="Cash"></td>
            <td style="font-size: 11pt"><span title="Cash"><?php echo number_format($this->character->cash); ?></span></td>
        </tr><tr>
            <td><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/favours.png" width="24" height="24" style="vertical-align: middle" title="Favours"></td>
            <td style="font-size: 11pt"><span title="Favours"><?php echo number_format($this->character->favours); ?></span></td>
        </tr><tr>
            <td><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/kudos.png" width="24" height="24" style="vertical-align: middle" title="Kudos"></td>
            <td style="font-size: 11pt"><span title="Kudos"><?php echo number_format($this->character->kudos); ?></span></td>
        </tr>
    </table>
    
<?php /*

* Active familiar

*/ ?>
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
    <BR />
    <?php foreach ($this->character->characterEffects as $characterEffect) {
        // d($characterEffect);
        $this->widget("EffectWidget", 
                array("effect" => $characterEffect->effect,
                      "turns" => $characterEffect->turns,
                      "styles" => "margin-bottom: 3px;"));
    } ?>
<?php } ?>

</div>