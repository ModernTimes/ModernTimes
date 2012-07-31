<?php 
if (Yii::app()->user->isGuest) {
    echo "<li>" . CHtml::link("Login", array("/user/login")) . "</li>";
    echo "<li>" . CHtml::link("Register", array("/user/registration")) . "</li>";
} else { ?>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php echo Yii::app()->user->name; ?>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <?php echo "<li>" . CHtml::link("Logout", array("/user/logout")) . "</li>"; ?>
            <li class='divider'></li>
            <?php echo "<li>" . CHtml::link("Your characters", array("/site/manageCharacters")) . "</li>"; ?>
            <?php echo "<li>" . CHtml::link("Create a new character", array("/site/createCharacter")) . "</li>"; ?>
            <li class='divider'></li>
            <?php /* echo "<li>" . CHtml::link("Profile", array("/user/profile")) . "</li>"; */ ?>
            <?php echo "<li>" . CHtml::link("Edit profile", array("/user/profile/edit")) . "</li>"; ?>
            <?php echo "<li>" . CHtml::link("Change password", array("/user/profile/changepassword")) . "</li>"; ?>
        </ul>
    </li>
<?php } ?>


<?php /*
if(UserModule::isAdmin()) {
    <li><?php echo CHtml::link(UserModule::t('Manage User'),array('/user/admin')); ?></li>
} else {
    <li><?php echo CHtml::link(UserModule::t('List User'),array('/user')); ?></li>
}
*/ 
?>