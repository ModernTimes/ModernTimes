<?php /**
 * @uses EquipmentWidget
 * @uses ItemGroupWidget
 */ 
?>
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
  <li><a href="#inventoryUsable" data-toggle="tab">Usable</a></li>
  <li><a href="#inventoryCombat" data-toggle="tab">Combat</a></li>
  <li><a href="#inventoryQuest" data-toggle="tab">Quest</a></li>
  <li><a href="#inventoryMisc" data-toggle="tab">Other stuff</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="inventoryEquipment">
        <?php $this->widget('EquipmentWidget'); ?>
        <hr>
      
        <p><b>Weapons</b><BR /></p>

        <?php $this->widget('ItemGroupWidget', array(
            'CharacterItems' => $CharacterItems,
            'itemType' => 'weapon'
        )); ?>

        <p>&nbsp;</p><p><b>Offhand</b><BR /></p>

        <?php $this->widget('ItemGroupWidget', array(
            'CharacterItems' => $CharacterItems,
            'itemType' => 'offhand'
        )); ?>

        <p>&nbsp;</p><p><b>Accessories</b><BR /></p>

        <?php $this->widget('ItemGroupWidget', array(
            'CharacterItems' => $CharacterItems,
            'itemType' => 'accessory'
        )); ?>
    </div>
    <div class="tab-pane" id="inventoryUsable">
        <?php $this->widget('ItemGroupWidget', array(
            'CharacterItems' => $CharacterItems,
            'itemType' => 'usable'
        )); ?>
    </div>
    <div class="tab-pane" id="inventoryCombat">
        <?php $this->widget('ItemGroupWidget', array(
            'CharacterItems' => $CharacterItems,
            'itemType' => 'combat'
        )); ?>
    </div>
    <div class="tab-pane" id="inventoryQuest">
        <?php $this->widget('ItemGroupWidget', array(
            'CharacterItems' => $CharacterItems,
            'itemType' => 'quest'
        )); ?>
    </div>
    <div class="tab-pane" id="inventoryMisc">
        <?php $this->widget('ItemGroupWidget', array(
            'CharacterItems' => $CharacterItems,
            'itemType' => 'misc'
        )); ?>
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