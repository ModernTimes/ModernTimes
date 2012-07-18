<?php 
/**
 * Used by ItemWidget
 */
?>
<div class="thumbnail" style="max-width: 100px; max-height: 100px; min-width: 50px; min-height: 50px; display: inline-block;">

    <?php
    if(!empty($this->item)) {
        echo CHtml::link($this->item->name, "#", array(
            'class'=>'', 
            'data-title'=>$this->item->name, 
            'data-content'=>$this->item->call('getPopup'),
            'rel'=>'popover'));

        if($this->context == "inventory") {
            echo " (" . $this->n . ")";
        }
        echo "<BR />";
        switch($this->context) {
            case "equipment":
                echo "<span style='font-size:0.8em'>";
                echo "<a href='./unequip?slot=" . $this->equipmentSlot . "'>unequip</a></span>";
                break;
            case "inventory":
                echo "<span style='font-size:0.8em'>";
                echo "<a href='./equip?itemID=" . $this->item->id . "'>equip</a> - "
                    . "<a href='./autosell?itemID=" . $this->item->id . "'>get rid of</a></span>";
                break;
            default:
                break;
        }
    } else {
        echo "&nbsp;";
    }
    ?>
        
</div>
