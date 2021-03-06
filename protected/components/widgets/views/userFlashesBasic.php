<?php 

/*
 *  Prints Yii's flash messages and adds icons, styles, and whatever else is
 *  needed to make it beauuuuutiful
 */

$numberOfMessages = count(Yii::app()->user->getFlashes(false));
if($numberOfMessages > 0) {
    echo "<div align='center'><div class=\"well\" style=\"width: 65%; text-align: left; margin-bottom: 20px;\">";
    
    foreach(Yii::app()->user->getFlashes() as $key => $message) { ?>
        <?php
        // Standard badges
        if(strstr($key, '__notice')) { ?>
            <div class="alert" style="font-size: 1.3em; margin: 0px"><?php /* <span class="label label-info">Info</span> */ ?>
        <?php } elseif (strstr($key, '__success')) { ?>
            <div class="alert alert-success" style="font-size: 1.3em; margin: 0px;"><?php /* <span class="label label-success">Yay</span> */ ?>
        <?php } elseif (strstr($key, '__warning')) { ?>
            <div class="alert alert-warning" style="font-size: 1.3em; margin: 0px"><?php /* <span class="label label-warning">Care</span>  */ ?>
        <?php } elseif (strstr($key, '__error')) { ?>
            <div class="alert alert-error" style="font-size: 1.3em; margin: 0px"><span class="label label-important">Oops</span>
        <?php } else { ?>
            <div style="font-size: 1.3em; margin: 0px">
        <?php } ?>

        <?php if (strstr($key, "gainItem")) { 
            $itemID = substr($key, strpos($key, 'id:')+3);
            if(file_exists(Yii::app()->getBasePath() . "/../images/items/" . $itemID . ".png")) {
                echo CHtml::image(Yii::app()->getBasePath() . "/../images/items/" . $itemID . ".png", "Item", array(
                    'width' => 24,
                    'height' => 24,
                    'style' => "vertical-align: middle",
                ));
            } else { ?>
                <span class="label label-success">Item</span>
            <?php }
        } elseif (strstr($key, "gainCash") || strstr($key, "loseCash")) { 
            echo "<i class='icon-cash'></i>";
        } elseif (strstr($key, "gainLevel")) { ?>
            <span class="label label-success">Level</span>
        <?php } elseif (strstr($key, "gainHp")) { ?>
            <i class="icon-heart"></i>
        <?php } elseif (strstr($key, "gainEnergy")) { ?>
            <i class="icon-star"></i>
        <?php // Some stuff doesn't warrent a picture or badge
        } elseif (strstr($key, "gainNormalstat") ||
                    strstr($key, "gainXP") ||
                    strstr($key, "gainSubstat")) { ?>
        <?php } ?> 

        <?php echo $message . "</div>"; ?>
            
    <?php }
        echo "</div></div>";
}
?>