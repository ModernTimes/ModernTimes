<?php 

/*
 *  Prints Yii's flash messages and adds icons, styles, and whatever else is
 *  needed to make it beauuuuutiful
 */

if(count(Yii::app()->user->getFlashes(false)) > 0) { ?>
        <div align="center"><div style="width: 75%; margin-bottom: 25px" align="left">
        <?php foreach(Yii::app()->user->getFlashes() as $key => $message) { ?>
            <div class="" style="margin: 0px; padding: 3px; background-color: none; text-align: center">

            <?php if (strstr($key, "gainItem")) { 
                // ToDo: well, this one is obvious
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
                    'width' => 36,
                    'height' => 36,
                    'style' => "vertical-align: middle",
                ));
            } elseif (strstr($key, "gainFavours")) { 
                echo CHtml::image(Yii::app()->getBaseUrl() . "/images/favours.png", "Favours", array(
                    'width' => 36,
                    'height' => 36,
                    'style' => "vertical-align: middle",
                ));
            } elseif (strstr($key, "gainKudos")) { 
                echo CHtml::image(Yii::app()->getBaseUrl() . "/images/kudos.png", "Kudos", array(
                    'width' => 36,
                    'height' => 36,
                    'style' => "vertical-align: middle",
                ));
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
            <?php } 
            // Standard badges
            elseif(strstr($key, '__notice')) { ?>
                <span class="label label-info">Info</span>
            <?php } elseif (strstr($key, '__success')) { ?>
                <span class="label label-success">Yay</span>
            <?php } elseif (strstr($key, '__warning')) { ?>
                <span class="label label-warning">Care</span>
            <?php } elseif (strstr($key, '__error')) { ?>
                <span class="label label-important">Oops</span>
            <?php } ?>

            <?php echo "&nbsp;" . $message . "</div>"; ?>

        <?php } ?>
        </div></div>
<?php } ?>