<p><b>Equipment</b></p>

<?php

echo "Weapon: " . (!empty($this->equipment->weapon0)
        ? $this->equipment->weapon0->name . " - unequip"
        : "") . "<BR />";
echo "Accessory: " . (!empty($this->equipment->accessory10)
        ? $this->equipment->accessory10->name . " - unequip"
        : "") . "<BR />";
echo "Accessory: " . (!empty($this->equipment->accessory20)
        ? $this->equipment->accessory20->name . " - unequip"
        : "") . "<BR />";
echo "Accessory: " . (!empty($this->equipment->accessory30)
        ? $this->equipment->accessory30->name . " - unequip"
        : "") . "<BR />";

?>
