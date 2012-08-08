<?php 
/**
 *  
 */
?>
<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">
    <?php
    if(file_exists(Yii::app()->getBasePath() . 
            "/../images/contacts/" . $CharacterContact->contactID . "-" . $CharacterContact->sex . ".png")) {
        
        $imageHTML = CHtml::image(
                Yii::app()->getBaseUrl(true) . "/images/contacts/" . 
                    $CharacterContact->contactID . "-" . $CharacterContact->sex . ".png", 
                $CharacterContact->name, 
                array('width' => 64,
                      'style' => 'margin-left: 15px; margin-right: 15px; position: relative; top: -5px')
        );
    } else {
        $imageHTML = "";
    }
    ?>

    <h1 align="center" style="margin-bottom: 0.4em;">
        <?php echo $imageHTML; ?>
        <?php echo $CharacterContact->name; ?>
        <?php echo $imageHTML; ?>
    </h1>
    <p align="center" style="font-size: 1.8em">
        <?php echo $CharacterContact->contact->getTitle(); ?>
    </p>
    
    
    <?php
    
    // Treated: show exploitation options
    if($CharacterContact->isTreated()) {
        
        echo "<p align='center' style='font-size: 1.8em'>" . $CharacterContact->getStatusDesc() . "</p>";
        
        if(count($Favors) > 0) { 
            echo "<div class='well' style='margin-top: 2em'>"; 
            echo "<h2 align='center'>Exploitation options</h2><BR />";
        } else {
            echo "<h2 align='center' style='margin-top: 1em'>No exploitation options</h2>";
        }
        foreach($Favors as $Favor) {
            $meetsRequirements = $Favor->meetsRequirements($Character, $CharacterContact, false);
            $btnHTML = CHtml::tag("div", array('class' => 'btn-group', 'style' => 'margin: 10px; display: inline-block'),
                        CHtml::htmlButton(
                            $Favor->call("getBadConscience", $CharacterContact) . " " .
                                CHtml::tag("i", array('class' => 'icon-eye-close'), " "),
                            array('class' => "btn btn-large" . 
                                    ($meetsRequirements ? "" : " disabled"), 
                                   'title' => 'Bad conscience')) . 
                        CHtml::htmlButton($Favor->name,
                            array('class' => "btn btn-large btn-primary" . 
                                    ($meetsRequirements ? "" : " disabled"), 
                                  'title' => "Gain kudos")
                        ));
            
            if($meetsRequirements) {
                echo CHtml::link($btnHTML,
                        array("exploitContact", "favorID" => $Favor->id,
                                                "charactercontactID" => $CharacterContact->id),
                        array('class' => 'nounderline')
                    );
            } elseif(!$Favor->requirementHideIfFails) {
                echo $btnHTML;
            }
        }
        if(count($Favors) > 0) { echo "</div>"; }
        
    }
    
    // Untreated: Show possible treatments
    else {
        
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

    <!--
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
    -->
    
</div>