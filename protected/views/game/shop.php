<?php /**
 * Displays a shop
 */
?>

<div class="hero-unit" style="padding: 0px; margin: 0px; background: none">

    <h1 align="center" style="margin-bottom: 0.4em"><?php echo $Shop->name; ?></h1>

    <p style="margin-bottom: 1.6em"><?php echo $Shop->call('getDesc'); ?></p>

    <center><table border="0" cellpadding="10">
    <?php $StockItems = $Shop->call('getStock');
    foreach($StockItems as $ShopItem) {
        echo "<tr><td>";
            $this->widget("ItemWidget", array(
                "item" => $ShopItem->item
            ));
        echo "</td><td style='font-size: 1.4em; width: 6em'>" . 
                $ShopItem->item->name .
              "</td><td>";
        if($ShopItem->cash > 0) {
            echo $ShopItem->cash . " <img src='" . Yii::app()->getBaseUrl() . "/images/cash.png' width='24' height='24' style='vertical-align: middle' title='Cash'><BR />";
        }
        if($ShopItem->favours > 0) {
            echo $ShopItem->favours . "<img src='" . Yii::app()->getBaseUrl() . "/images/favours.png' width='24' height='24' style='vertical-align: middle' title='Favours'><BR />";
        }
        if($ShopItem->kudos > 0) {
            echo $ShopItem->kudos . " <img src='" . Yii::app()->getBaseUrl() . "/images/kudos.png' width='24' height='24' style='vertical-align: middle' title='Kudos'>";
        }
        echo "</td><td>" .
                "<a class='btn' href='./buyItem?shopID=" . $Shop->id . "&itemID=" . $ShopItem->itemID . "'>Buy</a>" .
             "</td></tr>";
    } ?>
    </table></center>
    
</div>