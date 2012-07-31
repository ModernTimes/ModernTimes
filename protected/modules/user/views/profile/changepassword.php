<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
/* $this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	UserModule::t("Change Password"),
); */
?>

<h2><?php echo UserModule::t("Change password"); ?></h2>
<?php echo $this->renderPartial('menu'); ?>

<div class="well" style="margin-top: 30px; padding-left: 100px;">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'changepassword-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php /* <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p> */ ?>
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	<span class="help-inline">
	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
	</span>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
	</div>
	
	
	<div class="row" style="margin-top: 20px">
	<?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'btn btn-primary btn-large')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->