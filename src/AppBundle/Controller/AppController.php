<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller {

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm() {
        return $this->getDoctrine()->getManager();
    }

    /**
     * 
     * @return \AppBundle\Entity\User
     */
    public function getUser() {
        return parent::getUser();
    }

    /**
     * 
     * @return Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher
     */
    protected function getDispatcher() {
        return $this->get("event_dispatcher");
    }

}
