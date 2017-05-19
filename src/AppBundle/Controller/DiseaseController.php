<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Disease;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Disease controller.
 *
 * @Route("disease")
 */
class DiseaseController extends Controller
{
    /**
     * Lists all disease entities.
     *
     * @Route("/", name="disease_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $diseases = $em->getRepository('AppBundle:Disease')->findAll();

        return $this->render('disease/index.html.twig', array(
            'diseases' => $diseases,
        ));
    }

    /**
     * Creates a new disease entity.
     *
     * @Route("/new", name="disease_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $disease = new Disease();
        $form = $this->createForm('AppBundle\Form\DiseaseType', $disease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($disease);
            $em->flush();

            return $this->redirectToRoute('disease_show', array('id' => $disease->getId()));
        }

        return $this->render('disease/new.html.twig', array(
            'disease' => $disease,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a disease entity.
     *
     * @Route("/{id}", name="disease_show")
     * @Method("GET")
     */
    public function showAction(Disease $disease)
    {
        $deleteForm = $this->createDeleteForm($disease);

        return $this->render('disease/show.html.twig', array(
            'disease' => $disease,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing disease entity.
     *
     * @Route("/{id}/edit", name="disease_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Disease $disease)
    {
        $deleteForm = $this->createDeleteForm($disease);
        $editForm = $this->createForm('AppBundle\Form\DiseaseType', $disease);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disease_edit', array('id' => $disease->getId()));
        }

        return $this->render('disease/edit.html.twig', array(
            'disease' => $disease,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a disease entity.
     *
     * @Route("/{id}", name="disease_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Disease $disease)
    {
        $form = $this->createDeleteForm($disease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($disease);
            $em->flush();
        }

        return $this->redirectToRoute('disease_index');
    }

    /**
     * Creates a form to delete a disease entity.
     *
     * @param Disease $disease The disease entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Disease $disease)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('disease_delete', array('id' => $disease->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
