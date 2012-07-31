<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
/* $this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
); */
?>

<h1><?php echo UserModule::t("Restore"); ?></h1>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="well" style="margin-top: 30px; padding-left: 100px;">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo CHtml::activeTextField($form,'login_or_email') ?>
		<?php /* <span class="help-inline"><?php echo UserModule::t("Please enter your login or email addres."); ?></span> */ ?>
	</div>
	
	<div class="row" style="margin-top: 20px">
		<?php echo CHtml::submitButton(UserModule::t("Restore"), array('class' => 'btn btn-large btn-primary')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>