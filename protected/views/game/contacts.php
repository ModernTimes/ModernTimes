<?php 
/**
 * @uses ContactWidget
 */ 
?>
<?php 
if(count($CharacterContacts) > 0) {
    foreach($CharacterContacts as $CharacterContact) {
        $this->widget('ContactWidget', array(
            "CharacterContact" => $CharacterContact,
        ));
    }
}
?>