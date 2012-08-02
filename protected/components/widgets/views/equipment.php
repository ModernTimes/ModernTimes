<div style="display:inline-block; vertical-align: top; margin-right: 20px">Weapon:<BR />
<?php
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "weapon",
    "item" => (!empty($this->equipment->weapon) ? $this->equipment->weapon : null)
)); 
?>
</div>

<div style="display:inline-block; vertical-align: top; margin-right: 20px">Offhand:<BR />
<?php
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "offhand",
    "item" => (!empty($this->equipment->offhand) ? $this->equipment->offhand : null)
)); 
?>
</div>

<div style="display: inline-block; vertical-align:top">Accessories:<BR />
<?php
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessoryA",
    "item" => (!empty($this->equipment->accessoryA) ? $this->equipment->accessoryA : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessoryB",
    "item" => (!empty($this->equipment->accessoryB) ? $this->equipment->accessoryB : null)
)); 
$this->widget('ItemWidget', array(
    "context" => "equipment",
    "equipmentSlot" => "accessoryC",
    "item" => (!empty($this->equipment->accessoryC) ? $this->equipment->accessoryC : null)
)); 
?>
</div>