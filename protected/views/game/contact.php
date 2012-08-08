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
        
        echo "<h2 align='center' style='margin-top: 1em'>Exploitation options</h2>";
        
        echo CHtml::link(
                CHtml::tag("div", array('class' => 'btn-group'),
                    CHtml::htmlButton(
                        $CharacterContact->contact->levelOfInfluence . " " .
                            CHtml::tag("i", array('class' => 'icon-eye-close'), " "),
                        array('class' => 'btn btn-large', 'title' => 'Bad conscience')) . 
                    CHtml::htmlButton("Let " . _objective($CharacterContact->sex) . " praise you",
                        array('class' => 'btn btn-large btn-primary', 
                              'title' => "Gain kudos " . 
                                            $CharacterContact->contact->getAreaOfInfluenceLabel2())
                    )
                ),
                array("exploitContact", "favorID" => "1",
                                        "charactercontactID" => $CharacterContact->id),
                array('class' => 'nounderline', 'style' => 'margin: 10px')
             );
        
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