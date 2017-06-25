<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CategoryListener implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            \AppBundle\AppEvents:: CATEGORY_ADD => 'onCategoryAdd',
        );
    }

    public static function onCategoryAdd(\AppBundle\Event\GetCategoryEvent $event) {

        $category = $event->getCategory();
        echo $category->getTitle();
        die;
    }

}
