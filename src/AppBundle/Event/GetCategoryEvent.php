<?php

namespace AppBundle\Event;

use AppBundle\Entity\Product\Category;
use Symfony\Component\EventDispatcher\Event;

class GetCategoryEvent extends Event {

    private $category;

    public function __construct(Category $category) {
        $this->category = $category;
    }

    /**
     * 
     * @return \AppBundle\Entity\Product\Category
     */
    public function getCategory() {
        return $this->category;
    }

}
