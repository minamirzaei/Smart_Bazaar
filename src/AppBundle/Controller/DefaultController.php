<?php

namespace AppBundle\Controller;

use AppBundle\Controller\AppController;
use AppBundle\Entity\Product\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Home controller.
 *
 * @Route("/")
 */
class DefaultController extends AppController {

    /**
     * Lists all product entities.
     *
     * @Route("/", name="home_index")
     * @Template
     */
    public function indexAction(Request $request) {
        $dql = 'SELECT p FROM AppBundle:Product\Product p';
        $query = $this->getEm()->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 4/* limit per page */
        );

        $QuicView = $this->getEm()->getRepository('AppBundle:Product\ImageProduct')->findByType("quick_view");
        $SlidShow = $this->getEm()->getRepository('AppBundle:Product\ImageProduct')->findByType("slide_show");
        $FallLeft = $this->getEm()->getRepository('AppBundle:Product\ImageProduct')->findByType("fall-left");
        $FeelRight = $this->getEm()->getRepository('AppBundle:Product\ImageProduct')->findByType("feel-right");

        return array(
            'products' => $products,
            'image' => $QuicView,
            'SlidShow' => $SlidShow,
            "FallLeft" => $FallLeft,
            "FeelRight" => $FeelRight,
        );
    }

    /**
     * make admin role.
     *
     * @Route("/single", name="home_single")
     * @Template
     */
    public function singleAction(Request $request) {


        return array(
        );
    }

    /**
     * make admin role.
     *
     * @Route("/makeadmin", name="make_admin")
     * @Template
     */
    public function makeAdminAction(Request $request) {
        $user = $this->getUser();
        $roles = $user->getRoles();
        var_dump($roles);
        $roles = ["ROLE_SUPER_ADMIN"];
        $user->setRoles($roles);
        $this->getEm()->flush();
        die;
    }

}
