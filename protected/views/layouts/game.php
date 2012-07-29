<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

        <title><?php echo CHtml::encode($this->pageTitle); ?> - The Game</title>
</head>

<body style="padding-top: 40px;">

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner"><div class="container">
        <a class="brand" href="#">ModernTimes</a>

        <ul class="nav pull-left">
            <li><?php echo CHtml::link("London", array('game/map')); ?></li>
            <li><?php echo CHtml::link("Me", array('game/character')); ?></li>
            <li><?php echo CHtml::link("My stuff", array('game/inventory')); ?></li>
            <li><?php echo CHtml::link("Todo", array('game/quests')); ?></li>
        </ul>
        <ul class="nav pull-right">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php echo Yii::app()->user->name; ?>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <?php echo "<li>" . CHtml::link(Yii::app()->getModule('user')->t("Logout"), Yii::app()->getModule('user')->logoutUrl) . "</li>"; ?>
                    <?php echo "<li>" . CHtml::link(Yii::app()->getModule('user')->t("Profile"), Yii::app()->getModule('user')->profileUrl) . "</li>"; ?>
                    <li class='divider'></li>
                    <?php echo "<li>" . CHtml::link("Your characters", "../site/manageCharacters") . "</li>"; ?>
                    <?php echo "<li>" . CHtml::link("Create a new character", "../site/createCharacter") . "</li>"; ?>
                </ul>
            </li>

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
