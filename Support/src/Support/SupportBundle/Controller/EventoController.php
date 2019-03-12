<?php

namespace Support\SupportBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Support\SupportBundle\Entity\Evento;
use Support\SupportBundle\Form\EventoType;
use Support\SupportBundle\Entity\DocmanTipoContenido;
use Symfony\Component\HttpFoundation\Session\Session;
use Support\SupportBundle\Entity\Tipusr;
/**
 * Evento controller.
 *
 */
class EventoController extends Controller {

    /**
     * Lists all Evento entities.
     *
     */
    public function getContenidos() {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT c
                 FROM SupportBundle:DocmanTipoContenido c');
        return $q->getResult();
    }

    public function indexAction() {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();
            $p = $this->getContenidos();
            $entities = $em->getRepository('SupportBundle:Evento')->findAll();
            return $this->render('SupportBundle:Evento:index.html.twig', array(
                        'entities' => $entities,
                        'contenidos' => $p,
                        'active' => $this->get('support.active')->getActive($session),
                        'name' => 'Nuevo Evento',
                        'usuario' => $session->get('support'),
                        'menu' => $this->getMenu(),
            ));
        }
    }

    /**
     * Creates a new Evento entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Evento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setPublic('1');
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                    'info', 'Se han guardado los cambios..'
            );
            return $this->redirect($this->generateUrl('evento_show', array('id' => $entity->getId())));
        }
        return $this->render('SupportBundle:Evento:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Evento entity.
     *
     * @param Evento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Evento $entity) {
        $form = $this->createForm(new EventoType(), $entity, array(
            'action' => $this->generateUrl('evento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear', 'attr' => array('class' => 'btn icon-button')));

        return $form;
    }

    /**
     * Displays a form to create a new Evento entity.
     *
     */
    public function newAction() {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $entity = new Evento();
            $form = $this->createCreateForm($entity);
            $p = $this->getContenidos();
            return $this->render('SupportBundle:Evento:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
                        'contenidos' => $p,
                        'active' => $this->get('support.active')->getActive($session),
                        'name' => 'Nuevo Evento',
                        'usuario' => $session->get('support'),
                        'menu' => $this->getMenu(),
                        'active' => $this->getMenu(),
            ));
        }
    }

    /**
     * Finds and displays a Evento entity.
     *
     */
    public function showAction($id) {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SupportBundle:Evento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Evento entity.');
            }
            $p = $this->getContenidos();
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('SupportBundle:Evento:show.html.twig', array(
                        'entity' => $entity,
                        'delete_form' => $deleteForm->createView(),
                        'contenidos' => $p,
                        'active' => $this->get('support.active')->getActive($session),
                        'name' => 'Evento',
                        'usuario' => $session->get('support'),
                        'menu' => $this->getMenu(),
                        'active' => $this->getMenu(),
            ));
        }
    }

    /**
     * Displays a form to edit an existing Evento entity.
     *
     */
    public function editAction($id) {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('SupportBundle:Evento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Evento entity.');
            }
            $p = $this->getContenidos();
            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('SupportBundle:Evento:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
                        'contenidos' => $p,
                        'active' => $this->get('support.active')->getActive($session),
                        'name' => 'Modificar evento',
                        'usuario' => $session->get('support'),
                        'menu' => $this->getMenu(),
                        'active' => $this->getMenu(),
            ));
        }
    }

    /**
     * Creates a form to edit a Evento entity.
     *
     * @param Evento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Evento $entity) {
        $form = $this->createForm(new EventoType(), $entity, array(
            'action' => $this->generateUrl('evento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'attr' => array('class' => 'btn icon-button')));

        return $form;
    }

    /**
     * Edits an existing Evento entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SupportBundle:Evento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                    'info', 'Se han guardado los cambios..'
            );
            return $this->redirect($this->generateUrl('evento_edit', array('id' => $id)));
        }
        return $this->render('SupportBundle:Evento:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Evento entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SupportBundle:Evento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Evento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('evento'));
    }

    /**
     * Creates a form to delete a Evento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('evento_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'btn icon-button')))
                        ->getForm()
        ;
    }
    private function getMenu() {
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');
        $tu = new Tipusr();
        $em = $this->getDoctrine()->getManager();
        $p = $em->createQuery(
                        'SELECT t.id,t.nombre,t.descripcion
                 FROM SupportBundle:Tipusr p JOIN p.tipo t
                 WHERE p.usuario=:id
                 ')->setParameter('id', $u->getId());
        $tu = $p->getResult();
        return $tu;
    }
}
