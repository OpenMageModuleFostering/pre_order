<?php

class Vishwasnature_Preorder_Model_Observer {

    const PRE_ORDER_EXIST_TRUE = 1;
    const PRE_ORDER_EXIST_FALSE = 0;
    const STATE_PENDING_PREORDER = 'pending_pre_order';

    public function checkProductType(Varien_Event_Observer $observer) {
        $mainProductId = Mage::app()->getRequest()->getParam('product');
        $newItem = $observer->getEvent()->getQuoteItem();
        $ispreOrder = false;
        $cart = Mage::getModel('checkout/cart')->getQuote();
        $items = $cart->getAllItems();
        $countItem = 0;
        foreach ($items as $item) {
            if ($item->getId()) {
                    $countItem++;
                    if ($item->getProduct()->getPreOrder()) {
                        $ispreOrder = true;
                    }
            }
        }
        if ($countItem > 0) {
            if($mainProductId != $newItem->getProduct()->getId()){
                $mainProductPreOrderExist = Mage::getModel('catalog/product')->load($mainProductId)->getPreOrder();
                if($mainProductPreOrderExist != $ispreOrder){
                    $response['status'] = 'ERROR';
                    $response['flag'] = 1;
                    $response['message'] = '<p>Sorry, cannot mix regular & pre-order order products.</p>';

                    Mage::getSingleton('core/session')->addError('<p>Sorry, cannot mix regular & pre-order order products.</p>');
                    $url = Mage::getModel('core/url')->getUrl('checkout/cart/index');
                    Mage::app()->getResponse()->setRedirect($url);
                    Mage::app()->getResponse()->sendResponse();
                    exit;
                }
            }else{
            if ($newItem->getProduct()->getPreOrder() != $ispreOrder) {
                $response['status'] = 'ERROR';
                $response['flag'] = 1;
                $response['message'] = '<p>Sorry, cannot mix regular & pre-order order products.</p>';

                Mage::getSingleton('core/session')->addError('<p>Sorry, cannot mix regular & pre-order order products.</p>');
                $url = Mage::getModel('core/url')->getUrl('checkout/cart/index');
                Mage::app()->getResponse()->setRedirect($url);
                Mage::app()->getResponse()->sendResponse();
                exit;
            }
            }
        }
    }

//    public function setCustomOrderStatus($observer) {
//        $order = $observer->getEvent()->getOrder();
//        if($order->getPreOrder() == self::PRE_ORDER_EXIST_TRUE){
//        $order->setState('new', true);        
//        $order->setStatus(self::STATE_PENDING_PREORDER, true);        
//        $order->save();
//        }
//    }
    public function getOrderTypes() {
        return array(0 => 'Regular', 1 => 'Pre-Order');
    }

    public function salesQuoteItemSetCustomAttribute($observer) {
        $quoteItem = $observer->getQuoteItem();
        $product = $observer->getProduct();

        $quoteItem->setPreOrder($product->getPreOrder());
        $quoteItem->setPreOrderNote($product->getPreOrderNote());
    }

}

?>