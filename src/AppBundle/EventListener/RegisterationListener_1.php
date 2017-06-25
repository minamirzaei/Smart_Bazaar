<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RegistrationListener implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return [

            FOSUserEvents::REGISTRATION_CONFIRMED => 'onRegistrationCompleted'
        ];
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event) {
        $respons = $event->getResponse();
        echo "Good Work";
        die;
    }

}
