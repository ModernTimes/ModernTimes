<?php
/**
 * Displays shops and their stock
 * 
 * @uses shop.php view file
 * @package Actions.Shopping
 */

class ShopAction extends CAction {

    /**
     * Renders the shop's view file 
     */
    public function run($shopID) {
        // positive integer
        $validSyntax = (!empty($shopID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($shopID)
                        && $shopID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
            $this->controller->redirect(array('index'));
        } else {
            $Shop = Shop::model()->with(array(
                'shopItems' => array(
                    'with' => array(
                        'item' => array(
                            'with' => array(
                                'charactermodifier',
                                'useEffect'
                            )
                        )
                    )
                 )
            ))->findByPk($shopID);
            
            if(!is_a($Shop, "Shop")) {
                EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
                $this->controller->redirect(array('index'));
            } else {
                $Character = CD();
                
                if(!$Shop->call("meetsRequirements", $Character)) {
                    // RequirementCheckerBehavior generates messages
                    $this->controller->redirect(array('index'));
                } else {
                    
                    $this->controller->render("shop", array(
                        "Shop" => $Shop,
                    ));
                }
            }
        }
    }
}