<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
/* $this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Change Password"),
); */
?>

<h1><?php echo UserModule::t("Change Password"); ?></h1>


<div class="well" style="margin-top: 30px; padding-left: 100px;">
<?php echo CHtml::beginForm(); ?>

	<?php /* <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p> */ ?>
	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
	<?php echo CHtml::activeLabelEx($form,'password'); ?>
	<?php echo CHtml::activePasswordField($form,'password'); ?>
	<span class="help-inline">
	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
	</span>
	</div>
	
	<div class="row">
	<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
	<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
	</div>
	
	
	<div class="row" style="margin-top: 20px">
	<?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'btn btn-large btn-primary')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->