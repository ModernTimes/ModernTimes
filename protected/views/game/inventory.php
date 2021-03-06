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
  <li><a href="#crafting" data-toggle="tab">Combine things</a></li>
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
    
    
    
    <div class="tab-pane" id="crafting">
        <div class="well">
            <table border="0" cellpadding="5"><tr>
            <?php
            $Items = array(array('id' => 'empty', 'name' => '(Select an item)'));
            foreach($CharacterItems as $CharacterItem) {
                $Items[] = $CharacterItem->item;
            }
            $CListData = CHtml::listData($Items, "id", "name");
            
            echo CHtml::beginForm("combineItems", "get");
            echo "<td style='font-size: 1.3em'>Combine </td>";
            echo "<td>" . CHtml::dropDownList("item1ID", "empty", $CListData, array('style' => 'position: relative; top: 5px')) . "</td>";
            echo "<td style='font-size: 1.3em'> with </td>";
            echo "<td>" . CHtml::dropDownList("item2ID", "empty", $CListData, array('style' => 'position: relative; top: 5px')) . "</td>";
            echo "<td>" . CHtml::submitButton("Combine", array('class' => 'btn btn-large btn-primary', 'style'=>'margin-left: 10px')) . "</td>";
            echo CHtml::endForm();
            ?>
            </tr></table>
        </div>
        
        <?php 
        if(count($CharacterRecipes) > 0) {
            echo "<h2>Known combinations</h2><BR />";
            foreach($CharacterRecipes as $CharacterRecipe) {
                echo "<div>";
                $this->widget('ItemWidget', array(
                    "context" => "free",
                    "width" => 36,
                    "marginRight" => 0,
                    "item" => $CharacterRecipe->recipe->item1,
                ));
                echo "<span style='position: relative; top: 10px'> + </span>";
                $this->widget('ItemWidget', array(
                    "context" => "free",
                    "width" => 36,
                    "marginRight" => 0,
                    "item" => $CharacterRecipe->recipe->item2,
                ));
                echo "<span style='position: relative; top: 10px'> = </span>";
                $this->widget('ItemWidget', array(
                    "context" => "free",
                    "width" => 36,
                    "marginRight" => 0,
                    "item" => $CharacterRecipe->recipe->itemResult
                ));
                echo CHtml::link("Combine", "./combineItems?item1ID=" . $CharacterRecipe->recipe->item1ID . "&item2ID=" . $CharacterRecipe->recipe->item2ID, array('class' => 'btn btn-primary', 'style' => 'margin-left: 15px; position: relative; top: 10px;'));
                echo "</div>";
            }
        }

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