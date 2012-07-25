<?php /**
 * Displays a shop
 */
?>

<h1 align="center"><?php echo $Shop->name; ?></h1>

<p><?php echo $Shop->call('getDesc'); ?></p>

<?php foreach($Shop->shopItems as $ShopItem) {
    $this->widget("ItemWidget", array(
        "item" => $ShopItem->item
    ));
    
    echo $ShopItem->item->name;
    
    echo $ShopItem->cash . " - " . $ShopItem->favours . " - " . $ShopItem->kudos;
    echo "<a href='./buyItem?shopID=" . $Shop->id . "&itemID=" . $ShopItem->itemID . "'>buy</a>";
    echo "<BR />";
} ?>