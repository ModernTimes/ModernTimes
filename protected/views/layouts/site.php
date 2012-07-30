<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<title><?php echo CHtml::encode($this->pageTitle); ?> - SITE</title>
</head>

<body style="padding-top: 40px">

<!-- GitHub ribbon -->
<a href="https://github.com/ModernTimes/ModernTimes"><img style="position: absolute; top: 40px; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>


<div class="container" id="page">

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner"><div class="container">
        <a class="brand" href="#">ModernTimes</a>

        <ul class="nav pull-left">
            <li><?php echo CHtml::link("Home", array('/site/index')); ?></li>
            <li><?php echo CHtml::link("Contribute to the game!", array('/site/page', 'view' => 'contributors')); ?></li>
            <!-- <li><?php echo CHtml::link("Contact", array('/site/contact')); ?></li> -->
            <li><?php echo CHtml::link("Credits", array('/site/page', 'view' => 'credits')); ?></li>
        </ul>
        <ul class="nav pull-right">
            <?php if (Yii::app()->user->isGuest) {
                echo "<li>" . CHtml::link(Yii::app()->getModule('user')->t("Login"), Yii::app()->getModule('user')->loginUrl) . "</li>";
                echo "<li>" . CHtml::link(Yii::app()->getModule('user')->t("Register"), Yii::app()->getModule('user')->registrationUrl) . "</li>";
            } else { ?>
                
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
            
            <?php
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

	<div id="footer"></div>
        <!-- footer -->

</div><!-- page -->

<!-- UserEcho widget -->
<script type='text/javascript'>
var _ues = {
host:'moderntimes.userecho.com',
forum:'13814',
lang:'en',
tab_corner_radius:4,
tab_font_size:16,
tab_image_hash:'IFBpdGNoZW4tSG9sZQ%3D%3D',
tab_alignment:'right',
tab_text_color:'#FFFFFF',
tab_bg_color:'#AA0000',
tab_hover_color:'#AA0000'
};

(function() {
    var _ue = document.createElement('script'); _ue.type = 'text/javascript'; _ue.async = true;
    _ue.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/' : 'http://') + 'cdn.userecho.com/js/widget-1.4.gz.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(_ue, s);
  })();

</script>

</body>
</html>
