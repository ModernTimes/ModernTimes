<div class="accordion" id="inventoryAccordion">
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#inventoryAccordion" href="#collapseEquipment">
                Equipment
            </a>
        </div>
        <?php /* add "in" as class to open on default */ ?>
        <div id="collapseEquipment" class="accordion-body collapse">
            <div class="accordion-inner">
                <?php $this->widget('EquipmentWidget'); ?>
            </div>
        </div>
    </div>
</div>

<script>
    // $(".collapse").collapse();
</script>

<BR />
<p><b>Inventory</b><BR /></p>

<ul class="nav nav-tabs" id="inventoryTab">
  <li class="active"><a href="#inventoryAll" data-toggle="tab">All</a></li>
  <li><a href="#inventoryWeapons" data-toggle="tab">Weapons</a></li>
  <li><a href="#inventoryAccessories" data-toggle="tab">Accessories</a></li>
  <li><a href="#inventoryMisc" data-toggle="tab">Misc</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="inventoryAll">

    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $itemDataProvider,
        'itemView' => '_item',
        'template' => "{items}",
        'separator' => '<BR />',
    ));
    ?>

  </div>
  <div class="tab-pane" id="inventoryWeapons">no filtering yet
      
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
  <div class="tab-pane" id="inventoryAccessories">no filtering yet</div>
  <div class="tab-pane" id="inventoryMisc">no filtering yet</div>
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