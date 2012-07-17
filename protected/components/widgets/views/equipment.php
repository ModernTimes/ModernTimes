<p><b>Equipment</b></p>

<?php

$this->widget('ItemWidget', array(
    "context" => "equipment",
    "item" => (!empty($this->equipment->weapon0) ? $this->equipment->weapon0 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "item" => (!empty($this->equipment->accessory10) ? $this->equipment->accessory10 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "item" => (!empty($this->equipment->accessory20) ? $this->equipment->accessory20 : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
        "item" => (!empty($this->equipment->accessory30) ? $this->equipment->accessory30 : null)
)); 
?>
