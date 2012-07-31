<div class="well" style="padding-left: 50px; width: <?php echo ($this->character->active ? "430" : "580"); ?>px;">
    <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/characters/<?php echo $this->character->class . "/" . $this->character->sex; ?>-1.png" alt="<?php echo ucfirst($this->character->class); ?>" width="48" height="48" style="float: left; position: relative; top: -5px">

    <div style="display: inline-block; margin-left: 20px; position: relative; top: 3px">
        <p><?php echo $this->character->name . ", a " . $this->character->getTitle(); ?></p>
    </div>

    <div style="display: inline-block; margin-left: 30px; position: relative; top: 3px; vertical-align: top">
    <?php if(!$this->character->active) {
            echo CHtml::link(
                    "<i class='icon-ok'></i> Play with this one", 
                    "activateCharacter?characterID=" . $this->character->id,
                    array(
                        'class' => 'btn',
                        'style' => 'margin-right: 10px;'
                 ));
            echo CHtml::link(
                    "<i class='icon-trash'></i> Delete", 
                    "deleteCharacter?characterID=" . $this->character->id, 
                    array(
                        'class' => 'btn btn-danger btn-mini',
                 ));
    } else {
        echo CHtml::link(
                "Play",
                Yii::app()->getBaseUrl() . "/game",
                array('class' => 'btn btn-danger btn-large',
                      'style' => 'position: relative; top: -3px')
             );
    } ?>
    </div>
</div>
