<?php 
/**
 * Used by ContactWidget
 */
?>
<div style="width: <?php echo ($this->width+2); ?>px; display: inline-block; vertical-align: top; margin-right: <?php echo ($this->marginRight+10); ?>px">
<div class="thumbnail" style="width: <?php echo ($this->width + 2);?>px; height: <?php echo ($this->width+2);?>px; display: inline-block">

<?php
if(!empty($this->CharacterContact)) {
    /**
        * Only generate standard popup content if the item does not generate
        * its own popup
        */
    $popup = $this->CharacterContact->contact->call('getPopup', $this->CharacterContact);
    if(empty($popup)) {
        $popup = "<p></p>";
    }

    if(file_exists(Yii::app()->getBasePath() . "/../images/contacts/" . $this->CharacterContact->contactID . ".png")) {
        $displayHTML = CHtml::image(Yii::app()->getBaseUrl(true) . 
                "/images/contacts/" . $this->CharacterContact->contactID . ".png", 
                $this->CharacterContact->name, array(
                    'width' => $this->width,
                    // 'height' => $this->width
                ));
    } else {
        $displayHTML = $this->CharacterContact->name;
    }
    
    echo CHtml::link($displayHTML, "#", array(
        'class'=>'', 
        'data-title'=>$this->CharacterContact->name . "<BR /><span style='font-size: 0.7em'>" . $this->CharacterContact->contact->getTitle() . "</span>", 
        'data-content'=>$popup,
        'rel'=>'popover'));

    echo "</div><p style='font-size:0.8em; line-height: 1.2em; margin-top: 0.3em'>";

    switch($this->context) {
        default:
            break;
    }
} else {
    echo "</div>";
}
?>
</div>