<?php

namespace AppBundle\Event;

use AppBundle\Entity\Product\Product;
use Symfony\Component\EventDispatcher\Event;


class GetProductEvent extends Event {

    private $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    /**
     * 
     * @return Product
     */
    public function getProduct() {
        return $this->product;
    }

}
