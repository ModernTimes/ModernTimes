<?php 
/**
 * Partial view
 * Used by CListView widget in inventory.php
 */ 

$this->widget('ItemWidget', array(
    "context" => "inventory",
    "item" => $data->item,
    "n" => $data->n,
)); 

?>