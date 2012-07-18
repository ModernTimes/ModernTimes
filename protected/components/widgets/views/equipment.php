<?php

$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "weapon",
    "item" => (!empty($this->equipment->weapon0) ? $this->equipment->weapon0 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessory1",
    "item" => (!empty($this->equipment->accessoryA0) ? $this->equipment->accessoryA0 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessory2",
    "item" => (!empty($this->equipment->accessoryB0) ? $this->equipment->accessoryB0 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessory3",
    "item" => (!empty($this->equipment->accessoryC0) ? $this->equipment->accessoryC0 : null)
)); 
?>
