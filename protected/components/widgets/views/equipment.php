<?php

$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "weapon",
    "item" => (!empty($this->equipment->weapon0) ? $this->equipment->weapon0 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessoryA",
    "item" => (!empty($this->equipment->accessoryA0) ? $this->equipment->accessoryA0 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessoryB",
    "item" => (!empty($this->equipment->accessoryB0) ? $this->equipment->accessoryB0 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessoryC",
    "item" => (!empty($this->equipment->accessoryC0) ? $this->equipment->accessoryC0 : null)
)); 
?>