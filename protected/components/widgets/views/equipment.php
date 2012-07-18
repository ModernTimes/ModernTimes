<?php

$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "weapon",
    "item" => (!empty($this->equipment->weapon0) ? $this->equipment->weapon0 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessory1",
    "item" => (!empty($this->equipment->accessory10) ? $this->equipment->accessory10 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessory2",
    "item" => (!empty($this->equipment->accessory20) ? $this->equipment->accessory20 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessory3",
    "item" => (!empty($this->equipment->accessory30) ? $this->equipment->accessory30 : null)
)); 
?>
