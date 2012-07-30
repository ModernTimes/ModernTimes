<h1>Create a new character</h1><BR />

<p>In this development preview, you play a young bullshit artist who just hired at McBooz&Bain Consulting Group. As a bullshit artist, you rely on your babble skills to bury your enemies under a spate on highly sophisticated nonsense. Your cunning is legendary, and you can make quite a bit of money.</p>

<p>&nbsp;</p>

<div class="well" style="padding-left: 50px">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'createcharacter-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

	<?php /* echo $form->errorSummary($model); */ ?>

        <div  style="display: inline-block; margin-right: 60px">
            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/characters/consultant/male-1.png" alt="Consultant" width="64" height="64">
            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/characters/consultant/female-1.png" alt="Consultant" width="64" height="64">
        </div>

        <div style="display: inline-block; vertical-align: top">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name'); ?>
            <?php echo $form->error($model,'name'); ?>
	</div>
    
	<div style="display: inline-block; margin-left: 30px; vertical-align: top">
            <?php echo $form->labelEx($model,'sex'); ?>
            <?php echo $form->radioButtonList($model,'sex', array(
                'male' => 'Male',
                'female' => 'Female'
            ), array('separator'=>'<BR />', 'labelOptions' => array('style'=>'display:inline'))); ?>
            <?php echo $form->error($model,'sex'); ?>
	</div>

        <?php /*
	<?php if(CCaptcha::checkRequirements()): ?>
	<div>
            <?php echo $form->labelEx($model,'verifyCode'); ?>
            <div>
            <?php $this->widget('CCaptcha'); ?>
            <?php echo $form->textField($model,'verifyCode'); ?>
            </div>
            <div class="hint">Please enter the letters as they are shown in the image above.
            <br/>Letters are not case-sensitive.</div>
            <?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>
        */ ?>
        
	<div class="buttons" style="display: inline-block; vertical-align: top; margin-left: 30px; padding-top: 1.8em">
            <?php echo CHtml::submitButton("Let's go!"); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
