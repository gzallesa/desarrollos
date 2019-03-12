<?php

namespace Support\SupportBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Support\SupportBundle\Entity\DocmanUser;
use Support\SupportBundle\Form\DocmanUserType;

/**
 * DocmanUser controller.
 *
 */
class DocmanUserController extends Controller
{

    /**
     * Lists all DocmanUser entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SupportBundle:DocmanUser')->findAll();

        return $this->render('SupportBundle:DocmanUser:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DocmanUser entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DocmanUser();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('docmanuser_show', array('id' => $entity->getId())));
        }

        return $this->render('SupportBundle:DocmanUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a DocmanUser entity.
    *
    * @param DocmanUser $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(DocmanUser $entity)
    {
        $form = $this->createForm(new DocmanUserType(), $entity, array(
            'action' => $this->generateUrl('docmanuser_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DocmanUser entity.
     *
     */
    public function newAction()
    {
        $entity = new DocmanUser();
        $form   = $this->createCreateForm($entity);

        return $this->render('SupportBundle:DocmanUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DocmanUser entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SupportBundle:DocmanUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocmanUser entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SupportBundle:DocmanUser:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing DocmanUser entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SupportBundle:DocmanUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocmanUser entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SupportBundle:DocmanUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DocmanUser entity.
    *
    * @param DocmanUser $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DocmanUser $entity)
    {
        $form = $this->createForm(new DocmanUserType(), $entity, array(
            'action' => $this->generateUrl('docmanuser_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DocmanUser entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SupportBundle:DocmanUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocmanUser entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('docmanuser_edit', array('id' => $id)));
        }

        return $this->render('SupportBundle:DocmanUser:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DocmanUser entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SupportBundle:DocmanUser')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DocmanUser entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('docmanuser'));
    }

    /**
     * Creates a form to delete a DocmanUser entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('docmanuser_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
