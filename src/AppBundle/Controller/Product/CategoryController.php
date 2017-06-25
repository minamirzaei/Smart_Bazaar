<?php

namespace AppBundle\Controller\Product;

use AppBundle\Controller\AppController;
use AppBundle\Entity\Product\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @Route("product_category")
 */
class CategoryController extends AppController {

    /**
     * Lists all category entities.
     *
     * @Route("/", name="product_category_index")
     * @Method("GET")
     * @Template
     */
    public function indexAction(Request $request) {
        $dql = 'SELECT c FROM AppBundle:Product\Category c';
        $query = $this->getEm()->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $categories = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 8/* limit per page */
        );

        return array(
            'categories' => $categories,
        );
    }

    /**
     * Creates a new category entity.
     *
     * @Route("/new", name="product_category_new")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function newAction(Request $request) {
        $category = new Category();
        $form = $this->createForm('AppBundle\Form\Product\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('product_category_show', array('id' => $category->getId()));
        }

        return array(
            'category' => $category,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/{id}", name="product_category_show")
     * @Method("GET")
     * @Template
     */
    public function showAction(Category $category) {
        $deleteForm = $this->createDeleteForm($category);

        return array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/just_show/{id}", name="product_category_just_show")
     * @Method("GET")
     * @Template
     */
    public function justShowAction(Category $category) {
        $deleteForm = $this->createDeleteForm($category);

        return array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{id}/edit", name="product_category_edit")
     * @Method({"GET", "POST"})
     * @Template
     */
    public function editAction(Request $request, Category $category) {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('AppBundle\Form\Product\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_category_edit', array('id' => $category->getId()));
        }

        return array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="product_category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category) {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('product_category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Category $category) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('product_category_delete', array('id' => $category->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
