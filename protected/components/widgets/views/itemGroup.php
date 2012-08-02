<?php 

/**
 * Used by ItemGroupWidget
 */

foreach($this->CharacterItems as $CharacterItem) {
    if($CharacterItem->item->type == $this->itemType
            && $CharacterItem->n > 0) {
        
        $this->widget('ItemWidget', array(
            "context" => "inventory",
            "item" => $CharacterItem->item,
            "n" => $CharacterItem->n,
        ));
    }
}
?>