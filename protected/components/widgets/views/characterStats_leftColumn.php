<div id="characterStats">

    <table width="100%"><tr>
        <td><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/characters/consultant/male-1.png" width="64" height="64"></td>
        <td align="center">
            <h3><?php echo $this->character['name']; ?></h3>
            <p><?php echo $this->character->getTitle(); ?></p>
            <div class="progress progress-info" align="left" style="height: 12px">
                <div class="bar" style="width: <?php echo floor($this->character->getLevelProgress() * 100); ?>%"></div>
            </div>
        </td>
    </tr></table>
    
    <div align="center" style="margin-top: 30px">
        <span class="btn btn-large"><i class="icon-time"></i> <b><?php echo $this->character->actions; ?></b></span>
    </div>


    <?php /* if(!empty(Yii::app()->session['lastArea'])) { ?>
        <p align="center"><div class="btn-group"><span class="btn btn-mini"><i class='icon-time'></i> 1</span>
            <?php echo CHtml::link("" . Yii::app()->session['lastArea']['name'], array('game/doMischief', 'areaID' => Yii::app()->session['lastArea']['id']), array('class'=>'btn btn-mini btn-warning')); ?></p>
        </div></p>
    <?php } */ ?>
    
   
    <table style="margin-top: 30px"><tr><td valign="middle"><span class="btn"><nobr><i class="icon-heart"></i> <?php echo $this->character->hp; ?> / <?php echo $this->character->getHpMax(); ?></nobr></span></td>
               <td width="100%"><div class="progress progress-danger" style="margin: 0px; height: 12px"><div class="bar" style="width: <?php echo floor($this->character->hp / $this->character->getHpMax() * 100); ?>%"></div></div></td></tr>
           <tr><td valign="middle"><span class="btn"><nobr><i class="icon-star"></i> <?php echo $this->character->energy; ?> / <?php echo $this->character->getEnergyMax(); ?></nobr></span></td>
                                <td width="100%"><div class="progress" style="margin: 0px; height: 12px"><div class="bar" style="width: <?php echo floor($this->character->energy / $this->character->getEnergyMax() * 100); ?>%"></div></div></td>
           </tr></table>
    
    <div align="center" style="margin-top: 30px">
        <span class="btn"><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/cash.png" width="32" height="32" style="vertical-align: middle"> &nbsp; <?php echo number_format($this->character->cash); ?></span><BR />
        <span class="btn" style="margin-top: 10px"><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/favours.png" width="32" height="32" style="vertical-align: middle"> &nbsp; <?php echo number_format($this->character->favours); ?></span>
        <span class="btn" style="margin-top: 10px"><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/kudos.png" width="32" height="32" style="vertical-align: middle"> &nbsp; <?php echo number_format($this->character->kudos); ?></span>
    </div>
    
<?php ?>
    <?php if (is_a($this->character->getFamiliar(), "Familiar")) { ?>
        <div align=center style="margin-top: 30px">
            <b><?php echo $this->character->getFamiliar()->name . "</b><BR />Level " . $this->character->getFamiliar()->getLevel() . " Secretary"; ?>
        </div>
        <!-- <div class="progress progress-info" style="height: 10px">
            <div class="bar" style="width: <?php echo floor($this->character->getFamiliar()->getLevelProgress() * 100); ?>%"></div>
        </div> -->
    <?php } ?>
<?php ?>

<?php if(count($this->character->characterEffects) > 0) { ?>
    <BR />
    <table width="90%" style="margin-top: 30px">
        <?php foreach ($this->character->characterEffects as $characterEffect) {
             echo "<tr><td><a class='btn btn-info btn-mini' href='#' rel='popover'" . 
                              "title=\"" . CHtml::encode($characterEffect->effect->name) . "\"" . 
                              "data-content=\"" . CHtml::encode($characterEffect->effect->desc) . "\">Effect</a> &nbsp;" . 
                                $characterEffect->effect->name . "</a></td>
                        <td>" . $characterEffect->turns . "</td>
                  </tr>";
        } ?>
    </table>
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