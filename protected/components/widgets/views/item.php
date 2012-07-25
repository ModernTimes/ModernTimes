<?php 
/**
 * Used by ItemWidget
 */
?>
<div class="thumbnail" style="width: 50px; height: 50px; display: inline-block; vertical-align:top">

    <?php
    if(!empty($this->item)) {
        
        /**
         * Only generate standard popup content if the item does not generate
         * its own popup
         * @todo make this way more elegant!
         * @todo add colors
         */
        $popup = $this->item->call('getPopup');
        if(empty($popup)) {
            $popup = "<p>" . $this->item->desc . "</p><BR /><P>";
            switch($this->item->type) {
                case "usable":
                    $popup .= "Usable";
                    break;
                case "weapon":
                    $popup .= "Weapon";
                    break;
                case "offhand":
                    $popup .= "Offhand";
                    break;
                case "accessory":
                    $popup .= "Accessory";
                    break;
                case "quest":
                    $popup .= "Quest items";
                    break;
                case "misc":
                    $popup .= "Other stuff";
                    break;
                default:
                    break;
            }
            if(!empty($this->item->charactermodifier)) {
                if($this->item->charactermodifier->hp > 0) {
                    $popup .= "<BR />+" . $this->item->charactermodifier->hp . " HP";
                }
                if($this->item->charactermodifier->hpPerc != 0) {
                    $popup .= "<BR />" . $this->item->charactermodifier->hpPerc . "% HP";
                }
                if($this->item->charactermodifier->energy > 0) {
                    $popup .= "<BR />+" . $this->item->charactermodifier->energy . " Energy";
                }
                if($this->item->charactermodifier->energyPerc != 0) {
                    $popup .= "<BR />" . $this->item->charactermodifier->energyPerc . "% Energy";
                }
                if($this->item->charactermodifier->resoluteness > 0) {
                    $popup .= "<BR />+" . $this->item->charactermodifier->resoluteness . " Resoluteness";
                }
                if($this->item->charactermodifier->resolutenessPerc != 0) {
                    $popup .= "<BR />" . $this->item->charactermodifier->resolutenessPerc . "% more resolute";
                }
                if($this->item->charactermodifier->cunning > 0) {
                    $popup .= "<BR />+" . $this->item->charactermodifier->cunning . " Cunning";
                }
                if($this->item->charactermodifier->cunningPerc != 0) {
                    $popup .= "<BR />" . $this->item->charactermodifier->cunningPerc . "% more cunning";
                }
                if($this->item->charactermodifier->willpower > 0) {
                    $popup .= "<BR />+" . $this->item->charactermodifier->willpower. " Willpower";
                }
                if($this->item->charactermodifier->willpowerPerc != 0) {
                    $popup .= "<BR />" . $this->item->charactermodifier->willpowerPerc . "% more willpowery";
                }
                if($this->item->charactermodifier->dropItemPerc > 0) {
                    $popup .= "<BR />+" . $this->item->charactermodifier->dropItemPerc. "% chance to find items";
                }
                $popup .= "</p>";
            }
        }
        
        echo CHtml::link($this->item->name, "#", array(
            'class'=>'', 
            'data-title'=>$this->item->name, 
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
