<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Species;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Species controller.
 *
 * @Route("species")
 */
class SpeciesController extends Controller
{
    /**
     * Lists all species entities.
     *
     * @Route("/", name="species_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $species = $em->getRepository('AppBundle:Species')->findAll();

        return $this->render('species/index.html.twig', array(
            'species' => $species,
        ));
    }

    /**
     * Creates a new species entity.
     *
     * @Route("/new", name="species_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $species = new Species();
        $form = $this->createForm('AppBundle\Form\SpeciesType', $species);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($species);
            $em->flush();

            return $this->redirectToRoute('species_show', array('id' => $species->getId()));
        }

        return $this->render('species/new.html.twig', array(
            'species' => $species,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a species entity.
     *
     * @Route("/{id}", name="species_show")
     * @Method("GET")
     */
    public function showAction(Species $species)
    {
        $deleteForm = $this->createDeleteForm($species);

        return $this->render('species/show.html.twig', array(
            'species' => $species,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing species entity.
     *
     * @Route("/{id}/edit", name="species_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Species $species)
    {
        $deleteForm = $this->createDeleteForm($species);
        $editForm = $this->createForm('AppBundle\Form\SpeciesType', $species);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('species_edit', array('id' => $species->getId()));
        }

        return $this->render('species/edit.html.twig', array(
            'species' => $species,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a species entity.
     *
     * @Route("/{id}", name="species_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Species $species)
    {
        $form = $this->createDeleteForm($species);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($species);
            $em->flush();
        }

        return $this->redirectToRoute('species_index');
    }

    /**
     * Creates a form to delete a species entity.
     *
     * @param Species $species The species entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Species $species)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('species_delete', array('id' => $species->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
