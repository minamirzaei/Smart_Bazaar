<?php

namespace AppBundle\Controller\Product;

use AppBundle\Controller\AppController;
use AppBundle\Entity\Product\Product;
use AppBundle\Event\GetProductEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("product_product")
 */
class ProductController extends AppController {

    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_product_index")
     * @Method("GET")
     * @Template
     */
    public function indexAction(Request $request) {
        //$dql = 'SELECT p FROM AppBundle:Product\Product p'; //********************knp dql*****************************
        //  $dql = "SELECT i FROM AppBundle:Product\ImageProduct i  WHERE i.type='admin_page'";
        // $dql = "SELECT p, i FROM AppBundle:Product\Product p JOIN p.imageProducts i WHERE i.type= 'admin_page'";
        $dql = "SELECT p, i FROM AppBundle:Product\Product p JOIN p.imageProducts i WHERE i.type= 'admin_page'";
        //   $query = $this->getEm()->getRepository('AppBundle:Product\Product')->findBy(array('imagProducts' => '1'),array('name' => 'ASC'));
        // $query = $this->getEm()->getRepository('AppBundle:Product\Product')->findAll();
        //  $query = $this->getEm()->getRepository('AppBundle:Product\Category')->findAll();   
        // $query = $this->getEm()->getRepository('AppBundle:Product\ImageProduct')->findByType('admin_page');
//        $query = $this->getEm()->getRepository('AppBundle:Product\ImageProduct')->findByType('admin_page');
//        var_dump($query);
//        die();
        $query = $this->getEm()->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 12/* limit per page */
        );
//        var_dump($products);
//        die();
        return array(
            'products' => $products,
        );
    }

//    /**
//     * Lists all product entities.
//     *
//     * @Route("/", name="product_product_index")
//     * @Method("GET")
//     * @Template
//     */
//    public function indexAction(Request $request) {
//        $dql = 'SELECT p FROM AppBundle:Product\Product p';
//        $query = $this->getEm()->createQuery($dql);
//
//        $paginator = $this->get('knp_paginator');
//        $products = $paginator->paginate(
//                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 4/* limit per page */
//        );
//
//        return array(
//            'products' => $products,
//        );
//    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="product_product_new")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function newAction(Request $request) {
        $product = new Product();
        $form = $this->createForm('AppBundle\Form\Product\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();


            /**             * ***************Event Dispatcher********************************* */
            $this->getDispatcher()->dispatch(\AppBundle\AppEvents::PRODUCT_ADD, new GetProductEvent($product));
            $this->addFlash("notice", "product has been added");


            return $this->redirectToRoute('product_product_show', array('id' => $product->getId()));



//            array('id' => $product->getId(),
//            'id' => $product->getId(),
//            'form' => $form->createView(),    
//            'product' => $product,
//            );
        }

        return array(
            'product' => $product,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_product_show")
     * @Method("GET")
     * @Template
     */
    public function showAction(Product $product) {
        $deleteForm = $this->createDeleteForm($product);

        return array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/just_show/{id}", name="product_product_just_show")
     * @Method("GET")
     * @Template
     */
    public function justShowAction(Product $product) {
        $deleteForm = $this->createDeleteForm($product);

        return array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_product_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('edit', product)")
     * @Template
     */
    public function editAction(Request $request, Product $product) {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\Product\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            /**             * ***************Event Dispatcher********************************* */
            $this->getDispatcher()->dispatch(\AppBundle\AppEvents::PRODUCT_EDIT, new GetProductEvent($product));
            $this->addFlash("notice", "product has been edit");



            return $this->redirectToRoute('product_product_show', array('id' => $product->getId()));
//            return array('id' => $product->getId()
//                ,
//                'edit_form' => $editForm->createView(),
//                'delete_form' => $deleteForm->createView(),
//            );
        }

        return array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product) {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Product $product) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('product_product_delete', array('id' => $product->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
