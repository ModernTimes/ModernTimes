<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
/* $this->breadcrumbs=array(
	UserModule::t("Login"),
); */
?>

<h1><?php echo UserModule::t("Login"); ?></h1>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>
<?php endif; ?>

<?php /* <p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p> */ ?>

<div class="well" style="margin-top: 30px; padding-left: 100px;">
<?php echo CHtml::beginForm(); ?>

	<?php /* <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p> */ ?>
	
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username') ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password') ?>
	</div>
	
	<div class="row" style="margin-top: 10px">
		<?php echo CHtml::activeCheckBox($model,'rememberMe', array('style' => 'display: inline')); ?>
		<?php echo CHtml::activeLabelEx($model,'rememberMe', array('style' => 'display: inline')); ?>
	</div>

	<div class="row" style="margin-top: 20px">
		<?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'btn btn-large btn-primary')); ?>
        </div>

        <div class="row" style="margin-top: 20px">
            <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl, array('class' => 'btn btn-mini')); ?> 
            <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl, array('class' => 'btn btn-mini')); ?>
	</div>
	
<?php echo CHtml::endForm(); ?>
</div><!-- form -->


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>