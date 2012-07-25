<?php
/**
 * Buys items from a Shop
 * Does all kinds of sanity checks; redirects to ShopAction after the purchase
 * 
 * @uses ShopAction
 * @package Actions.Shopping
 */

class BuyItemAction extends CAction {

    /**
     * Does a couple of sanity checks
     * Then sellst he item and redirects to ShopAction
     * @param string $shopID int, but represented as string (bc of $GET)
     * @param string $itemID int, but represented as string (bc of $GET)
     * @param string $n int, but represented as string (bc of $GET)
     */
    public function run($shopID, $itemID, $n = "1") {
        /**
         * SYNTAX CHECKS
         */

        // shopID positive integer
        $validSyntax = (!empty($shopID)
                        && ctype_digit($shopID)
                        && $shopID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect(array('index'));
        }
        
        // itemID and n positive integer
        $validSyntax = (!empty($itemID)
                        && ctype_digit($itemID)
                        && $itemID > 0
                        && !empty($n)
                        && ctype_digit($n)
                        && $n > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect(array('shop', 'shopID' => $shopID));
        }

        /**
         * SANITY CHECKS
         */

        // Does the Shop exist?
        $Shop = Shop::model()->with(array(
            'shopItems' => array(
                'with' => 'item'
            )
        ))->findByPk($shopID);
        if(!is_a($Shop, "Shop")) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect(array('index'));
        }

        // Does the shop actually sell that item?
        // leaves $ShopItem at the right record
        $inStock = false;
        foreach($Shop->shopItems as $ShopItem) {
            if($ShopItem->item->id == $itemID) {
                $inStock = true;
                break;
            }
        }
        if(!$inStock) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect(array('shop', 'shopID' => $shopID));
        }

        // Is the Character allowed to enter that shop?
        $Character = CD();
        if(!$Shop->call("meetsRequirements", $Character)) {
            // Shop is responsible for generating a flash message
            $this->controller->redirect(array('index'));
        }
        
        // Does the Character have enough resources to buy the stuff?
        if($Character->cash < $ShopItem->cash * $n ||
                $Character->favours < $ShopItem->favours * $n ||
                $Character->kudos < $ShopItem->kudos * $n) {
            
            EUserFlash::setErrorMessage("You don't have enough resources to buy this.");
            $this->controller->redirect(array('shop', 'shopID' => $shopID));
        }
        
        /**
         * BEWARE: ACTUAL BUSINESS LOGIC 
         */
        
        $transaction = Yii::app()->tools->getTransaction();
        try {
            $Character->gainItem($ShopItem->item, $n);
            $Character->decreaseCash($ShopItem->cash * $n);
            $Character->decreaseFavours($ShopItem->favours * $n);
            $Character->decreaseKudos($ShopItem->kudos * $n);
            $Character->save();
       } catch(Exception $e) {
            $transaction->rollback();
            EUserFlash::setErrorMessage("Weird database shit happened.");
        }
                
        $this->controller->render("shop", array(
            "Shop" => $Shop,
        ));
    }
}