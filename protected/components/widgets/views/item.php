<?php 
/**
 * Used by ItemWidget
 * @uses CharactermodifierWidget
 * @uses RequirementWidget
 */
?>
<div style="width: <?php echo ($this->width+2); ?>px; display: inline-block; vertical-align: top; margin-right: <?php echo ($this->marginRight+10); ?>px">
<div class="thumbnail" style="width: <?php echo ($this->width + 2);?>px; height: <?php echo ($this->width+2);?>px; display: inline-block">

<?php
if(!empty($this->item)) {
    /**
        * Only generate standard popup content if the item does not generate
        * its own popup
        */
    $popup = $this->item->call('getPopup');
    if(empty($popup)) {
        $popup = "<p>" . $this->item->desc . "</p>";
        if(!empty($this->item->charactermodifier)) {
            $popup .= "<BR />"; 
            $popup .= $this->widget('CharactermodifierWidget', 
                    array("Charactermodifier" => $this->item->charactermodifier), 
                    true);
        }
        if(!empty($this->item->requirement)) {
            $popup .= "<BR />"; 
            $popup .= $this->widget('RequirementWidget', 
                    array("Requirement" => $this->item->requirement), 
                    true);
        }
    }

    switch($this->item->type) {
        case "usable":
            $itemType = "Usable";
            break;
        case "weapon":
            $itemType = "Weapon";
            break;
        case "offhand":
            $itemType = "Offhand";
            break;
        case "accessory":
            $itemType = "Accessory";
            break;
        case "quest":
            $itemType = "Quest items";
            break;
        case "misc":
        default:
            $itemType = "Other stuff";
            break;
    }

    if(file_exists(Yii::app()->getBasePath() . "/../images/items/" . $this->item->id . ".png")) {
        $displayHTML = CHtml::image(Yii::app()->getBaseUrl(true) . 
                "/images/items/" . $this->item->id . ".png", 
                $this->item->name, array(
                    'width' => $this->width,
                    'height' => $this->width,
                    'style' => "",
                ));
    } else {
        $displayHTML = $this->item->name;
    }
    
    echo CHtml::link($displayHTML, "#", array(
        'class'=>'', 
        'data-title'=>$this->item->name . " <span style='font-size: 0.7em'>(" . $itemType . ")</span>", 
        'data-content'=>$popup,
        'rel'=>'popover'));

    echo "</div><p style='font-size:0.8em; line-height: 1.2em; margin-top: 0.3em'>";

    if($this->context == "inventory") {
        echo $this->n . "x - ";
    }
    switch($this->context) {
        case "equipment":
            echo "<a href='./unequip?slot=" . $this->equipmentSlot . "'>unequip</a>";
            break;
        case "inventory":
            if($this->item->type == 'usable') {
                echo "<a href='./useItem?itemID=" . $this->item->id . "'>use</a> - ";
            }
            if($this->item->type == 'weapon' || $this->item->type == 'offhand' || $this->item->type == 'accessory') {
                echo "<a href='./equip?itemID=" . $this->item->id . "'>equip</a> - ";
            }
            echo "<a href='./autosell?itemID=" . $this->item->id . "'>sell</a>";
            break;
        default:
            break;
    }
    echo "</p>";
} else {
    echo "</div>";
}
?>
</div>