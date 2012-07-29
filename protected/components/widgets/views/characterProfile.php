<div class="well" style="padding-left: 70px; width: 530px;">
    <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/characters/<?php echo $this->character->class . "/" . $this->character->sex; ?>-1.png" alt="<?php echo ucfirst($this->character->class); ?>" width="48" height="48" style="float: left; position: relative; top: -5px">

    <div style="display: inline-block; margin-left: 20px; position: relative; top: 3px">
        <p><?php echo $this->character->name . ", a " . $this->character->getTitle(); ?></p>
    </div>

    <div style="display: inline-block; margin-left: 30px; position: relative; top: 3px">
        <?php if(!$this->character->active) {
            echo CHtml::link("Play with this one", "activateCharacter?characterID=" . $this->character->id);
            echo " - ";
            echo CHtml::link("DELETE", "deleteCharacter?characterID=" . $this->character->id);
        } ?>
    </div>
</div>
