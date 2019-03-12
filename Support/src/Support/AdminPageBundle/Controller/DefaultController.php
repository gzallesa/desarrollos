<?php

namespace Support\AdminPageBundle\Controller;

use Support\SupportBundle\Entity\DocmanContenido;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Support\AdminPageBundle\Form\ContenidoType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;
use Support\SupportBundle\Entity\DocmanTipoContenido;
use Support\SupportBundle\Entity\DocmanUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Support\SupportBundle\Entity\Tipusr;
use Support\SupportBundle\Entity\DocmanOficina;

class DefaultController extends Controller
{

    public function indexAction($t)
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $path = $this->getPath($t);
            if ($path) {
                $this->get('support.active')->setActive($t);
                return $this->redirect($this->generateUrl($path[0]->getPath()));
            } else {
                return $this->render('AdminPageBundle:Default:index.html.twig', array(
                    'active' => $t,
                    'usuario' => $session->get('support'),
                    'menu' => $this->getMenu(),
                ));
            }
        }
    }

    public function getContenidos()
    {
        $em = $this->getDoctrine()->getManager();
        $p = new DocmanTipoContenido();
        $q = $em->createQuery(
            'SELECT c
                 FROM SupportBundle:DocmanTipoContenido c');
        return $q->getResult();
    }

    public function comunicadoAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();
            $usuario = new DocmanUser();
            $usuario = $em->createQuery(
                'SELECT p
                  FROM SupportBundle:DocmanUser p JOIN p.oficina o
                  WHERE o.id=:ido
                  order by p.name');
            $usuario->setParameter('ido', $session->get('support')->getOficina()->getId());
            $usuarios = $usuario->getResult();
            $contenido = new DocmanContenido();
            $formulario = $this->CreateFormBuilder($contenido)
                ->add('tipo', 'hidden', array('data' => '2'))
                ->add('titulo', 'text', array('max_length' => '45'))
                ->add('descripcion', 'textarea')
                ->add('url', 'file', array('required' => FALSE))
                ->add('fechaLimite', 'datetime', array('data' => new \DateTime("now")))
                ->getForm();
            $contenidos = $this->getContenidos();
            return $this->render('AdminPageBundle:Default:comunicado.html.twig', array(
                'formulario' => $formulario->createView(),
                'usuarios' => $usuarios,
                'contenidos' => $contenidos,
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Nuevo comunicado',
                'menu' => $this->getMenu(),
                'usuario' => $session->get('support'),
            ));
        }
    }

    // [INICIO] CREACION, EDICION Y ELIMINACION DE POPUPS
    public function popupPanelAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $sql_popup_intranet = " SELECT 
                                        *
                                    FROM
                                        docman.docman_intranet_popup
                                    ORDER BY ID DESC;";

            $em_popup_intranet = $this->getDoctrine()->getManager();
            $stmt_popup_intranet = $em_popup_intranet->getConnection()->prepare($sql_popup_intranet);
            $stmt_popup_intranet->execute();

            return $this->render('AdminPageBundle:Default:popup_panel.html.twig', array(
                'news' => $stmt_popup_intranet->fetchAll(),
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Popups',
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function createPopupAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();
            $usuario = new DocmanUser();
            $usuario = $em->createQuery(
                'SELECT p
                  FROM SupportBundle:DocmanUser p JOIN p.oficina o
                  WHERE o.id=:ido
                  order by p.name');
            $usuario->setParameter('ido', $session->get('support')->getOficina()->getId());
            $usuarios = $usuario->getResult();
            $contenido = new DocmanContenido();
            $formulario = $this->CreateFormBuilder($contenido)
                ->add('titulo', 'text', array('max_length' => '45'))
                ->add('fechaLimite', 'datetime', array('data' => new \DateTime("now")))
                ->add('url', 'file', array('required' => FALSE))
                ->getForm();
            $contenidos = $this->getContenidos();
            return $this->render('AdminPageBundle:Default:popup.html.twig', array(
                'formulario' => $formulario->createView(),
                'usuarios' => $usuarios,
                'contenidos' => $contenidos,
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Nuevo Popup',
                'menu' => $this->getMenu(),
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function guardarPopupAction()
    {

        /*
                $peticion = $this->getRequest();
                $contenido = new DocmanContenido();
                $idu = $peticion->get('usuario');
                if (empty($idu)) {
                    $this->get('session')->getFlashBag()->add(
                            'warning', 'No selecciono al emisor. o el archivo es demasiado grande'
                    );
                    return $this->redirect($this->generateUrl('admin_page_Comunicado'));
                }
                $msg = '';
                $formulario = $this->CreateFormBuilder($contenido)
                        ->add('url', 'file')
                        ->add('titulo')
                        ->add('tipo', 'entity', array(
                            'class' => 'SupportBundle:DocmanTipoContenido',
                            'property' => 'id',
                        ))
                        ->add('descripcion')
                        ->add('fechaLimite')
                        ->getForm();
                $formulario->handleRequest($peticion);
                $usuario = new DocmanUser();
                $usuario = $this->getUserById($idu);
                $em = $this->getDoctrine()->getManager();
                $contenido->setFechaPub(new \DateTime());
                $contenido->setUsuario($usuario[0]);
                if ($formulario['url']->getData() != NULL) {
                    $re = $formulario['url']->getData()->move(__DIR__ . '/../../../../web/uploads/', $formulario['url']->getData()->getClientOriginalName());
                    $contenido->setUrl($formulario['url']->getData()->getClientOriginalName());
                } else {
                    $this->get('session')->getFlashBag()->add(
                            'info', 'No se cargo ni un archivo...'
                    );
                }
                $this->sendMail('personal@oopp.gob.bo', $contenido->getDescripcion(), $contenido->getTitulo(), $contenido->getUrl(),$contenido);
                $em->persist($contenido);
                $em->flush();
                //exit();
                $this->get('session')->getFlashBag()->add(
                        'info', 'Se han guardado los cambios..'
                );
        */


        $base_url = '';
        if ($_SERVER['HTTPS']) {
            $base_url = 'https://' . $_SERVER['SERVER_NAME'];
        } else {
            $base_url = 'http://' . $_SERVER['SERVER_NAME'];
        }
        $peticion = $this->getRequest();
        $titulo_popup = $peticion->get('titulo_popup');
        $fecha_publicacion_popup = $peticion->get('fecha_publicacion_popup');
        $dias_popup = $peticion->get('dias_popup');
        $file = $peticion->files->get('file_popup');
        $fileName = $peticion->files->get('file_popup')->getClientOriginalName();
        $fileName = date('Y-m-d_H:i:s') . '__' . $fileName;

        $upload_file = $file->move(__DIR__ . '/../../../../web/uploads/', $fileName);
        //$peticion->moveFile('file_popup', sfConfig::get(__DIR__ . '/../../../../web/uploads/' . $fileName);
        $image_url = $base_url . "/uploads/" . $fileName;

        $sql_popup_intranet = " INSERT INTO docman.docman_intranet_popup (Titulo, Estado, Fecha_Creacion, Fecha_Publicar, image_url, dias, Texto) VALUES ('$titulo_popup', '1', NOW(), '$fecha_publicacion_popup', '$image_url', '$dias_popup', '');";

        $em_popup_intranet = $this->getDoctrine()->getManager();
        $stmt_popup_intranet = $em_popup_intranet->getConnection()->prepare($sql_popup_intranet);
        $stmt_popup_intranet->execute();

        return $this->redirect($this->generateUrl('admin_page_popupPanel'));
    }

    public function getPopupAction($id)
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            /*
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->createQuery(
                'SELECT p
                  FROM SupportBundle:DocmanUser p JOIN p.oficina o
                  WHERE o.id=:ido
                  order by p.name');
            $usuario->setParameter('ido', $session->get('support')->getOficina()->getId());
            $usuarios = $usuario->getResult();
            $contenido = new DocmanContenido();
            $p = $em->createQuery(
                'SELECT p
            FROM SupportBundle:DocmanContenido p
            WHERE p.id = :id
            order by p.fechaLimite');
            $p->setParameter('id', $id);
            $contenido = $p->getResult();
            $formulario = $this->CreateFormBuilder($contenido[0])
                ->add('id', 'hidden', array('data' => $id))
                ->add('tipo', 'hidden', array('data' => '2'))
                ->add('titulo')
                ->add('descripcion', 'textarea')
                ->add('url', 'hidden')
                ->add('fechaLimite', 'datetime')
                ->getForm();
            return $this->render('AdminPageBundle:Default:frm_edit_popup.html.twig', array(
                'formulario' => $formulario->createView(),
                'usuarios' => $usuarios,
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Modificar comunicado',
                'usuario' => $session->get('support'),
            ));
            */

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->createQuery(
                'SELECT p
                  FROM SupportBundle:DocmanUser p JOIN p.oficina o
                  WHERE o.id=:ido
                  order by p.name');
            $usuario->setParameter('ido', $session->get('support')->getOficina()->getId());
            $usuarios = $usuario->getResult();

            $sql_popup_intranet = " SELECT 
                                        *
                                    FROM
                                        docman.docman_intranet_popup
                                    WHERE
                                        ID = '$id';";

            $em_popup_intranet = $this->getDoctrine()->getManager();
            $stmt_popup_intranet = $em_popup_intranet->getConnection()->prepare($sql_popup_intranet);
            $stmt_popup_intranet->execute();

            return $this->render('AdminPageBundle:Default:frm_edit_popup.html.twig', array(
                'popups' => $stmt_popup_intranet->fetchAll(),
                'usuarios' => $usuarios,
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Modificar popup',
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function modificarPopupAction()
    {
        /*
        $peticion = $this->getRequest();
        $c = $peticion->get('form');
        $idc = $peticion->get('usuario');
        $em = $this->getDoctrine()->getManager();
        if ($idc) {
            $usuario = new DocmanUser();
            $usuario = $em->getRepository('SupportBundle:DocmanUser')->find($idc);
        }
        $contenido = new DocmanContenido();
        $contenido = $em->getRepository('SupportBundle:DocmanContenido')->find($c['id']);
        $formulario = $this->CreateFormBuilder($contenido)
            ->add('url')
            ->add('titulo')
            ->add('tipo', 'entity', array(
                'class' => 'SupportBundle:DocmanTipoContenido',
                'property' => 'id',
            ))
            ->add('descripcion')
            ->add('fechaLimite')
            ->getForm();
        $formulario->handleRequest($peticion);
        if ($idc) {
            $contenido->setUsuario($usuario);
        }
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'info', 'Se guardaron los cambios.'
        );
        //return $this->render('AdminPageBundle:Default:test.html.twig');
        return $this->redirect($this->generateUrl('admin_page_comunicadoPanel'));
        */

        $base_url = '';
        $image_url = '';
        if ($_SERVER['HTTPS']) {
            $base_url = 'https://' . $_SERVER['SERVER_NAME'];
        } else {
            $base_url = 'http://' . $_SERVER['SERVER_NAME'];
        }
        $peticion = $this->getRequest();
        $id_popup = $peticion->get('id_popup');
        $titulo_popup = $peticion->get('titulo_popup');
        $fecha_publicacion_popup = $peticion->get('fecha_publicacion_popup');
        $dias_popup = $peticion->get('dias_popup');
        $file = $peticion->files->get('file_popup');

        if ($file != null) {
            $fileName = $peticion->files->get('file_popup')->getClientOriginalName();
            $fileName = date('Y-m-d_H:i:s') . '__' . $fileName;

            $upload_file = $file->move(__DIR__ . '/../../../../web/uploads/', $fileName);
            //$peticion->moveFile('file_popup', sfConfig::get(__DIR__ . '/../../../../web/uploads/' . $fileName);
            $image_url = $base_url . "/uploads/" . $fileName;
        } else {
            $sql_popup_intranet = " SELECT 
                                        image_url
                                    FROM
                                        docman.docman_intranet_popup
                                    WHERE
                                        ID = '$id_popup';";

            $em_popup_intranet = $this->getDoctrine()->getManager();
            $stmt_popup_intranet = $em_popup_intranet->getConnection()->prepare($sql_popup_intranet);
            $stmt_popup_intranet->execute();
            $result = $stmt_popup_intranet->fetchAll();
            $image_url = $result[0]['image_url'];
        }

        $sql_popup_intranet = " UPDATE docman.docman_intranet_popup 
                                SET 
                                    Titulo = '$titulo_popup',
                                    Estado = '1',
                                    Fecha_Publicar = '$fecha_publicacion_popup',
                                    image_url = '$image_url',
                                    dias = '$dias_popup'
                                WHERE
                                    ID = '$id_popup';";

        $em_popup_intranet = $this->getDoctrine()->getManager();
        $stmt_popup_intranet = $em_popup_intranet->getConnection()->prepare($sql_popup_intranet);
        $stmt_popup_intranet->execute();

        return $this->redirect($this->generateUrl('admin_page_popupPanel'));

        //echo "<h1>" . $id_popup . "</h1>";
        //echo "<h1>" . $titulo_popup . "</h1>";
        //echo "<h1>" . $fecha_publicacion_popup . "</h1>";
        //echo "<h1>" . $fileName . "</h1>";
    }

    // [FIN] CREACION, EDICION Y ELIMINACION DE POPUPS

    // [INICIO] CREACION, EDICION Y ELIMINACION DE 'REGLAMENTOS'
    public function reglamentoPanelAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            /*
            $sql_intranet = "   SELECT 
                                    *
                                FROM
                                    docman.docman_contenido
                                WHERE
                                    (tipo = 6) AND (usuario_eliminacion IS NULL)
                                ORDER BY id DESC;";
            */

            $sql_intranet = "CALL docman.intranet_abm_reglamentos(
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                'LISTADO',
                                @pv_resultado,
                                @pv_mensaje,
                                @pv_mensajebd
                            );";

            $em_intranet = $this->getDoctrine()->getManager();
            $stmt_intranet = $em_intranet->getConnection()->prepare($sql_intranet);
            $stmt_intranet->execute();

            $news_result = $stmt_intranet->fetchAll();
            $stmt_intranet->closeCursor();

            return $this->render('AdminPageBundle:Default:reglamento_panel.html.twig', array(
                //'news' => $stmt_intranet->fetchAll(),
                'news' => $news_result,
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Reglamentos',
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function createReglamentoAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();

            $usuario = $em->createQuery(
                'SELECT p
                FROM SupportBundle:DocmanUser p JOIN p.oficina o
                WHERE o.id=:ido
                ORDER BY p.name'
            );
            $usuario->setParameter('ido', $session->get('support')->getOficina()->getId());
            $usuarios = $usuario->getResult();

            // Usuario Logueado
            //$user = $session->get('support')->getId();
            $user = $session->get('support');

            return $this->render('AdminPageBundle:Default:reglamento.html.twig', array(
                'usuarios' => $usuarios,
                'user' => $user,
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Nuevo Reglamento',
                'menu' => $this->getMenu(),
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function guardarReglamentoAction()
    {
        $base_url = '';
        if ($_SERVER['HTTPS']) {
            $base_url = 'https://' . $_SERVER['SERVER_NAME'];
        } else {
            $base_url = 'http://' . $_SERVER['SERVER_NAME'];
        }
        $peticion = $this->getRequest();
        $titulo_reglamento = $peticion->get('titulo_reglamento');
        $descripcion_reglamento = $peticion->get('descripcion_reglamento');
        // FILE CIRCULAR
        $file_circular = $peticion->files->get('file_circular');
        if ($file_circular != null) {
            $fileName = $file_circular->getClientOriginalName();
            $fileName = date('Y-m-d_H:i:s') . '__' . $fileName;
            $upload_file = $file_circular->move(__DIR__ . '/../../../../web/uploads/', $fileName);
            //$file_url = $base_url . "/uploads/" . $fileName;
            $pv_file_circular = $fileName;
        }
        // FILE RESOLUCION
        $file_resolucion = $peticion->files->get('file_resolucion');
        if ($file_resolucion != null) {
            $fileName = $file_resolucion->getClientOriginalName();
            $fileName = date('Y-m-d_H:i:s') . '__' . $fileName;
            $upload_file = $file_resolucion->move(__DIR__ . '/../../../../web/uploads/', $fileName);
            //$file_url = $base_url . "/uploads/" . $fileName;
            $pv_file_resolucion = $fileName;
        }
        // FILE REGLAMENTO
        $file_reglamento = $peticion->files->get('file_reglamento');
        if ($file_reglamento != null) {
            $fileName = $file_reglamento->getClientOriginalName();
            $fileName = date('Y-m-d_H:i:s') . '__' . $fileName;
            $upload_file = $file_reglamento->move(__DIR__ . '/../../../../web/uploads/', $fileName);
            //$file_url = $base_url . "/uploads/" . $fileName;
            $pv_file_reglamento = $fileName;
        }

        // -- Usuario Logueado
        $session = $this->getRequest()->getSession();
        //$user = $session->get('support')->getId();
        $user = $session->get('support');
        $id_user = $user->getId();

        // SQL Query
        /*
        $sql_intranet = " INSERT INTO docman.docman_contenido (titulo, descripcion, url, tipo, fecha_pub, fecha_limite, usuario)
                          VALUES ('$titulo_reglamento', '$descripcion_reglamento', '$file_url', '6', NOW(), NOW(), '$id_user');";
        */

        $sql_intranet = "CALL docman.intranet_abm_reglamentos(
                            null,
                            '$titulo_reglamento',
                            '$descripcion_reglamento',
                            '$pv_file_circular',
                            '$pv_file_resolucion',
                            '$pv_file_reglamento',
                            '$id_user',
                            'INSERT',
                            @pv_resultado,
                            @pv_mensaje,
                            @pv_mensajebd
                        );";

        $em_intranet = $this->getDoctrine()->getManager();
        $stmt_intranet = $em_intranet->getConnection()->prepare($sql_intranet);
        $stmt_intranet->execute();

        return $this->redirect($this->generateUrl('admin_page_reglamentoPanel'));
    }

    public function getReglamentoAction($id)
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->createQuery(
                'SELECT p
                  FROM SupportBundle:DocmanUser p JOIN p.oficina o
                  WHERE o.id=:ido
                  order by p.name');
            $usuario->setParameter('ido', $session->get('support')->getOficina()->getId());
            $usuarios = $usuario->getResult();

            $sql_intranet = "   SELECT 
                                    *
                                FROM
                                    docman.docman_contenido
                                WHERE
                                    (tipo = 6) AND (id = '$id');";

            $em_intranet = $this->getDoctrine()->getManager();
            $stmt_intranet = $em_intranet->getConnection()->prepare($sql_intranet);
            $stmt_intranet->execute();

            return $this->render('AdminPageBundle:Default:frm_edit_reglamento.html.twig', array(
                'reglamentos' => $stmt_intranet->fetchAll(),
                'usuarios' => $usuarios,
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Modificar Reglamento',
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function modificarReglamentoAction()
    {
        $base_url = '';
        $file_url = '';
        if ($_SERVER['HTTPS']) {
            $base_url = 'https://' . $_SERVER['SERVER_NAME'];
        } else {
            $base_url = 'http://' . $_SERVER['SERVER_NAME'];
        }
        $peticion = $this->getRequest();
        $id_reglamento = $peticion->get('id_reglamento');
        $titulo_reglamento = $peticion->get('titulo_reglamento');
        $descripcion_reglamento = $peticion->get('descripcion_reglamento');

        // FILE CIRCULAR
        $file_circular = $peticion->files->get('file_circular');
        if ($file_circular != null) {
            $fileName = $peticion->files->get('file_circular')->getClientOriginalName();
            $fileName = date('Y-m-d_H:i:s') . '__' . $fileName;

            $upload_file = $file_circular->move(__DIR__ . '/../../../../web/uploads/', $fileName);
            //$peticion->moveFile('file_popup', sfConfig::get(__DIR__ . '/../../../../web/uploads/' . $fileName);
            //$file_url = $base_url . "/uploads/" . $fileName;
            $pv_file_circular = $fileName;
        } else {
            $sql_intranet = "  SELECT 
                                    file_circular
                                FROM
                                    docman.docman_contenido
                                WHERE
                                    (tipo = 6) AND (id = '$id_reglamento');";

            $em_intranet = $this->getDoctrine()->getManager();
            $stmt_intranet = $em_intranet->getConnection()->prepare($sql_intranet);
            $stmt_intranet->execute();
            $result = $stmt_intranet->fetchAll();
            $pv_file_circular = $result[0]['file_circular'];
        }

        // FILE RESOLUCION
        $file_resolucion = $peticion->files->get('file_resolucion');
        if ($file_resolucion != null) {
            $fileName = $peticion->files->get('file_resolucion')->getClientOriginalName();
            $fileName = date('Y-m-d_H:i:s') . '__' . $fileName;

            $upload_file = $file_resolucion->move(__DIR__ . '/../../../../web/uploads/', $fileName);
            //$peticion->moveFile('file_popup', sfConfig::get(__DIR__ . '/../../../../web/uploads/' . $fileName);
            //$file_url = $base_url . "/uploads/" . $fileName;
            $pv_file_resolucion = $fileName;
        } else {
            $sql_intranet = "  SELECT 
                                    file_resolucion
                                FROM
                                    docman.docman_contenido
                                WHERE
                                    (tipo = 6) AND (id = '$id_reglamento');";

            $em_intranet = $this->getDoctrine()->getManager();
            $stmt_intranet = $em_intranet->getConnection()->prepare($sql_intranet);
            $stmt_intranet->execute();
            $result = $stmt_intranet->fetchAll();
            $pv_file_resolucion = $result[0]['file_resolucion'];
        }

        // FILE REGLAMENTO
        $file_reglamento = $peticion->files->get('file_reglamento');
        if ($file_reglamento != null) {
            $fileName = $peticion->files->get('file_reglamento')->getClientOriginalName();
            $fileName = date('Y-m-d_H:i:s') . '__' . $fileName;

            $upload_file = $file_reglamento->move(__DIR__ . '/../../../../web/uploads/', $fileName);
            //$peticion->moveFile('file_popup', sfConfig::get(__DIR__ . '/../../../../web/uploads/' . $fileName);
            //$file_url = $base_url . "/uploads/" . $fileName;
            $pv_file_reglamento = $fileName;
        } else {
            $sql_intranet = "  SELECT 
                                    file_reglamento
                                FROM
                                    docman.docman_contenido
                                WHERE
                                    (tipo = 6) AND (id = '$id_reglamento');";

            $em_intranet = $this->getDoctrine()->getManager();
            $stmt_intranet = $em_intranet->getConnection()->prepare($sql_intranet);
            $stmt_intranet->execute();
            $result = $stmt_intranet->fetchAll();
            $pv_file_reglamento = $result[0]['file_reglamento'];
        }

        // -- Usuario Logueado
        $session = $this->getRequest()->getSession();
        //$user = $session->get('support')->getId();
        $user = $session->get('support');
        $id_user = $user->getId();

        /*
        $sql_intranet = "   UPDATE docman_contenido 
                            SET 
                                titulo = '$titulo_reglamento',
                                descripcion = '$descripcion_reglamento',
                                url = '$file_url'
                            WHERE
                                id = '$id_reglamento';";
        */

        $sql_intranet = "CALL docman.intranet_abm_reglamentos(
                            '$id_reglamento',
                            '$titulo_reglamento',
                            '$descripcion_reglamento',
                            '$pv_file_circular',
                            '$pv_file_resolucion',
                            '$pv_file_reglamento',
                            '$id_user',
                            'UPDATE',
                            @pv_resultado,
                            @pv_mensaje,
                            @pv_mensajebd
                        );";

        $em_intranet = $this->getDoctrine()->getManager();
        $stmt_intranet = $em_intranet->getConnection()->prepare($sql_intranet);
        $stmt_intranet->execute();

        return $this->redirect($this->generateUrl('admin_page_reglamentoPanel'));

        //echo "<h1>" . $id_popup . "</h1>";
        //echo "<h1>" . $titulo_popup . "</h1>";
        //echo "<h1>" . $fecha_publicacion_popup . "</h1>";
        //echo "<h1>" . $fileName . "</h1>";
    }

    public function eliminarReglamentoAction($id)
    {
        // -- Usuario Logueado
        $session = $this->getRequest()->getSession();
        $user = $session->get('support');
        $id_user = $user->getId();

        // Store Procedure
        /*
        $sql = "UPDATE docman.docman_contenido 
                SET 
                    usuario_eliminacion = '$id_user',
                    fecha_eliminacion = NOW()
                WHERE
                    id = '$id';";
        */
        $sql = "CALL docman.intranet_abm_reglamentos(
                    '$id',
                    null,
                    null,
                    null,
                    null,
                    null,
                    '$id_user',
                    'DELETE',
                    @pv_resultado,
                    @pv_mensaje,
                    @pv_mensajebd
                );";

        $em_intranet = $this->getDoctrine()->getManager();
        $stmt_intranet = $em_intranet->getConnection()->prepare($sql);
        $stmt_intranet->execute();

        return $this->redirect($this->generateUrl('admin_page_reglamentoPanel'));
    }

    // [   FIN] CREACION, EDICION Y ELIMINACION DE 'REGLAMENTOS'

    public function anuncioAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();
            $contenido = new DocmanContenido();
            $formulario = $this->CreateFormBuilder($contenido)
                ->add('tipo', 'hidden', array('data' => '1'))
                ->add('titulo')
                ->add('descripcion', 'textarea')
                ->add('fechaLimite', 'datetime', array('data' => new \DateTime("now")))
                ->getForm();
            return $this->render('AdminPageBundle:Default:anuncio.html.twig', array(
                'formulario' => $formulario->createView(),
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Nuevo anuncio',
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function videoAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {

            $em = $this->getDoctrine()->getManager();
            $contenido = new DocmanContenido();
            $formulario = $this->CreateFormBuilder($contenido)
                ->add('tipo', 'hidden', array('data' => '4'))
                ->add('titulo')
                ->add('embebido', 'textarea')
                ->add('descripcion', 'textarea')
                ->add('fechaLimite', 'datetime', array('data' => new \DateTime("now")))
                ->getForm();
            return $this->render('AdminPageBundle:Default:video.html.twig', array(
                'formulario' => $formulario->createView(),
                'usuario' => $session->get('support'),
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Nuevo video',
            ));
        }
    }

    public function formularioAction()
    {
        $peticion = $this->getRequest();
        $contenido = new DocmanContenido();
        $em = $this->getDoctrine()->getManager();
        $contenido->setFechaPub(new \DateTime());
        $formulario['imagen']->getData()->move(__DIR__ . '../../../../../web/uploads/', $formulario['imagen']->getData()->getClientOriginalName());
        $formulario['url']->getData()->move(__DIR__ . '../../../../../web/uploads/', $formulario['url']->getData()->getClientOriginalName());
        $contenido->setImagen($formulario['imagen']->getData()->getClientOriginalName());
        $contenido->setUrl($formulario['url']->getData()->getClientOriginalName());
//$em->persist($contenido);
//$em->flush();
        return $this->render('AdminPageBundle:Default:test.html.twig');
    }

    private function sendMail($email, $mensaje1, $titulo, $archivo, DocmanContenido $contenido)
    {
//var_dump($data);
        $usuario = new DocmanUser();
        $usuario = $contenido->getUsuario();
        //var_dump(getcwd());
        $bundary = md5(time());
        $headers = "From: Intranet@oopp.gob.bo\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed;\r\n boundary=\"$bundary\"";
        $headers1 = "--$bundary\r\n";
        $headers1 .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $headers1 .= "<div style='box-shadow: 5px 5px 5px #333333;border-radius:10px;padding:10px;background-color:#FFC926;'><h1 style='text-shadow: 2 2 5px #000000;border-bottom:#ffffff 3px solid;'>$titulo</h1><div>$mensaje1</div>";
        $headers1 .= "<br><div style='padding:5px;height:55px;border:3px #ffffff solid;border-radius:30px;'><img style='float:left;border:3px #ffffff solid;border-radius:50%;' height='50' width='50' src='http://172.16.0.8/SIEMISEG/doccargados/rrhh/" . $usuario->getCi() . "/FOTOS/" . $usuario->getFoto() . "'><div style='float:left;margin-top:5px;margin-left:3px;'>" . $usuario->getName() . "<br><cite>" . $usuario->getCargo() . "</cite></div><img style='float:right;height:50px;' src='http://intranet.oopp.gob.bo/bundleCliente/css/images/logo.png'></div></div>\r\n";
        if (!empty($archivo)) {
            $file = fopen('uploads/' . $archivo, 'rb');
            $mime = mime_content_type('uploads/' . $archivo);
            $data = fread($file, filesize('uploads/' . $archivo));
            $data = chunk_split(base64_encode($data));
            //var_dump($data);
            fclose($file);
            $headers1 .= "--$bundary\r\n";
            $headers1 .= "Content-Type: $mime;\r\n";
            $headers1 .= " name=\"" . $contenido->getUrl() . "\"\r\n";
            $headers1 .= "Content-Disposition: attachment;\r\n";
            $headers1 .= " filename=\"" . $contenido->getUrl() . "\"\r\n";
            $headers1 .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $headers1 .= $data . "\r\n\r\n";
        }
        $headers1 .= "--$bundary--\r\n";
        //var_dump(mail($email, $titulo, $headers1, $headers));


        // SEND MAIL
        $para = $email;
        $url_foto = "https://siemi.oopp.gob.bo/doccargados/rrhh/" . $usuario->getCi() . "/FOTOS/" . $usuario->getFoto();

        $mensaje = "<div style='box-shadow: 5px 5px 5px #333333;border-radius:10px;padding:10px;background-color:#FFC926;'>
                        <h1 style='border-bottom:#ffffff 3px solid;'>
                            $titulo
                        </h1>
                        <div>" . $mensaje1 . "</div>
                        <br>
                        <div style='padding:5px;height:55px;border:3px #ffffff solid;border-radius:30px;'>
                            <img style='float:left;border:3px #ffffff solid;border-radius:50%;' height='50' width='50' src='" . $url_foto . "'>
                            <div style='float:left;margin-top:5px;margin-left:3px;'>
                                " . $usuario->getName() . "
                                <br>
                                <cite>" . $usuario->getCargo() . "</cite>
                            </div>
                            <img style='float:right;height:50px;' src='http://intranet.oopp.gob.bo/bundleCliente/css/images/logo.png'>
                        </div>
                    </div>";


        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $cabeceras .= 'From: intranet@oopp.gob.bo';

        var_dump(mail($para, $titulo, $mensaje, $cabeceras));
    }

    private function sendChat($email, $mensaje1, $titulo, $archivo, DocmanContenido $contenido)
    {
//var_dump($data);
        $usuario = new DocmanUser();
        $usuario = $contenido->getUsuario();
        //var_dump(getcwd());
        $bundary = md5(time());
        $headers = "From: Intranet@oopp.gob.bo\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed;\r\n boundary=\"$bundary\"";
        $headers1 = "--$bundary\r\n";
        $headers1 .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $headers1 .= "<div style='box-shadow: 5px 5px 5px #333333;border-radius:10px;padding:10px;background-color:#FFC926;'><h1 style='text-shadow: 2 2 5px #000000;border-bottom:#ffffff 3px solid;'>$titulo</h1><div>$mensaje1</div>";
        $headers1 .= "<br><div style='padding:5px;height:55px;border:3px #ffffff solid;border-radius:30px;'><img style='float:left;border:3px #ffffff solid;border-radius:50%;' height='50' width='50' src='http://172.16.0.8/SIEMISEG/doccargados/rrhh/" . $usuario->getCi() . "/FOTOS/" . $usuario->getFoto() . "'><div style='float:left;margin-top:5px;margin-left:3px;'>" . $usuario->getName() . "<br><cite>" . $usuario->getCargo() . "</cite></div><img style='float:right;height:50px;' src='http://intranet.oopp.gob.bo/bundleCliente/css/images/logo.png'></div></div>\r\n";
        if (!empty($archivo)) {
            $file = fopen('uploads/' . $archivo, 'rb');
            $mime = mime_content_type('uploads/' . $archivo);
            $data = fread($file, filesize('uploads/' . $archivo));
            $data = chunk_split(base64_encode($data));
            //var_dump($data);
            fclose($file);
            $headers1 .= "--$bundary\r\n";
            $headers1 .= "Content-Type: $mime;\r\n";
            $headers1 .= " name=\"" . $contenido->getUrl() . "\"\r\n";
            $headers1 .= "Content-Disposition: attachment;\r\n";
            $headers1 .= " filename=\"" . $contenido->getUrl() . "\"\r\n";
            $headers1 .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $headers1 .= $data . "\r\n\r\n";
        }
        $headers1 .= "--$bundary--\r\n";
        //var_dump(mail($email, $titulo, $headers1, $headers));


        // SEND CHAT
        $user_chat = $email;
        $url_foto = "https://siemi.oopp.gob.bo/doccargados/rrhh/" . $usuario->getCi() . "/FOTOS/" . $usuario->getFoto();
        $asunto_chat = $titulo;
        $mensaje_chat = "   * $titulo * \n";
        $mensaje_chat .= $mensaje1 . "\n";
        $mensaje_chat .= $url_foto . "\n";
        $mensaje_chat .= $usuario->getName() . "\n";
        $mensaje_chat .= 'http://intranet.oopp.gob.bo/bundleCliente/css/images/logo.png';

        $url_chat = 'http://hades.oopp.gob.bo/notificaciones/api/movil/chat/send/' . '?asunto=' . $asunto_chat . '&user_xmpp=' . $user_chat . '&mensaje=' . urlencode(utf8_encode($mensaje_chat));

        $ch = curl_init($url_chat);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        var_dump($data);
    }

    public function guardarComunicadoAction()
    {
        $peticion = $this->getRequest();
        $contenido = new DocmanContenido();
        $idu = $peticion->get('usuario');
        if (empty($idu)) {
            $this->get('session')->getFlashBag()->add(
                'warning', 'No selecciono al emisor. o el archivo es demasiado grande'
            );
            return $this->redirect($this->generateUrl('admin_page_Comunicado'));
        }
        $msg = '';
        $formulario = $this->CreateFormBuilder($contenido)
            ->add('url', 'file')
            ->add('titulo')
            ->add('tipo', 'entity', array(
                'class' => 'SupportBundle:DocmanTipoContenido',
                'property' => 'id',
            ))
            ->add('descripcion')
            ->add('fechaLimite')
            ->getForm();
        $formulario->handleRequest($peticion);
        $usuario = new DocmanUser();
        $usuario = $this->getUserById($idu);
        $em = $this->getDoctrine()->getManager();
        $contenido->setFechaPub(new \DateTime());
        $contenido->setUsuario($usuario[0]);
        if ($formulario['url']->getData() != NULL) {
            $re = $formulario['url']->getData()->move(__DIR__ . '/../../../../web/uploads/', $formulario['url']->getData()->getClientOriginalName());
            $contenido->setUrl($formulario['url']->getData()->getClientOriginalName());
        } else {
            $this->get('session')->getFlashBag()->add(
                'info', 'No se cargo ni un archivo...'
            );
        }
        $this->sendChat('personal@oopp.gob.bo', $contenido->getDescripcion(), $contenido->getTitulo(), $contenido->getUrl(), $contenido);
        $this->sendMail('personal@oopp.gob.bo', $contenido->getDescripcion(), $contenido->getTitulo(), $contenido->getUrl(), $contenido);
        $em->persist($contenido);
        $em->flush();
        //exit();
        $this->get('session')->getFlashBag()->add(
            'info', 'Se han guardado los cambios..'
        );
        return $this->redirect($this->generateUrl('admin_page_comunicadoPanel'));
    }

    public function modificarComunicadoAction()
    {
        $peticion = $this->getRequest();
        $c = $peticion->get('form');
        $idc = $peticion->get('usuario');
        $em = $this->getDoctrine()->getManager();
        if ($idc) {
            $usuario = new DocmanUser();
            $usuario = $em->getRepository('SupportBundle:DocmanUser')->find($idc);
        }
        $contenido = new DocmanContenido();
        $contenido = $em->getRepository('SupportBundle:DocmanContenido')->find($c['id']);
        $formulario = $this->CreateFormBuilder($contenido)
            ->add('url')
            ->add('titulo')
            ->add('tipo', 'entity', array(
                'class' => 'SupportBundle:DocmanTipoContenido',
                'property' => 'id',
            ))
            ->add('descripcion')
            ->add('fechaLimite')
            ->getForm();
        $formulario->handleRequest($peticion);
        if ($idc) {
            $contenido->setUsuario($usuario);
        }
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'info', 'Se guardaron los cambios.'
        );
//return $this->render('AdminPageBundle:Default:test.html.twig');
        return $this->redirect($this->generateUrl('admin_page_comunicadoPanel'));
    }

    public function eliminarComunicadoAction($id)
    {
        $contenido = new DocmanContenido();
        $em = $this->getDoctrine()->getManager();
        $contenido = $em->getRepository('SupportBundle:DocmanContenido')->find($id);
        $em->remove($contenido);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_page_comunicadoPanel'));
    }

    public function guardarAnuncioAction()
    {
        $peticion = $this->getRequest();
        $contenido = new DocmanContenido();
        $idu = $peticion->get('usuario');
        $formulario = $this->CreateFormBuilder($contenido)
            ->add('titulo')
            ->add('tipo', 'entity', array(
                'class' => 'SupportBundle:DocmanTipoContenido',
                'property' => 'id',
            ))
            ->add('descripcion')
            ->add('fechaLimite')
            ->getForm();
        $formulario->handleRequest($peticion);
        $usuario = new DocmanUser();
        $usuario = $this->getUserById('56');
        $em = $this->getDoctrine()->getManager();
        $contenido->setFechaPub(new \DateTime());
        $contenido->setUsuario($usuario[0]);
        $em->persist($contenido);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'info', 'Se guardaron los cambios.'
        );
        $this->sendMail('irra_b@yahoo.es', $contenido->getTitulo(), $contenido->getDescripcion());
        return $this->redirect($this->generateUrl('admin_page_prueba'));
    }

    public function modificarAnuncioAction()
    {
        $peticion = $this->getRequest();
        $contenido = new DocmanContenido();
        $req = $peticion->get('form');
        $idu = $peticion->get('usuario');
        $fecha = new \DateTime($req['fechaLimite']['date']['year'] . '-' . $req['fechaLimite']['date']['month'] . '-' . $req['fechaLimite']['date']['day'] . ' ' .
            $req['fechaLimite']['time']['hour'] . ':' . $req['fechaLimite']['time']['minute']);
        $idc = $req['id'];
        $em = $this->getDoctrine()->getManager();
        $contenido = $em->getRepository('SupportBundle:DocmanContenido')->find($idc);
        $contenido->setDescripcion($req['descripcion']);
        $contenido->setTitulo($req['titulo']);
        $contenido->setFechaLimite($fecha);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'info', 'Se guardaron los cambios.'
        );
        $this->sendMail('irollano@oopp.gob.bo', $contenido->getTitulo(), htmlentities($contenido->getDescripcion()));
        $this->sendMail('irra_b@yahoo.es', $contenido->getTitulo(), htmlentities($contenido->getDescripcion()));
        //return $this->render('AdminPageBundle:Default:prueba.html.twig');
        return $this->redirect($this->generateUrl('admin_page_prueba'));
    }

    public function eliminarAnuncioAction($id)
    {
        $contenido = new DocmanContenido();
        $em = $this->getDoctrine()->getManager();
        $contenido = $em->getRepository('SupportBundle:DocmanContenido')->find($id);
        $em->remove($contenido);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_page_prueba'));
    }

    public function guardarVideoAction()
    {
        $peticion = $this->getRequest();
        $contenido = new DocmanContenido();
        $idu = $peticion->get('usuario');
        $formulario = $this->CreateFormBuilder($contenido)
            ->add('titulo')
            ->add('tipo', 'entity', array(
                'class' => 'SupportBundle:DocmanTipoContenido',
                'property' => 'id',
            ))
            ->add('descripcion')
            ->add('embebido')
            ->add('fechaLimite')
            ->getForm();
        $formulario->handleRequest($peticion);
        $usuario = new DocmanUser();
        $usuario = $this->getUserById('56');
        $em = $this->getDoctrine()->getManager();
        $contenido->setFechaPub(new \DateTime());
        $contenido->setUsuario($usuario[0]);
        $em->persist($contenido);
        $em->flush();
        return $this->render('AdminPageBundle:Default:test.html.twig');
    }

    private function getUserById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = new DocmanUser();
        $usuario = $em->createQuery(
            'SELECT p
                        FROM SupportBundle:DocmanUser p 
                        WHERE p.id=:id')->setParameter('id', $id);
        return $usuario->getResult();
    }

    private function getJefe($ido)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = new DocmanUser();
        $usuario = $em->createQuery(
            'SELECT p
                        FROM SupportBundle:DocmanUser p 
                        WHERE p.oficina=:id')->setParameter('id', $ido);
        $r = $usuario->getResult();
        if (count($r) > 0) {
            return $r[0]->getId();
        } else {
            return 0;
        }
    }

    public function pruebaAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();
            $c = new DocmanContenido();
            $p = $em->createQuery(
                'SELECT p
                  FROM SupportBundle:DocmanContenido p JOIN p.usuario u JOIN u.oficina o 
                  WHERE o.id=:ido
                  AND p.tipo=1
                  order by p.fechaLimite');
            $p->setParameter('ido', $session->get('support')->getOficina()->getId());
            $c = $p->getResult();
            return $this->render('AdminPageBundle:Default:con_anuncio.html.twig', array(
                'news' => $c,
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Anuncios',
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function comunicadoPanelAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();
            $contenidos = new DocmanContenido();
            $p = $em->createQuery(
                'SELECT p
                  FROM SupportBundle:DocmanContenido p JOIN p.usuario u JOIN u.oficina o 
                  WHERE p.tipo=2
                  AND o.id=:ido
                  order by p.fechaLimite');
            $p->setParameter('ido', $session->get('support')->getOficina()->getId());
            $c = $p->getResult();
            return $this->render('AdminPageBundle:Default:con_comunicado.html.twig', array(
                'news' => $c,
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Comunicados',
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function getContenidoAction($id)
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $contenido = new DocmanContenido();
            $em = $this->getDoctrine()->getManager();
            $p = $em->createQuery(
                'SELECT p
            FROM SupportBundle:DocmanContenido p
            WHERE p.id = :id
            order by p.fechaLimite');
            $p->setParameter('id', $id);
            $contenidos = $p->getResult();
            $formulario = $this->CreateFormBuilder($contenidos[0])
                ->add('id', 'hidden', array('data' => $id))
                ->add('tipo', 'hidden', array('data' => '1'))
                ->add('titulo')
                ->add('descripcion', 'textarea')
                ->add('fechaLimite')
                ->getForm();
            return $this->render('AdminPageBundle:Default:anuncio.html_1.twig', array(
                'formulario' => $formulario->createView(),
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Modificar anuncio',
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function getComunicadoAction($id)
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->createQuery(
                'SELECT p
                  FROM SupportBundle:DocmanUser p JOIN p.oficina o
                  WHERE o.id=:ido
                  order by p.name');
            $usuario->setParameter('ido', $session->get('support')->getOficina()->getId());
            $usuarios = $usuario->getResult();
            $contenido = new DocmanContenido();
            $p = $em->createQuery(
                'SELECT p
            FROM SupportBundle:DocmanContenido p
            WHERE p.id = :id
            order by p.fechaLimite');
            $p->setParameter('id', $id);
            $contenido = $p->getResult();
            $formulario = $this->CreateFormBuilder($contenido[0])
                ->add('id', 'hidden', array('data' => $id))
                ->add('tipo', 'hidden', array('data' => '2'))
                ->add('titulo')
                ->add('descripcion', 'textarea')
                ->add('url', 'hidden')
                ->add('fechaLimite', 'datetime')
                ->getForm();
            return $this->render('AdminPageBundle:Default:frm_comunicado.html.twig', array(
                'formulario' => $formulario->createView(),
                'usuarios' => $usuarios,
                'menu' => $this->getMenu(),
                'active' => $this->get('support.active')->getActive($session),
                'name' => 'Modificar comunicado',
                'usuario' => $session->get('support'),
            ));
        }
    }

    public function getAnunciosAction()
    {
        $em = $this->getDoctrine()->getManager();
        $contenidos = new DocmanContenido();
        $p = $em->createQuery(
            'SELECT p
            FROM SupportBundle:DocmanContenido p
            WHERE p.tipo = 1
            order by p.fechaLimite');
        $contenidos = $p->getResult();
        $i = 1;
        $res = array();
        foreach ($contenidos as $contenido) {
            $b = array(
                'id' => $contenido->getId(),
                'titulo' => $contenido->getTitulo(),
                'descripcion' => $contenido->getDescripcion(),
                'fechaPub' => $contenido->getFechaPub()->format('Y-m-d'),
                'fechaLim' => $contenido->getFechaLimite()->format('Y-m-d'),
                'usuario' => $contenido->getUsuario()->getName(),
            );
            array_push($res, $b);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($res));
        return $respuesta;
    }

    public function uploadAction()
    {
        $formulario = $this->CreateFormBuilder()
            ->add('file', 'file')
            ->getForm();
        return $this->render('AdminPageBundle:Default:upload.html.twig', array(
            'formulario' => $formulario->createView(),
        ));
    }

    public function videoformAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            return $this->render('AdminPageBundle:Default:userform.html.twig'
            );
        }
    }

    public function uploadFileAction()
    {
        $r = $this->getRequest();
        $formulario = $this->CreateFormBuilder()
            ->add('file', 'file')
            ->getForm();
        $formulario->handleRequest($r);
        if ($formulario['file']->getData() == null) {
            return $this->render('AdminPageBundle:Default:result.html.twig', array(
                'result' => 'No se pudo cargar el archivo...'
            ));
        }
        $name = uniqid();
        $formulario['file']->getData()->move(__DIR__ . '/../../../../web/uploads/', $name . $formulario['file']->getData()->getClientOriginalName());
        $result = $name . $formulario['file']->getData()->getClientOriginalName();
        return $this->render('AdminPageBundle:Default:result.html.twig', array(
            'result' => $result
        ));
    }

    public function getUsersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $u = new DocmanUser();
        $p = $em->createQuery(
            'SELECT p,o
            FROM SupportBundle:DocmanUser p LEFT JOIN p.oficina o');
        $u = $p->getResult();
        $res = array();
        foreach ($u as $c) {
            $b = array(
                'id' => $c->getId(),
                'interno' => $c->getInterno(),
                'name' => $c->getName(),
                'ci' => $c->getCi(),
                'fechanac' => $c->getFechanac()->format('d/m/Y'),
                'cargo' => $c->getCargo(),
                'oficina' => $c->getOficina()->getNombre(),
                'email' => $c->getEmail(),
                'usuario' => $c->getUsername(),
                'telefono' => $c->getTelefono(),
                'movil' => $c->getMovil(),
                'direccion' => $c->getDireccion(),
                'ip' => $c->getIp(),
                'estado' => $c->getState(),
                'superior' => $c->getDependeDe(),
                'soporte' => $this->getSoporte($c->getSoporte()),
                'tipo' => $c->getType(),
            );
            array_push($res, $b);
        }
        $resp = array(
            'total' => count($res),
            'rows' => $res,
        );
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($resp));
        return $respuesta;
    }

    private function getSoporte($id)
    {
        $em = $this->getDoctrine()->getManager();
        $u = new DocmanUser();
        $p = $em->createQuery(
            'SELECT p
            FROM SupportBundle:DocmanUser p
            WHERE p.id =:id');
        $p->setParameter('id', $id);
        $u = $p->getResult();
        if (count($u) > 0) {
            return $u[0]->getName();
        }
        return '';
    }

    public function getSoportesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $u = new DocmanUser();
        $p = $em->createQuery(
            'SELECT p
            FROM SupportBundle:DocmanUser p
            WHERE p.type = 3');
        $u = $p->getResult();
        $res = array();
        foreach ($u as $c) {
            $b = array(
                'id' => $c->getId(),
                'name' => $c->getName(),
            );
            array_push($res, $b);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($res));
        return $respuesta;
    }

    public function getUAction()
    {
        $em = $this->getDoctrine()->getManager();
        $u = new DocmanUser();
        $p = $em->createQuery(
            'SELECT p
            FROM SupportBundle:DocmanUser p
            WHERE p.type = 6');
        $u = $p->getResult();
        $res = array();
        foreach ($u as $c) {
            $b = array(
                'id' => $c->getId(),
                'name' => $c->getName(),
            );
            array_push($res, $b);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($res));
        return $respuesta;
    }

    public function getSoportes2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $u = new DocmanUser();
        $p = $em->createQuery(
            'SELECT p
            FROM SupportBundle:DocmanUser p
            WHERE p.type = 3
            ORDER BY p.direccion');
        $u = $p->getResult();
        $p = $em->createQuery(
            'SELECT p
            FROM SupportBundle:DocmanUser p
            WHERE p.soporte = :id')->setParameter('id', '');
        $sa = $p->getResult();
        $arr = array();
        foreach ($u as $c) {
            $res = array();
            $p2 = $em->createQuery(
                'SELECT p
            FROM SupportBundle:DocmanUser p
            WHERE p.soporte = :id')->setParameter('id', $c->getId());
            $ss = $p2->getResult();
            foreach ($ss as $cc) {
                $b = array(
                    'id' => $cc->getId(),
                    'text' => $cc->getName(),
                );
                array_push($res, $b);
            }
            $b2 = array(
                'id' => $c->getId(),
                'text' => $c->getName(),
                'children' => $res,
            );
            array_push($arr, $b2);
        }
        foreach ($sa as $cc) {
            $b = array(
                'id' => $cc->getId(),
                'text' => $cc->getName(),
            );
            array_push($res, $b);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($arr));
        return $respuesta;
    }

    private function getMenu()
    {
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');
        $tu = new Tipusr();
        $em = $this->getDoctrine()->getManager();
        $p = $em->createQuery(
            'SELECT t.id, t.nombre, t.descripcion
            FROM SupportBundle:Tipusr p JOIN p.tipo t
            WHERE p.usuario = :id
            ')->setParameter('id', $u->getId());
        $tu = $p->getResult();
        return $tu;
    }

    private function getPath($id)
    {
        $em = $this->getDoctrine()->getManager();
        $p = $em->createQuery(
            'SELECT p
            FROM SupportBundle:DocmanTipoContenido p
            WHERE p.id = :id
            ')->setParameter('id', $id);
        return $p->getResult();
    }

    public function getOficinasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $oficinas = new DocmanOficina();
        $p = $em->createQuery(
            'SELECT o
            FROM SupportBundle:DocmanOficina o');
        $oficinas = $p->getResult();
        $i = 1;
        $res = array();
        foreach ($oficinas as $oficina) {
            $b = array(
                'id' => $oficina->getId(),
                'nombre' => $oficina->getNombre(),
            );
            array_push($res, $b);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($res));
        return $respuesta;
    }

    public function getOficina($id)
    {
        $em = $this->getDoctrine()->getManager();
        $oficina = new DocmanOficina();
        $p = $em->createQuery(
            'SELECT o
            FROM SupportBundle:DocmanOficina o
            WHERE o.id=:id');
        $p->setParameter('id', $id);
        $oficina = $p->getResult();
        return $oficina;
    }

    public function saveUserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $u = $this->getRequest();
        var_dump($u);
        $usuario = new DocmanUser();
        $ids = $u->request->get('soporte');
        $ido = $u->request->get('oficina');
        $soporte = $this->getUserById($ids);
        $oficina = $this->getOficina($ido);
        $jefe = $this->getJefe($ido);
        $fechanac = new \DateTime($u->request->get('fechanac'));
        $usuario->setCargo($u->request->get('cargo'));
        $usuario->setCi($u->request->get('ci'));
        $usuario->setDireccion($u->request->get('direccion'));
        $usuario->setEmail($u->request->get('email'));
        $usuario->setState($u->request->get('estado'));
        $usuario->setFechanac($fechanac);
        $usuario->setDatereg(new \DateTime());
        $usuario->setLastaccess(new \DateTime());
        $usuario->setTelefref("000000");
        $usuario->setDependeDe($jefe);
        $usuario->setFoto("");
        $usuario->setNumseguro("000000");
        $usuario->setType($u->request->get('tipo'));
        $usuario->setInterno($u->request->get('interno'));
        $usuario->setTelefono($u->request->get('telefono'));
        $usuario->setIp($u->request->get('ip'));
        $usuario->setMovil($u->request->get('movil'));
        $usuario->setName($u->request->get('name'));
        $usuario->setPassword("sistemas");
        $usuario->setOficina($oficina[0]);
        $usuario->setSoporte($ids);
        $usuario->setUsername($u->request->get('usuario'));
        $em->persist($usuario);
        $em->flush();
        $b = array(
            'id' => $usuario->getId(),
            'interno' => $usuario->getInterno(),
            'name' => $usuario->getName(),
            'ci' => $usuario->getCi(),
            'fechanac' => $usuario->getFechanac()->format('d/m/Y'),
            'cargo' => $usuario->getCargo(),
            'oficina' => $usuario->getOficina()->getId(),
            'email' => $usuario->getEmail(),
            'usuario' => $usuario->getUsername(),
            'movil' => $usuario->getMovil(),
            'direccion' => $usuario->getDireccion(),
            'ip' => $usuario->getIp(),
            'estado' => $usuario->getState(),
            'superior' => $usuario->getDependeDe(),
            'soporte' => $usuario->getSoporte(),
        );
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($b));
        return $respuesta;
    }

    public function updateUserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $u = $this->getRequest();
        $usuario = new DocmanUser();
        $idu = $u->query->get('idu');
        $ids = $u->request->get('soporte');
        $ido = $u->request->get('oficina');
        $oficina = NULL;
        $soporte = null;
        if (is_numeric($ido)) {
            $oficina = $this->getOficina($ido);
        }
        if (is_numeric($ids)) {
            $soporte = $this->getUserById($ids);
        }
        $fechanac = new \DateTime($u->request->get('fechanac'));
        $usuario = $em->getRepository('SupportBundle:DocmanUser')->find($idu);
        $usuario->setCargo($u->request->get('cargo'));
        $usuario->setCi($u->request->get('ci'));
        $usuario->setDireccion($u->request->get('direccion'));
        $usuario->setEmail($u->request->get('email'));
        $usuario->setState($u->request->get('estado'));
        $usuario->setFechanac($fechanac);
        $usuario->setInterno($u->request->get('interno'));
        $usuario->setIp($u->request->get('ip'));
        $usuario->setType($u->request->get('tipo'));
        $usuario->setMovil($u->request->get('movil'));
        $usuario->setName($u->request->get('name'));
        if ($oficina != NULL) {
            $usuario->setOficina($oficina[0]);
        }
        if ($soporte != NULL) {
            $usuario->setSoporte($ids);
        }
        $usuario->setUsername($u->request->get('usuario'));
        $em->flush();
        $b = array(
            'id' => $usuario->getId(),
            'interno' => $usuario->getInterno(),
            'name' => $usuario->getName(),
            'ci' => $usuario->getCi(),
            'fechanac' => $usuario->getFechanac()->format('d/m/Y'),
            'cargo' => $usuario->getCargo(),
            'oficina' => $usuario->getOficina()->getId(),
            'email' => $usuario->getEmail(),
            'usuario' => $usuario->getUsername(),
            'movil' => $usuario->getMovil(),
            'direccion' => $usuario->getDireccion(),
            'ip' => $usuario->getIp(),
            'estado' => $usuario->getState(),
            'superior' => $usuario->getDependeDe(),
            'soporte' => $usuario->getSoporte(),
        );
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($b));
        return $respuesta;
    }

}
