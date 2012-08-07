<?php 
/**
 *  
 */
?>
<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">

    <h1 align="center" style="margin-bottom: 0.4em"><?php echo $CharacterContact->name; ?></h1>
    <p align="center" style="font-size: 1.8em"><?php echo $CharacterContact->contact->getTitle(); ?></p>
    
    <?php
    
    if($CharacterContact->isTreated()) {
        
        echo $CharacterContact->name . " is " . $CharacterContact->getStatus();
        
    } else {
        
        $treatments = $CharacterContact->getPossibleTreatments();
        foreach($treatments as $treatment) {
            switch($treatment) {
                case "befriendable":
                    echo "<a href='" . CHtml::normalizeUrl(array(
                            'befriendContact', 
                            'charactercontactID' => $CharacterContact->id)) .
                         "' class='nounderline'>
                          <div class='btn-group'>
                            <button class='btn btn-large'>1 <i class='icon-time'></i></button>
                            <button class='btn btn-large btn-primary'>Befriend</button>
                          </div></a>";
                    break;
            }
        }
        
    }
    
    ?>

    <hr style='margin-bottom: 50px; margin-top: 50px;'>
    <ul class="nav nav-tabs" id="inventoryTab">
        <li class="active"><a href="#inventoryEquipment" data-toggle="tab">Equipment</a></li>
        <li><a class="nounderline" style="color: grey">Usable</a></li>
        <li><a href="#inventoryCombat" data-toggle="tab">Combat</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="inventoryEquipment">
        </div>
        <div class="tab-pane" id="inventoryUsable">
        </div>
        <div class="tab-pane" id="inventoryCombat">
        </div>
    </div>    
    
</div>