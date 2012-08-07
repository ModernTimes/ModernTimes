<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/game.css" rel="stylesheet">
            
<?php 
/**
For new bootstrap extension. To be fixed later.
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/application.min.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet"> 
 */
?>
        
        <title><?php echo CHtml::encode($this->pageTitle); ?> - The Game</title>
</head>

<body style="padding-top: 40px;">

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner"><div class="container">
        <a class="brand" href="#">ModernTimes</a>

        <ul class="nav pull-left">
            <li><?php echo CHtml::link("London", array('game/map')); ?></li>
            <li><?php echo CHtml::link("Me", array('game/character')); ?></li>
            <li><?php echo CHtml::link("Stuff", array('game/inventory')); ?></li>
            <li><?php echo CHtml::link("Contacts", array('game/contacts')); ?></li>
            <li><?php echo CHtml::link("Todo", array('game/quests')); ?></li>
            <?php $this->widget("CharacterSkillMenuWidget"); ?>
        </ul>
        <ul class="nav pull-right">
            <?php $this->widget("UserMenuWidget"); ?>

            <li class="divider-vertical"></li>
            <li><?php echo CHtml::link("SITE", array('site/index')); ?></li>
        </ul>
    </div></div>
</div>


<div class="container-fluid" style="padding-top: 30px;">

    <div><?php echo $content; ?></div>
    
</div>

    
<div style="padding-bottom: 125px">&nbsp;</div>

</body>
</html>
