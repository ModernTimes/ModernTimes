<?php /* <div class="accordion" id="inventoryAccordion">
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#inventoryAccordion" href="#collapseEquipment">
                Equipment
            </a>
        </div>
        <div id="collapseEquipment" class="accordion-body collapse in">
            <div class="accordion-inner">
                <?php $this->widget('EquipmentWidget'); ?>
            </div>
        </div>
    </div>
</div>

<script>
    // $(".collapse").collapse();
</script>

<BR />  */ ?>
<ul class="nav nav-tabs" id="inventoryTab">
  <li class="active"><a href="#inventoryEquipment" data-toggle="tab">Equipment</a></li>
  <li><a href="#inventoryMisc" data-toggle="tab">Misc</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="inventoryEquipment">
        <p><b>Equipment</b><BR /></p>
        <?php $this->widget('EquipmentWidget'); ?>
      
        <p>&nbsp;</p><p><b>Inventory</b><BR /></p>

        <?php
        // @todo only equippable stuff
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $itemDataProvider,
            'itemView' => '_item',
            'template' => "{items}",
            'separator' => '<BR />'
        ));
        ?>
    </div>
    <div class="tab-pane" id="inventoryMisc">no filtering yet

        <?php
        /*
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
        */ 
        ?>

    </div>
</div>

<script>
    $('#inventoryTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })

    /*
    $(function () {
        $('#inventoryTab a:last').tab('show');
    })
    */
</script>