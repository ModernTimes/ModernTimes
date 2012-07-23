<?php 
/**
 * Partial view
 * Used by CListView widget invoked by inventory.php
 */ 

$this->widget('ItemWidget', array(
    "context" => "inventory",
    "item" => $data->item,
    "n" => $data->n,
)); 

?>