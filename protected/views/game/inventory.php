<h1>Inventory</h1>

<ul class="nav nav-tabs" id="inventoryTab">
  <li class="active"><a href="#inventoryWeapons" data-toggle="tab">Weapons</a></li>
  <li><a href="#inventoryAccessories" data-toggle="tab">Accessories</a></li>
  <li><a href="#inventoryMisc" data-toggle="tab">Misc</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="inventoryWeapons">...</div>
  <div class="tab-pane" id="inventoryAccessories">...</div>
  <div class="tab-pane" id="inventoryMisc">...</div>
</div>

<script>
    $('#inventoryTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })

    $(function () {
        $('#inventoryTab a:last').tab('show');
    })
</script>

<?php

$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $itemDataProvider,
    'itemView' => '_item',
    'template' => "{items}",
    'separator' => '<BR />',
));
?>

<!--

<b>Weapons:</b><BR />

<?php
$criteria = new CDbCriteria(array(
    'condition' => "`item`.type = 'weapon'"
));
$itemDataProvider->setCriteria($criteria);
$itemDataProvider->getData(true);
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $itemDataProvider,
    'itemView' => '_item',
    'template' => "{items}"
));
?>

-->