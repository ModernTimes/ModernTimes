<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<?php /* <!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        */ ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?> - SITE</title>
</head>

<body style="padding-top: 40px">

<div class="container" id="page">

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner"><div class="container">
        <a class="brand" href="#">ModernTimes</a>

        <ul class="nav pull-left">
            <li><?php echo CHtml::link("Home", array('/site/index')); ?></li>
            <li><?php echo CHtml::link("About", array('/site/page', 'view' => 'about')); ?></li>
            <li><?php echo CHtml::link("Contact", array('/site/contact')); ?></li>
        </ul>
        <ul class="nav pull-right">
            <?php if (Yii::app()->user->isGuest) {
                echo "<li>" . CHtml::link(Yii::app()->getModule('user')->t("Login"), Yii::app()->getModule('user')->loginUrl) . "</li>";
                echo "<li>" . CHtml::link(Yii::app()->getModule('user')->t("Register"), Yii::app()->getModule('user')->registrationUrl) . "</li>";
            } else {
                echo "<li>" . CHtml::link(Yii::app()->getModule('user')->t("Profile"), Yii::app()->getModule('user')->profileUrl) . "</li>";
                echo "<li>" . CHtml::link(Yii::app()->getModule('user')->t("Logout"), Yii::app()->getModule('user')->logoutUrl) . "</li>";
                echo "<li class='divider-vertical'></li>";
                echo "<li>" . CHtml::link("GAME", array('/game/index')) . "</li>";
            } ?>
        </ul>
    </div></div>
</div>
    
	<?php /* if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif */ ?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
