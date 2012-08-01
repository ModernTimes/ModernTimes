<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">

<?php /* d($battle); */ ?>    
    
<?php // entering battle message
if($battle->type == 'monster' && $battle->round == 0) { ?>
    <h1 align="center" style="margin-bottom: 15px">Battle</h1>
    <?php $monsterMsgs = $battle->getLogs('last');
    echo "<div align=center><p align='center' style='width: 70%; margin-bottom: 40px'>" . $monsterMsgs[0]->msg . "</p></div>";
} ?>
    
<?php // Battle result
if($battle->state == "resolved") { ?>
    <h1 align="center" style="margin-bottom: 30px">
        <?php if($battle->winnerType == "draw") { ?>
            It's a DRAW
        <?php } else { ?>
                <?php echo ucfirst($battle->getWinner()->name); ?> wins!
        <?php } ?>
    </h1>
<?php } ?>

    
            <?php $this->widget('UserFlashesBasic'); ?>

    
<?php // Options to continue after the battle is over
if($battle->state == "resolved") { ?>
    <center><table style="width: 66%"><tr><td width="50%" align="center">
    <?php if(!empty(Yii::app()->session['lastArea']) && $battle->isUserWinner()) { ?>
        <div class="btn-group"><span class="btn">1 <i class='icon-time'></i></span>
            <?php echo CHtml::link("Do more mischief at " . Yii::app()->session['lastArea']['name'], array('game/mischief', 'areaID' => Yii::app()->session['lastArea']['id']), array('class'=>'btn btn-warning')); ?>
        </div>
    <?php } ?>
    </td><td width="50%" align="center">

    <div class="btn-group"><!--<span class="btn"><i class='icon-road'></i>&nbsp;</span>-->
        <?php echo CHtml::link("Back to London", array('game/map'), array('class'=>'btn btn-success')); ?>
    </div>
    </td></tr></table></center>
    
    <hr style="margin-bottom: 30px; margin-top: 45px; border-style: dashed; border-width: 1px; border-color: black">
<?php } ?>


    
    <center><table style="width: 100%">
        <!-- PROFILES OF THE COMBATANTS -->
        <tr>
            <td width="45%" style="padding-right: 10px;"><table width="100%">
                    <tr>
                        <td width="15"><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/characters/consultant/<?php echo $battle->combatantA->sex; ?>-1.png" width="64" height="64"></td>
                        <td width="45%" style="padding-right: 10px;">
                            <h2 align="center"><?php echo $battle->combatantA->name; ?></h2>
                            <p align="center"><?php echo $battle->combatantA->getTitle(); ?></p>
                        </td>
                        <td width="40%" valign="top">
                            <table width="100%"><tr><td valign="middle"><span class="btn"><nobr><i class="icon-heart"></i> <?php echo $battle->combatantA->hp; ?></nobr></span></td>
                                <td width="100%"><div class="progress progress-danger" style="margin: 0px; height: 17px"><div class="bar" style="width: <?php echo floor($battle->combatantA->hp / $battle->combatantA->getHpMax() * 100); ?>%"></div></div></td></tr>
                             <tr><td valign="middle"><span class="btn"><nobr><i class="icon-star"></i> <?php echo $battle->combatantA->energy; ?></nobr></span></td>
                                <td width="100%"><div class="progress" style="margin: 0px; height: 17px"><div class="bar" style="width: <?php echo floor($battle->combatantA->energy / $battle->combatantA->getEnergyMax() * 100); ?>%"></div></div></td></tr></table>
                        </td>
                    </tr>
                </table>
            </td>
            <td><h1 align="center">vs</h1></td>

            <?php 
                $avatar = $battle->type == "monster" && file_exists(Yii::app()->getBasePath() . "/../images/monsters/" . $battle->combatantB->id . ".png");
            ?>
            <td width="45%" style="padding-left: 10px"><table width="100%">
                    <tr>
                        <td width="<?php echo ($avatar ? "35" : "45"); ?>%" valign="top">
                            <table width="100%"><tr><td width="100%"><div class="progress progress-danger" style="margin: 0px; height: 17px" align="right"><div class="bar" style="width: <?php echo floor($battle->combatantB->hp / $battle->combatantB->getHpMax() * 100); ?>%"></div></div></td>
                                <td valign="middle"><span class="btn"><nobr><i class="icon-heart"></i> <?php echo $battle->combatantB->hp; ?></nobr></span></td></tr>
                            <?php if($battle->type == 'pvp') { ?>
                              <tr><td width="100%"><div class="progress" style="margin: 0px; height: 17px" align="right"><div class="bar" style="width: <?php echo floor($battle->combatantB->energy / $battle->combatantB->getEnergyMax() * 100); ?>%"></div></div></td>
                              <td valign="middle"><span class="btn"><nobr><i class="icon-star"></i> <?php echo $battle->combatantB->energy; ?></nobr></span></td></tr>
                            <?php } ?>
                            </table>
                        </td>
                        <td width="<?php echo ($avatar ? "50" : "55"); ?>%" style="padding-left: 10px;">
                            <h<?php echo (strlen($battle->combatantB->name) > 25 ? "3" : "2"); ?> align="center"><?php echo ($battle->type == 'monster' ? ucfirst($battle->combatantB->name) : $battle->combatantB->name); ?></h<?php echo (strlen($battle->combatantB->name) > 25 ? "3" : "2"); ?>>
                            <?php if($battle->type == 'pvp') { ?>
                                <p align="center"><?php echo $battle->combatantB->getTitle(); ?></p>
                            <?php } ?>
                        </td>
                        <?php if($avatar) { ?>
                            <td width="15%"><img src="<? echo Yii::app()->getBaseUrl(); ?>/images/monsters/<?php echo $battle->combatantB->id; ?>.png" width="64" height="64"></td>
                        <?php } ?>
                    </tr>
                </table>
            </td>
        </tr>
        </table>

        
        <table width="100%">
        <!-- EFFECTS -->
        <?php if ($battle->combatantHasEffects("combatantA") ||
                  $battle->combatantHasEffects("combatantB")) { ?>
        <!-- <tr><td colspan="2"><h2 align="center">Effects</h2></td></tr> -->
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td align="center" style="width: 50%; padding-right: 20px;">
                <?php if($battle->combatantHasEffects("combatantA")) { ?>
                    <?php foreach($battle->battleeffects as $battleeffect) {
                        if ($battleeffect->heroString == "combatantA") { 
                            echo CHtml::link($battleeffect->name, "#", array('class'=>'btn btn-mini ' . ($battleeffect->buff ? 'btn-success' : 'btn-danger'), 'data-title'=>$battleeffect->name, 'data-content'=>$battleeffect->call("getPopup"), 'rel'=>'popover'));
                            echo " &nbsp; ";
                        }
                    } ?>
                <?php } ?>
            </td>
            
            <td align="center" style="width: 50%; padding-left: 20px;">
                <?php if($battle->combatantHasEffects("combatantB")) { ?>
                    <?php foreach($battle->battleeffects as $battleeffect) {
                        if ($battleeffect->heroString == "combatantB") { 
                            echo CHtml::link($battleeffect->name, "#", array('class'=>'btn btn-mini ' . ($battleeffect->buff ? 'btn-success' : 'btn-danger'), 'data-title'=>$battleeffect->name, 'data-content'=>$battleeffect->call("getPopup"), 'rel'=>'popover'));
                            echo " &nbsp; ";
                        }
                    } ?>
                <?php } ?>
            </td>
        </tr>
        </table>
        <?php } ?>

        
