<?php 
/**
 * Used by ItemWidget
 * @uses CharactermodifierWidget
 */
?>
<div class="thumbnail" style="width: 50px; height: 50px; display: inline-block; vertical-align:top">

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
        
        echo CHtml::link($this->item->name, "#", array(
            'class'=>'', 
            'data-title'=>$this->item->name . " <span style='font-size: 0.7em'>(" . $itemType . ")</span>", 
            'data-content'=>$popup,
            'rel'=>'popover'));

        if($this->context == "inventory") {
            echo " <span style='font-size:0.8em'>(" . $this->n . ")</span>";
        }
        echo "<BR />";
        switch($this->context) {
            case "equipment":
                echo "<span style='font-size:0.8em'>";
                echo "<a href='./unequip?slot=" . $this->equipmentSlot . "'>unequip</a></span>";
                break;
            case "inventory":
                echo "<span style='font-size:0.8em'>";
                if($this->item->type == 'usable') {
                    echo "<a href='./useItem?itemID=" . $this->item->id . "'>use</a> - ";
                }
                if($this->item->type == 'weapon' || $this->item->type == 'offhand' || $this->item->type == 'accessory') {
                    echo "<a href='./equip?itemID=" . $this->item->id . "'>equip</a> - ";
                }
                echo "<a href='./autosell?itemID=" . $this->item->id . "'>sell</a>";
                echo "</span>";
                break;
            default:
                break;
        }
    } else {
        echo "&nbsp;";
    }
    ?>
        
</div>
