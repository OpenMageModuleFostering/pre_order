<?php

require_once 'Mage/Checkout/controllers/OnepageController.php';

class Vishwasnature_Preorder_IndexController extends Mage_Checkout_OnepageController {

    public function indexAction() {
        Mage::getSingleton('checkout/session')->setIsPreOrder(false);
        $cart = Mage::getModel('checkout/cart')->getQuote();
        $items = $cart->getAllItems();
        $ispreOrder = false;
        $isRegularOrder = false;
        foreach ($items as $item) {
            if($item->getParentItemId() == ''){
            if ($item->getProduct()->getPreOrder()) {
                    $ispreOrder = true;
                    Mage::getSingleton('checkout/session')->setIsPreOrder(true);
                }else{
                    $isRegularOrder = true;
                }
            }
        }
        if($ispreOrder){
            $cart->setData('pre_order',Vishwasnature_Preorder_Model_Observer::PRE_ORDER_EXIST_TRUE)->save();
        }else{
            $cart->setData('pre_order',Vishwasnature_Preorder_Model_Observer::PRE_ORDER_EXIST_FALSE)->save();
        }
        if($ispreOrder && $isRegularOrder){
            Mage::getSingleton('checkout/session')->addError("Orders cannot be mixed");
            $this->_redirect('checkout/cart');
            return;
        }
        parent::indexAction();
        
    }

}

?>