<?php /* SKILL SELECTION 
 *       ToDo: Switch places if player is combatantB 
 */ ?>
<?php if($battle->state == "ongoing") { ?>
        <table style="width: 100%; margin-top: 35px">
                <tr>
                    <td colspan='2'><h3 align='center' style='margin-bottom: 10px; margin-top: 10px'>Round <?php echo $battle->round + 1; ?></h3></td>
                </tr>
                <tr>
                <td style="width: 50%; border-right-style: dashed; border-right-width: 1px; border-right-color: black;" align="center">
                    <h3 style="margin-bottom: 20px"><?php
                        $msgs = array(
                          "What's your move, champ?",
                          "What are you going to do?",
                          "How do you react?",
                        );
                        echo $msgs[mt_rand(0, count($msgs)-1)];
                    ?></h3>
                    <?php 
                    $Skillset = $battle->getHero()->getSkillset();
                    for($i = 1; $i <= 10; $i++) {
                        if(!empty($Skillset->{"pos" . $i})) {
                            echo CHtml::link($Skillset->{"pos" . $i}->name, array('game/battleAction', 'battleskillID' => $Skillset->{"pos" . $i . "ID"}), array('class'=>'btn btn-primary btn-danger', 'data-title'=>$Skillset->{"pos" . $i}->name, 'data-content'=>$Skillset->{"pos" . $i}->call("getPopup"), 'rel'=>'popover'));
                            echo " &nbsp; ";
                        }
                    } ?></td>
                <td style="width: 50%">
                    <h1 align="center">?</h1>
                </td>
            </tr>
        </table>
    <?php } ?>        
        
        
        <?php /* BATTLE HISTORY */ ?>
        <?php if($battle->round > 0) {
            $logs = $battle->getLogs(); ?>
            <table style="width: 100%; margin-top: 35px">
            <?php for($i = $battle->round; $i > 0; $i--) { ?>
                <tr>
                    <td colspan='2'><h3 align='center' style='margin-bottom: 10px; margin-top: 10px'><?php echo ($i == 0 ? "" : "Round " . $i); ?></h3></td>
                </tr>

                <?php 
                $numOfLogs = count($logs[$i]);
                for($j = $numOfLogs - 1; $j >= 0; $j--) { ?>
                    <tr>
                        <td valign="top" style="width: 50%; padding-right: 20px;  border-right-style: dashed; border-right-width: 1px; border-right-color: black;">
                            <?php if($logs[$i][$j]->hero == "combatantA" &&
                                    ($battle->type == "pve" || $battle->round > 0)) {

                                echo $this->widget('BattleMessageWidget', array("msg" => $logs[$i][$j]), true);
                            } ?>
                        </td>
                
                        <td valign="top" style="width: 50%; padding-left: 20px;">
                            <?php if($logs[$i][$j]->hero == "combatantB") {

                                    echo $this->widget('BattleMessageWidget', array("msg" => $logs[$i][$j]), true);
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        </table>
    </center>
    
</div>