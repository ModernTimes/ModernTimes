<?php /*
 * shown on the left hand side of the game window
 * ToDo: insert character profile picture dynamically
 * ToDo: improve familiar section
 */ ?>
<div id="characterStats">

    <table width="100%""><tr>
        <td><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/characters/consultant/<?php echo $this->character->sex; ?>-1.png" width="64" height="64"></td>
        <td align="center">
            <h3><?php echo $this->character['name']; ?></h3>
            <p><?php echo $this->character->getTitle(); ?></p>
        </td>
    </tr></table>

    <div class="progress progress-info" align="left" style="height: 12px; margin-top: 5px">
        <div class="bar" style="width: <?php echo floor($this->character->getLevelProgress() * 100); ?>%"></div>
    </div>
    
    <div align="center" style="margin-top: 15px">
        <span class="btn btn-large"><i class="icon-time"></i> <b><?php echo $this->character->turns; ?></b></span>
    </div>


    <?php /* if(!empty(Yii::app()->session['lastArea'])) { ?>
        <p align="center"><div class="btn-group"><span class="btn btn-mini"><i class='icon-time'></i> 1</span>
            <?php echo CHtml::link("" . Yii::app()->session['lastArea']['name'], array('game/doMischief', 'areaID' => Yii::app()->session['lastArea']['id']), array('class'=>'btn btn-mini btn-warning')); ?></p>
        </div></p>
    <?php } */ ?>
    
   
<?php /*
<?php echo $this->character->hp; ?> / <?php echo $this->character->getHpMax(); ?>
<?php echo $this->character->energy; ?> / <?php echo $this->character->getEnergyMax(); ?>
 */ ?>
    

    <div align=""center"><table style="margin-top: 30px;" cellspacing="3">
        <?php /*
        
         * HP + Energy bars
        
        */ ?><tr>
            <td style="width: 40px;"><i class="icon-heart"></i></td>
            <td style="width: 80%"><div class="progress progress-danger" style="margin: 0px; height: 12px"><div class="bar" style="width: <?php echo floor($this->character->hp / $this->character->getHpMax() * 100); ?>%"></div></div></td>
        </tr><tr>
            <td><i class="icon-star"></i></td>
            <td><div class="progress" style="margin: 0px; height: 12px"><div class="bar" style="width: <?php echo floor($this->character->energy / $this->character->getEnergyMax() * 100); ?>%"></div></div></td>
        </tr><?php /*
        
         * Cash, favours, kudos
        
        */ ?><tr><td colspan="2" style="height: 20px"></td></tr><tr>
            <td><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/cash.png" width="24" height="24" style="vertical-align: middle" title="Cash"></td>
            <td style="font-size: 11pt"><?php echo number_format($this->character->cash); ?></td>
        </tr><tr>
            <td><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/favours.png" width="24" height="24" style="vertical-align: middle" title="Favours"></td>
            <td style="font-size: 11pt"><?php echo number_format($this->character->favours); ?></td>
        </tr><tr>
            <td><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/kudos.png" width="24" height="24" style="vertical-align: middle" title="Kudos"></td>
            <td style="font-size: 11pt"><?php echo number_format($this->character->kudos); ?></td>
        </tr>
    </table></div>
    
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
                      "turns" => $characterEffect->turns));
    } ?>
<?php } ?>

<?php /* ?>
    <div align="center">Skills:</div>
    <ul>
        <?php foreach($this->character->characterSkills as $characterSkill) {
            echo "<li>" . $characterSkill->skill->name . " (ID: " . $characterSkill->skill->id . ")</li>";
        } ?>
    </ul>
 <?php */ ?>

</div>