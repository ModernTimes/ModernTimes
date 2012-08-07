<?php 
/**
 * @uses ContactWidget
 */ 
?>
<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">

    <h1 align="center" style="margin-bottom: 0.4em">Contacts</h1>
    
<?php
if(count($CharacterContacts) > 0) {
    foreach($CharacterContacts as $CharacterContact) {
        $this->widget('ContactWidget', array(
            "CharacterContact" => $CharacterContact,
        ));
    }
}
?>

</div>