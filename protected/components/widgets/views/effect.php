<?php 
/**
 * Used by EffectWidget
 * @uses CharactermodifierWidget
 */
?>

<?php
if(!empty($this->effect)) {

    /**
     * Only generate standard popup content if Effect does not generate
     * its own popup
     */
    $popup = $this->effect->call('getPopup');
    if(empty($popup)) {
        $popup = "<p>" . $this->effect->desc . "</p>";
        if(!empty($this->effect->charactermodifier)) {
            $popup .= $this->widget('CharactermodifierWidget', 
                    array("Charactermodifier" => $this->effect->charactermodifier), 
                    true);
        }
    }

    echo CHtml::link($this->effect->name . " (" . $this->turns . ")", "#", array(
        'class'=>'btn btn-info btn-mini', 
        'data-title'=>$this->effect->name . " <span style='font-size: 0.7em'>(" . $this->turns . " turns)</span>", 
        'data-content'=>$popup,
        'rel'=>'popover'));
    
}
?>
