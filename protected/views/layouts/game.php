<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<?php /*
        <!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
         */ ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?> - GAME</title>
</head>

<body style="padding-top: 40px">

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner"><div class="container">
        <a class="brand" href="#">ModernTimes</a>

        <ul class="nav pull-left">
            <li><?php echo CHtml::link("Travel", array('game/index')); ?></li>
            <li><?php echo CHtml::link("Character", array('game/character')); ?></li>
            <li><?php echo CHtml::link("Inventory", array('game/inventory')); ?></li>
        </ul>
        <ul class="nav pull-right">
            <li><?php echo CHtml::link("Logout (" . Yii::app()->user->name . ")", array('site/logout')); ?></li>
            <li class="divider-vertical"></li>
            <li><?php echo CHtml::link("SITE", array('site/index')); ?></li>
        </ul>
    </div></div>
</div>


<div class="container-fluid" style="padding-top: 40px">

    <div><?php echo $content; ?></div>
    
</div>

    
<div style="padding-bottom: 125px">&nbsp;</div>

</body>
</html>
