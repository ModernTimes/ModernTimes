<?php 

/*
 *  Prints Yii's flash messages and adds icons, styles, and whatever else is
 *  needed to make it beauuuuutiful
 */

$numberOfMessages = count(Yii::app()->user->getFlashes(false));
if($numberOfMessages > 0) {
    echo "<div align='center'><div class=\"well\" style=\"width: 65%; text-align: left; margin-bottom: 20px\">";
    
    foreach(Yii::app()->user->getFlashes() as $key => $message) { ?>
        <?php
        // Standard badges
        if(strstr($key, '__notice')) { ?>
            <div class="alert" style="font-size: 1.3em; margin: 0px"><?php /* <span class="label label-info" style="position: relative; top: -2px">Info</span> */ ?>
        <?php } elseif (strstr($key, '__success')) { ?>
            <div class="alert alert-success" style="font-size: 1.3em; margin: 0px"><?php /* <span class="label label-success" style="position: relative; top: -2px">Yay</span> */ ?>
        <?php } elseif (strstr($key, '__warning')) { ?>
            <div class="alert alert-warning" style="font-size: 1.3em; margin: 0px"><?php /* <span class="label label-warning" style="position: relative; top: -2px">Care</span>  */ ?>
        <?php } elseif (strstr($key, '__error')) { ?>
            <div class="alert alert-error" style="font-size: 1.3em; margin: 0px"><span class="label label-important" style="position: relative; top: -2px">Oops</span>
        <?php } else { ?>
            <div style="font-size: 1.3em; margin: 0px">
        <?php } ?>

        <?php if (strstr($key, "gainItem")) { 
            // @todo use actual itemID
            if(TRUE || file_exists(Yii::app()->getBaseUrl() . "/images/items/1.png")) {
                echo CHtml::image(Yii::app()->getBaseUrl() . "/images/items/1.png", "Item", array(
                    'width' => 36,
                    'height' => 36,
                    'style' => "vertical-align: middle",
                ));
            } else { ?>
                <span class="label label-success">Item</span>
            <?php }
        } elseif (strstr($key, "gainCash")) { 
            echo CHtml::image(Yii::app()->getBaseUrl() . "/images/cash.png", "Cash", array(
                'width' => 24,
                'height' => 24,
                'style' => "vertical-align: middle",
            ));
        } elseif (strstr($key, "gainFavours")) { 
            echo CHtml::image(Yii::app()->getBaseUrl() . "/images/favours.png", "Favours", array(
                'width' => 24,
                'height' => 24,
                'style' => "vertical-align: middle",
            ));
        } elseif (strstr($key, "gainKudos")) { 
            echo CHtml::image(Yii::app()->getBaseUrl() . "/images/kudos.png", "Kudos", array(
                'width' => 24,
                'height' => 24,
                'style' => "vertical-align: middle",
            ));
        } elseif (strstr($key, "gainLevel")) { ?>
            <span class="label label-success" style="position: relative; top: -2px">Level</span>
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