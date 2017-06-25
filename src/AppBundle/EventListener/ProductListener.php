<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductListener implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return [
            \AppBundle\AppEvents::PRODUCT_ADD => 'onProductAdd',
            \AppBundle\AppEvents::PRODUCT_EDIT => 'onProductEdit',
        ];
    }

    public function onProductAdd(\AppBundle\Event\GetProductEvent $event) {
        $product = $event->getProduct();
//        echo " " . "you have added a new product as " . " " . $product->getName();
//        die;
    }

    public function onProductEdit(\AppBundle\Event\GetProductEvent $event) {
        $product = $event->getProduct();
//        echo " " . "you have edited a product as " . " " . $product->getName();
//        die;
    }

}
