<?php

namespace Support\SupportBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Support\SupportBundle\Entity\DocmanContenido;
use Support\SupportBundle\Entity\DocmanTipoContenido;
use Support\SupportBundle\Form\DocmanContenidoType;
use Support\SupportBundle\Entity\Tipusr;

/**
 * DocmanContenido controller.
 *
 */
class DocmanContenidoController extends Controller {

    /**
     * Lists all DocmanContenido entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');

        $entities = $em->getRepository('SupportBundle:DocmanContenido')->findAll();
        $t = $this->getTotasSolicitudesAtendidas();
        $totalSolicitudesAtendidas = array(
            'n' => $t,
            'p' => round((100 * ($this->getTotasSolicitudesAtendidas())) / $this->getTotasSolicitudes())
        );
        return $this->render('SupportBundle:DocmanContenido:index.html.twig', array(
                    'entities' => $entities,
                    'user' => $u,
                    'totalSolicitudes' => $this->getTotasSolicitudes(),
                    'totalSolicitudesAtendidas' => $totalSolicitudesAtendidas,
                    'menu' => $this->getMenu(),
                    'active' => $this->get('support.active')->getActive($session),
        ));
    }

    private function getTotasSolicitudesAtendidas() {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT count(p) 
                  FROM SupportBundle:DocmanSolicitud p
                  WHERE p.estado=1');
        $totalSolicitudes = $q->getResult();
        if (count($totalSolicitudes) > 0) {
            return $totalSolicitudes[0][1];
        }
        return 0;
    }

    private function getTotasSolicitudes() {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT count(p) 
                  FROM SupportBundle:DocmanSolicitud p');
        $totalSolicitudes = $q->getResult();
        if (count($totalSolicitudes) > 0) {
            return $totalSolicitudes[0][1];
        }
        return 0;
    }

    /**
     * Creates a new DocmanContenido entity.
     *
     */
    public function createAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');
        $em = $this->getDoctrine()->getManager();
        $entity = new DocmanContenido();
        $tipo = new DocmanTipoContenido();
        $f = $request->get('support_supportbundle_docmancontenido');
        $tipo = $em->getRepository('SupportBundle:DocmanTipoContenido')->find($f['tipo']);
        $t = $em->getRepository('SupportBundle:DocmanUser')->find($u->getId());
        $entity->setDescripcion($f['descripcion']);
        $entity->setTitulo($f['titulo']);
        $entity->setUrl($f['url']);
        $entity->setTipo($tipo);
        $entity->setUsuario($u);
        $entity->setFechaPub(new \DateTime());
        $entity->setFechaLimite(new \DateTime());
        $entity->setUsuario($t);
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('docmancontenido_show', array('id' => $entity->getId())));
    }

    /**
     * Creates a form to create a DocmanContenido entity.
     *
     * @param DocmanContenido $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DocmanContenido $entity) {
        $form = $this->createForm(new DocmanContenidoType(), $entity, array(
            'action' => $this->generateUrl('docmancontenido_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new DocmanContenido entity.
     *
     */
    public function newAction() {
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');
        $entity = new DocmanContenido();
        $form = $this->createCreateForm($entity);
        $t = $this->getTotasSolicitudesAtendidas();
        $totalSolicitudesAtendidas = array(
            'n' => $t,
            'p' => round((100 * ($this->getTotasSolicitudesAtendidas())) / $this->getTotasSolicitudes())
        );
        return $this->render('SupportBundle:DocmanContenido:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'user' => $u,
                    'totalSolicitudes' => $this->getTotasSolicitudes(),
                    'totalSolicitudesAtendidas' => $totalSolicitudesAtendidas,
                    'menu' => $this->getMenu(),
                    'active' => $this->get('support.active')->getActive($session),
        ));
    }

    /**
     * Finds and displays a DocmanContenido entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');
        $entity = $em->getRepository('SupportBundle:DocmanContenido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocmanContenido entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $t = $this->getTotasSolicitudesAtendidas();
        $totalSolicitudesAtendidas = array(
            'n' => $t,
            'p' => round((100 * ($this->getTotasSolicitudesAtendidas())) / $this->getTotasSolicitudes())
        );
        return $this->render('SupportBundle:DocmanContenido:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                    'user' => $u,
                    'totalSolicitudes' => $this->getTotasSolicitudes(),
                    'totalSolicitudesAtendidas' => $totalSolicitudesAtendidas,
                    'menu' => $this->getMenu(),
                    'active' => $this->get('support.active')->getActive($session),
        ));
    }

    /**
     * Displays a form to edit an existing DocmanContenido entity.
     *
     */
    public function editAction($id) {
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SupportBundle:DocmanContenido')->find($id);
        $formulario = $this->CreateFormBuilder($entity)
                ->add('id', 'hidden', array('data' => $id))
                ->add('titulo')
                ->add('descripcion', 'textarea')
                ->add('url')
                ->getForm();
        $t = $this->getTotasSolicitudesAtendidas();
        $totalSolicitudesAtendidas = array(
            'n' => $t,
            'p' => round((100 * ($this->getTotasSolicitudesAtendidas())) / $this->getTotasSolicitudes())
        );
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('SupportBundle:DocmanContenido:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $formulario->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'user' => $u,
                    'totalSolicitudes' => $this->getTotasSolicitudes(),
                    'totalSolicitudesAtendidas' => $totalSolicitudesAtendidas,
                    'menu' => $this->getMenu(),
                    'active' => $this->get('support.active')->getActive($session),
        ));
    }

    /**
     * Creates a form to edit a DocmanContenido entity.
     *
     * @param DocmanContenido $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DocmanContenido $entity) {
        $form = $this->createForm(new DocmanContenidoType(), $entity, array(
            'action' => $this->generateUrl('docmancontenido_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing DocmanContenido entity.
     *
     */
    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $f = $request->get('form');
        $entity = $em->getRepository('SupportBundle:DocmanContenido')->find($f['id']);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocmanContenido entity.');
        }
        $deleteForm = $this->createDeleteForm($f['id']);
        $formulario = $this->CreateFormBuilder($entity)
                ->add('id')
                ->add('titulo')
                ->add('descripcion')
                ->add('url')
                ->getForm();
        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('docmancontenido_edit', array('id' => $f['id'])));
        }

        return $this->render('SupportBundle:DocmanContenido:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DocmanContenido entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SupportBundle:DocmanContenido')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DocmanContenido entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('docmancontenido'));
    }

    /**
     * Creates a form to delete a DocmanContenido entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('docmancontenido_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar'))
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
