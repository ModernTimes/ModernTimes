<?php 
/**
 * Used by ContactWidget
 */
?>
<div style="width: <?php echo ($this->width+2); ?>px; display: inline-block; vertical-align: top; margin-right: <?php echo ($this->marginRight+10); ?>px">
    
    <div class="thumbnail" style="width: <?php echo ($this->width + 2);?>px; height: <?php echo ($this->width+2);?>px; display: inline-block; position: relative;">

        
<?php
if(!empty($this->CharacterContact)) {
    /**
     * Only generate standard popup content if the item does not generate
     * its own popup
     */
    $popup = $this->CharacterContact->contact->call('getPopup', $this->CharacterContact);
    if(empty($popup)) {
        $popup = "<p>" . $this->CharacterContact->contact->getTitle() . "</p>";

        // Already treated: show status
        if($this->CharacterContact->isTreated()) {
            $popup .= "<p><BR />" . $this->CharacterContact->getStatusDesc() . "</p>";
        }
        // Not treated yet: show treatment options
        else {
            $popup .= "<p style='font-size: 0.9em; margin-top: 0.8em'>You can try to ";
            $possibleTreatments = $this->CharacterContact->getPossibleTreatments();
            $total = count($possibleTreatments);
            $i = 1;
            foreach($possibleTreatments as $treatment) {
                if($i == $total && $total > 1) { $popup .= ($total == 2 ? " " : "") . "or "; }
                switch($treatment) {
                    case "befriendable":
                        $popup .= "<b>make friends</b> with " . Yii::app()->tools->getObjectPronoun($this->CharacterContact->sex);
                        break;
                    case "bribable":
                        $popup .= "<b>bribe</b> " . Yii::app()->tools->getObjectPronoun($this->CharacterContact->sex);
                        break;
                    case "seducible":
                        $popup .= "<b>seduce</b> " . Yii::app()->tools->getObjectPronoun($this->CharacterContact->sex);
                        break;
                    // Should never happen
                    default:
                        $popup .= "use the fact that " . Yii::app()->tools->getPersonalPronoun($this->CharacterContact->sex) . " is " . $treatment;
                        break;
                }
                if($i < $total && $total > 2) { $popup .= ", "; }
                if($i == $total) { $popup .= "."; }
                $i++;
            }
            $popup .= "</p>";
        }
    }

    
    // Image or name?
    if(file_exists(Yii::app()->getBasePath() . "/../images/contacts/" . $this->CharacterContact->contactID . "-" . $this->CharacterContact->sex . ".png")) {
        $displayHTML = CHtml::image(
                Yii::app()->getBaseUrl(true) . "/images/contacts/" . 
                    $this->CharacterContact->contactID . "-" . $this->CharacterContact->sex . ".png", 
                $this->CharacterContact->name, 
                array('width' => $this->width-7)
        );
    } else {
        $displayHTML = $this->CharacterContact->name;
    }
    
    
    // Actual link
    echo CHtml::link(
            $displayHTML, 
            array("contact", "charactercontactID" => $this->CharacterContact->id), 
            array(
                'class'=>'', 
                'data-title'=>$this->CharacterContact->name, 
                'data-content'=>$popup,
                'rel'=>'popover'
            )
         );

    /**
     * OVERLAYS 
     */
    
    // Level icons
    echo "<div style='position: absolute; right: 4px; top: 0px'><i class='icon-chevron-up'></i></div>" . 
          ($this->CharacterContact->contact->levelOfInfluence > 1 ? "<div style='position: absolute; right: 4px; top: 6px'><i class='icon-chevron-up'></i></div>" : "") . 
          ($this->CharacterContact->contact->levelOfInfluence > 2 ? "<div style='position: absolute; right: 4px; top: 12px'><i class='icon-chevron-up'></i></div>" : "");
    
    // Status icon
    $status = $this->CharacterContact->getStatus();
    if($status != "untreated") {
        echo "<div style='position: absolute; right: 4px; bottom: 2px;'><img src='" . Yii::app()->getBaseUrl() . "/images/contact" . ucfirst($status) . ".png' width=18></div>";
    }

    // End thumbnail box
    echo "</div>";
    
        
    echo "<p style='font-size:0.8em; line-height: 1.2em; margin-top: 0.3em'>";
    switch($this->context) {
        default:
            break;
    }
    echo "</p>";
    
} else {
    echo "</div>";
}
?>
</div>