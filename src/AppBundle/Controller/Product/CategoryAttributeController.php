<?php

namespace AppBundle\Controller\Product;

use AppBundle\Entity\Product\CategoryAttribute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AppController;

/**
 * Categoryattribute controller.
 *
 * @Route("product_categoryattribute")
 */
class CategoryAttributeController extends AppController {

    /**
     * Lists all categoryAttribute entities.
     *
     * @Route("/", name="product_categoryattribute_index")
     * @Method("GET")
     * @Template
     */
    public function indexAction(Request $request) {
        $dql = 'SELECT c FROM AppBundle:Product\CategoryAttribute c';
        $query = $this->getEm()->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $categoryAttribute = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 4/* limit per page */
        );

        return array(
            'categoryAttribute' => $categoryAttribute,
        );
    }

    /**
     * Creates a new categoryAttribute entity.
     *
     * @Route("/new", name="product_categoryattribute_new")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function newAction(Request $request) {
        $categoryAttribute = new Categoryattribute();
        $form = $this->createForm('AppBundle\Form\Product\CategoryAttributeType', $categoryAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoryAttribute);
            $em->flush();

            return $this->redirectToRoute('product_categoryattribute_show', array('id' => $categoryAttribute->getId()));
        }

        return array(
            'categoryAttribute' => $categoryAttribute,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a categoryAttribute entity.
     *
     * @Route("/{id}", name="product_categoryattribute_show")
     * @Method("GET")
     * @Template
     */
    public function showAction(CategoryAttribute $categoryAttribute) {
        $deleteForm = $this->createDeleteForm($categoryAttribute);

        return array(
            'categoryAttribute' => $categoryAttribute,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/just_show/{id}", name="product_categoryattribute_just_show")
     * @Method("GET")
     * @Template
     */
    public function justShowAction(CategoryAttribute $categoryAttribute) {
        $deleteForm = $this->createDeleteForm($categoryAttribute);

        return array(
            'categoryAttribute' => $$categoryAttribute,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing categoryAttribute entity.
     *
     * @Route("/{id}/edit", name="product_categoryattribute_edit")
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('edit', categoryAttribute)")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function editAction(Request $request, CategoryAttribute $categoryAttribute) {
        $deleteForm = $this->createDeleteForm($categoryAttribute);
        $editForm = $this->createForm('AppBundle\Form\Product\CategoryAttributeType', $categoryAttribute);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_categoryattribute_edit', array('id' => $categoryAttribute->getId()));
        }

        return array(
            'categoryAttribute' => $categoryAttribute,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a categoryAttribute entity.
     *
     * @Route("/{id}", name="product_categoryattribute_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CategoryAttribute $categoryAttribute) {
        $form = $this->createDeleteForm($categoryAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categoryAttribute);
            $em->flush();
        }

        return $this->redirectToRoute('product_categoryattribute_index');
    }

    /**
     * Creates a form to delete a categoryAttribute entity.
     *
     * @param CategoryAttribute $categoryAttribute The categoryAttribute entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategoryAttribute $categoryAttribute) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('product_categoryattribute_delete', array('id' => $categoryAttribute->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
