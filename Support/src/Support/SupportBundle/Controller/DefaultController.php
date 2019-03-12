<?php

namespace Support\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Support\SupportBundle\Entity\DocmanSolicitud;
use Support\SupportBundle\Entity\DocmanUser;
use Support\SupportBundle\Entity\DocmanProblema;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Support\SupportBundle\Entity\DocmanLoginLog;
use DateTime;
use DateInterval;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    public function loginAction() {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {

            if ($session->get('support')->getType() == 0) {
                return $this->redirect($this->generateUrl('admin_page_homepage', array('t' => '0')));
            }
            if ($session->get('support')->getType() == 3) {
                return $this->redirect($this->generateUrl('helpdesk_homepage2'));
            }
            if ($session->get('support')->getType() == 9) {
                return $this->redirect($this->generateUrl('helpdesk_homepage2'));
            }
            if ($session->get('support')->getType() == 7) {
                return $this->redirect($this->generateUrl('fun_support_panel'));
            }
            if ($session->get('support')->getType() == 4) {
                return $this->redirect($this->generateUrl('admin_page_homepage', array('t' => '8')));
            }
        }
    }

    private function isValid($u, $p) {
        $em = $this->getDoctrine()->getManager();
        $s = new DocmanUser();
        //$s= $em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('username'=>$u,'password'=>$p,'soporte'=>'0'));
        $s = $em->createQuery(
                'SELECT u,o
                  FROM SupportBundle:DocmanUser u JOIN u.oficina o
                  WHERE u.username=:name
                  AND u.password=:password');
        $s->setParameter('name', $u);
        $s->setParameter('password', $p);
        $result = $s->getResult();
        if (count($result) == 0) {
            return null;
        } else {
            return $result[0];
        }
    }

    public function logoutAction() {
        $session = new Session();
        $session->start();
        $session->remove('support');
        $this->saveLogOut();
        return $this->redirect($this->generateUrl('support_support_panel'));
    }

    public function loginCheckAction() {
        $r = $this->getRequest();
        $u = $r->get('_username');
        $p = $r->get('_password');
        $usuario = $this->isValid($u, $p);
        if (!is_null($usuario)) {
            $session = new Session();
            $session->start();
            $session->set('support', $usuario);
            $ids = $this->saveLogin();
            $session->set('ids', $ids);
            if ($session->get('support')->getType() == 0) {
                return $this->redirect($this->generateUrl('admin_page_homepage', array('t' => '0')));
            }
            if ($session->get('support')->getType() == 3) {
                return $this->redirect($this->generateUrl('helpdesk_homepage2'));
            }
            if ($session->get('support')->getType() == 9) {
                return $this->redirect($this->generateUrl('helpdesk_homepage2'));
            }
            if ($session->get('support')->getType() == 7) {
                return $this->redirect($this->generateUrl('fun_support_panel'));
            }
            if ($session->get('support')->getType() == 4) {
                return $this->redirect($this->generateUrl('admin_page_homepage', array('t' => '8')));
            }
        } else {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        }
    }

    public function getSolicitudesAction($id) {
        $session = new Session();
        $session->start();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $u = new DocmanUser();
            $u = $session->get('support');
            $em = $this->getDoctrine()->getManager();
            $p = $em->getRepository('SupportBundle:DocmanProblema')->findAll();
            $hoy = new \DateTime("now");
            $donut = $em->createQuery(
                            'SELECT s.estado,count(s)as total
                  FROM SupportBundle:DocmanSolicitud s
                  WHERE s.soporte=:id
                  group by s.estado')->setParameter('id', $u->getId());
            $result_donut = $donut->getResult();
            $q2 = $em->createQuery(
                            'SELECT p,c 
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr
                  WHERE p.soporte=:id
                  AND p.estado=0')->setParameter('id', $u->getId());
            $cont = $q2->getResult();
            $q = $em->createQuery(
                    'SELECT p,c 
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr
                  WHERE p.soporte=:id
                  AND p.problema=:p
                  AND p.estado=0');
            $q->setParameter('id', $u->getId());
            $q->setParameter('p', $id);
            $result = $q->getResult();
            $cd = new DateTime(date('Y-m-d H:i:s'));
            $data = array();
            foreach ($result as $value) {
                $hs = $value->getHoraSolicitud();
                $d = $cd->diff($hs);
                $dat[0] = $d;
                $dat[1] = $value;
                $dat[2] = $this->getFuncional($value->getProblema()->getIdp());
                array_push($data, $dat);
            }
            $dnt[0] = 0;
            $dnt[1] = 0;
            foreach ($result_donut as $value) {
                $dnt[$value['estado']] = $value['total'];
            }
            $fecha = new \DateTime();
            $q = $em->createQuery(
                    'SELECT count(p)as total,pro.nombre,c.name,c.id
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pro  
                  WHERE p.soporte=:id
                  AND p.estado=0
                  AND p.fechaSolicitud=:fecha
                  Group By p.problema
                  Order By total desc');
            $q->setParameter('id', $u->getId());
            $q->setParameter('fecha', $fecha->format('Y-m-d'));
            $bars = $q->getResult();
            $q = $em->createQuery(
                    'SELECT pro.nombre,c.name,c.id,p.fechaSolicitud,p.horaSolicitud,p.fechaSolucion,p.horaAtencion
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pro  
                  WHERE p.soporte=:id
                  AND p.estado=1
                  AND p.fechaSolicitud=:fecha
                  Order By p.id desc');
            $q->setParameter('id', $u->getId());
            $q->setParameter('fecha', $fecha->format('Y-m-d'));
            $cerradas = $q->getResult();
            $cerradas1 = array();
            foreach ($cerradas as $value) {
                $fs = $value['fechaSolicitud'];
                $fa = $value['fechaSolucion'];
                $fa->setTime($value['horaAtencion']->format('H'), $value['horaAtencion']->format('i'), $value['horaAtencion']->format('s'));
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fa->diff($fs);
                $val = array(
                    'cerradas' => $value,
                    'tiempo' => $dif,
                );
                array_push($cerradas1, $val);
            }
            return $this->render('SupportBundle:Default:index.html.twig', array(
                        'donut' => $dnt,
                        'contador' => $cont,
                        'problemas' => $p,
                        'solicitudes' => $data,
                        'support' => $session->get('support'),
                        'bars' => $bars,
                        'barras' => $this->getBars(new DateTime()),
                        'cerradas' => $cerradas1,
                        'num'=>$this->getNumSol(),
            ));
        }
    }

    public function mostrarAction() {
        $session = new Session();
        $session->start();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $u = new DocmanUser();
            $u = $session->get('support');
            $em = $this->getDoctrine()->getManager();
            //
            $p = $em->getRepository('SupportBundle:DocmanProblema')->findAll();
            $donut = $em->createQuery(
                            'SELECT s.estado,count(s)as total
                  FROM SupportBundle:DocmanSolicitud s
                  WHERE s.soporte=:id
                  group by s.estado')->setParameter('id', $u->getId());
            $result_donut = $donut->getResult();
            $q = $em->createQuery(
                            'SELECT p,c 
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr JOIN p.soporte sop
                  WHERE sop.id=:id
                  AND p.estado=0
                  Order By p.id desc')->setParameter('id', $u->getId());
            $result = $q->getResult();
            $cd = new DateTime(date('Y-m-d H:i:s'));
            $data = array();
            foreach ($result as $value) {
                $var = $value->getFechaSolicitud();
                $var->setTime($value->getHoraSolicitud()->format('H'), $value->getHoraSolicitud()->format('i'), $value->getHoraSolicitud()->format('s'));
                $d = $cd->diff($var);
                $dat[0] = $d;
                $dat[1] = $value;
                $dat[2] = $this->getFuncional($value->getProblema()->getIdp());
                array_push($data, $dat);
            }
            $dnt[0] = 0;
            $dnt[1] = 0;
            foreach ($result_donut as $value) {
                $dnt[$value['estado']] = $value['total'];
            }
            $cont = $result;
            /*
             * SELECT count(*)AS total, u.name FROM docman_solicitud s
              INNER JOIN docman_user u ON s.solicitante=u.idu
              WHERE s.estado='1'
              GROUP BY s.solicitante
             */
            /* SELECT count(*)as total, s.problema,s.solicitante FROM docman_solicitud s
              WHERE s.estado='0'
              GROUP BY s.problema
             */
            $fecha = new \DateTime();
            $q = $em->createQuery(
                    'SELECT count(p)as total,pro.nombre,c.name,c.id
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pro  
                  WHERE p.soporte=:id
                  AND p.estado=0
                  AND p.fechaSolicitud=:fecha
                  Group By p.problema
                  Order By total desc');
            $q->setParameter('id', $u->getId());
            $q->setParameter('fecha', $fecha->format('Y-m-d'));
            $bars = $q->getResult();
            $q = $em->createQuery(
                    'SELECT s.id,s.fechaSolicitud,s.fechaSolucion,s.horaSolicitud,s.horaAtencion,cliente.name,p.nombre
                     FROM SupportBundle:DocmanSolicitud s JOIN s.soporte sop JOIN s.solicitante cliente JOIN s.problema p
                     WHERE s.fechaSolucion=:fecha
                     AND sop.id=:id
                     Order By s.fechaSolucion');
            $q->setParameter('id', $u->getId());
            $q->setParameter('fecha', $fecha->format('Y-m-d'));
            $cerradas = $q->getResult();
            $cerradas1 = array();
            foreach ($cerradas as $value) {
                $fs = $value['fechaSolicitud'];
                $fa = $value['fechaSolucion'];
                $fa->setTime($value['horaAtencion']->format('H'), $value['horaAtencion']->format('i'), $value['horaAtencion']->format('s'));
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fa->diff($fs);
                $val = array(
                    'cerradas' => $value,
                    'tiempo' => $dif,
                );
                array_push($cerradas1, $val);
            }
            return $this->render('SupportBundle:Default:index.html.twig', array(
                        'donut' => $dnt,
                        'contador' => $cont,
                        'problemas' => $p,
                        'solicitudes' => $data,
                        'support' => $session->get('support'),
                        'bars' => $bars,
                        'barras' => $this->getBars(new DateTime()),
                        'cerradas' => $cerradas1,
                        'num'=>$this->getNumSol(),
            ));
        }
    }
    public function getSolByProblem($fecha) {
        
    }
    public function getBars($fecha) {
        $problemas = $this->getProblems();
        $bars = array();
        foreach ($problemas as $problema) {
            $resultado = $this->getSolicitudesByProblem($problema['idp'],$fecha);
            $a = 0;
            $c = 0;
            foreach ($resultado as $res) {
                if ($res['estado'] == '1') {
                    $c = $res['total'];
                }
                if ($res['estado'] == '0') {
                    $a = $res['total'];
                }
            }
            $r = array(
                'problema' => $problema['nombre'],
                'abiertas' => $a,
                'cerradas' => $c,
            );
            array_push($bars, $r);
        }
        return $bars;
    }
    public function getBarsAction() {
        $r = $this->getRequest();
        $parameter = $r->get('parameter');
        $fecha=new DateTime();
        $resp='';
        switch ($parameter) {
            case 1:
                $resp=$this->getBars($fecha);
                break;
            case 2:
                $fecha->sub(new DateInterval('P7D'));
                $resp=$this->getBars($fecha);
                break;
            case 3:
                $fecha2=new DateTime();
                $fecha2->setDate($fecha->format('Y'), $fecha->format('m'),1);
                $resp=$this->getBars($fecha2);
                break;
            case 4:
                $fecha2=new DateTime();
                $fecha2->setDate($fecha->format('Y'), $fecha->format('m'),1);
                $resp=$this->getBars($fecha2);
                break;
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($resp));
        return $respuesta;
    }
    private function getProblemByName($name) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                        'SELECT p 
                  FROM SupportBundle:DocmanProblema p 
                  WHERE p.nombre=:nombre')->setParameter('nombre', $name);
        $result = $q->getResult();
        if (count($result) > 0) {
            return $result[0]->getIdp();
        }
        return null;
    }
    private function getFuncional($idp) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                        'SELECT p,f 
                  FROM SupportBundle:DocmanProblema p JOIN p.fun f
                  WHERE p.idp=:idp')->setParameter('idp', $idp);
        $result = $q->getResult();
        if (count($result) > 0) {
            return $result[0]->getFun()->getName();
        }
        return null;
    }

    public function agregarrSolicitudAction() {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                        'SELECT p,c 
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c
                  WHERE p.soporte=:id
                  AND p.estado=0')->setParameter('id', '59');
        $result = $q->getResult();
        return $this->render('SupportBundle:Default:index.html.twig', array('solicitudes' => $result));
    }

    public function gridAction() {

        return $this->render('SupportBundle:Default:soporte.html.twig');
    }
    public function gridPopupAction($intervalo,$problema) {

        return $this->render('SupportBundle:Default:soporte.html_1.twig',array('intervalo'=>$intervalo,
                                                                               'problema'=>$problema));
    }

    private function saveLogin() {
        $session = new Session();
        $u = $session->get('support');
        $em = $this->getDoctrine()->getManager();
        $soporte = new DocmanUser();
        $log = new DocmanLoginLog();
        $soporte = $em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('id' => $u->getId()));
        $log->setFecha(new \DateTime());
        $log->setInicio(new \DateTime());
        $log->setUsuario($soporte);
        $em->persist($log);
        $em->flush();
        return $log->getId();
    }

    private function saveLogOut() {
        $session = new Session();
        $ids = $session->get('ids');
        $session->remove('ids');
        $em = $this->getDoctrine()->getManager();
        $log = new DocmanLoginLog();
        $log = $em->getRepository('SupportBundle:DocmanLoginLog')->findOneBy(array('id' => $ids));
        $log->setFin(new \DateTime());
        $em->persist($log);
        $em->flush();
    }

    public function getJSONSolicitudesAction() {
        $session = new Session();
        $session->start();
        $u = $session->get('support');
        $em = $this->getDoctrine()->getManager();
        /*
         * SELECT u.`name`as usuario,p.nombre as problema ,s.fecha_solicitud,s.hora_solicitud,s.fecha_solucion,s.hora_atencion
          FROM docman_solicitud s
          INNER JOIN docman_problema p ON p.idp=s.problema
          INNER JOIN docman_user u  ON u.id=s.solicitante
         */
        $g = $em->createQuery(
                'SELECT s.id,u.name as usuario,p.nombre as servicio,s.fechaSolicitud,s.horaSolicitud,s.fechaSolucion,s.horaAtencion
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema p 
                  WHERE s.soporte=:id');
        $g->setParameter('id', $u->getId());
        $graph = $g->getResult();
        $r = array();
        foreach ($graph as $value) {
            if ($value['fechaSolucion']) {
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'servicio' => $value['servicio'],
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y-m-d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => $value['fechaSolucion']->format('Y-m-d'),
                    'horaatencion' => $value['horaAtencion']->format('H:i:s'),
                );
            }else
            {
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'servicio' => $value['servicio'],
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y-m-d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => '---',
                    'horaatencion' => '---',
                );
            }
            array_push($r, $s);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($r));
        return $respuesta;
    }
    public function getJSONSolicitudes2Action($intervalo,$problema) {
        $session = new Session();
        $session->start();
        $u = $session->get('support');
        $em = $this->getDoctrine()->getManager();
        $problema=$this->getProblemByName($problema);
        $fecha=new DateTime();
        $resp='';
        switch ($intervalo) {
            case 1:
                $resultado = $this->getSolicitudesByProblem2($problema,$fecha);
                break;
            case 2:
                $fecha->sub(new DateInterval('P7D'));
                $resultado = $this->getSolicitudesByProblem2($problema,$fecha);
                break;
            case 3:
                $fecha2=new DateTime();
                $fecha2->setDate($fecha->format('Y'), $fecha->format('m'),1);
                $resultado = $this->getSolicitudesByProblem2($problema,$fecha2);
                break;
        }
        $r = array();
        foreach ($resultado as $value) {
            if ($value['fechaSolucion']) {
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'servicio' => $value['servicio'],
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y-m-d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => $value['fechaSolucion']->format('Y-m-d'),
                    'horaatencion' => $value['horaAtencion']->format('H:i:s'),
                );
            }else
            {
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'servicio' => $value['servicio'],
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y-m-d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => '---',
                    'horaatencion' => '---',
                );
            }
            array_push($r, $s);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($r));
        return $respuesta;
    }
    public function getJsonSupportAction() {
        $session = new Session();
        $session->start();
        $u = $session->get('support');
        $em = $this->getDoctrine()->getManager();
        $g = $em->createQuery(
                        'SELECT count(s)as total,s.fechaSolicitud
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u 
                  WHERE s.soporte=:id
                  AND s.estado=1
                  GROUP BY s.fechaSolicitud')->setParameter('id', $u->getId());
        $graph = $g->getResult();
        $r = '[';
        foreach ($graph as $value) {
            $fecha = $value['fechaSolicitud'];
            $r = $r . '[' . ($fecha->getTimestamp() * 1000) . ',' . $value['total'] . '],';
        }
        $r = substr($r, 0, strlen($r) - 1);
        $r = $r . ']';
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($r);
        return $respuesta;
    }

    public function uploaderAction() {
        return $this->render('SupportBundle:Default:uploader.html.twig');
    }

    public function transferirAction() {
        $r = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $s=new DocmanSolicitud();
        $s = $em->getRepository('SupportBundle:DocmanSolicitud')->find($r->get('id'));
        //$p = $em->getRepository('SupportBundle:DocmanSolicitud')->find($r->get('id'));
        $s->setDerivado('1');
        $p=$s->getProblema();
        $em->flush();
        $this->sendMail($s->getProblema()->getFun()->getEmail(), $s->getSolicitante(), $p,$s->getSoporte()->getName());
        $respuesta = new Response();
        //$respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($r->get('id'));
        return $respuesta;
    }
    private function sendMail($email, DocmanUser $usuario, DocmanProblema $pr, $soporte) {
        if($usuario->getFoto())
        {
            $foto='http://172.16.0.8/SIEMISEG/doccargados/rrhh/'.$usuario->getCi().'/FOTOS/'.$usuario->getFoto();
        }  else {
            $foto='http://intranet.oopp.gob.bo/bundles/new-user.png';
        }
        $titulo =  'Solicitud de soporte del usuario:'.$usuario->getName();
        $mensaje = 'Acabas de recibir una solicitud de soporte del usuario:<br>'.
                   '<img  style="width:50px;height:50px;border-radius:50%" src="'.$foto.'">'.$usuario->getName().'-<cite>'.$usuario->getCargo().'</cite><br>'.
                   '<div>INTERNO:'.$usuario->getInterno().'</div>'.
                   '<div>DIRECCION:'.$usuario->getDireccion().'</div>'.
                   '<div>SERVICIO: '.$pr->getNombre().'</div>'.
                   '<div>TRANSFERIDO POR:'.$soporte.'</div>';
        $headers = "From: HelpDesk@oopp.gob.bo\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        return mail($email, $titulo, $mensaje, $headers);
    }
    private function getSolicitudes() {
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');

        $em = $this->getDoctrine()->getManager();
        $donut = $em->createQuery(
                        'SELECT s
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema p
                  WHERE s.soporte=:id
                  group by s.estado')->setParameter('id', $u->getId());
        $result_donut = $donut->getResult();
        return $result_donut;
    }

    private function getSolicitudesByProblem($idp,$fecha) {
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');
        $em = $this->getDoctrine()->getManager();
        $donut = $em->createQuery(
                'SELECT p.nombre,s.estado,count(s)as total
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema p
                  WHERE s.soporte=:id
                  AND p.idp=:idp
                  AND s.fechaSolucion>=:fecha
                  group by s.estado');
        $donut->setParameter('id', $u->getId());
        $donut->setParameter('idp', $idp);
        $donut->setParameter('fecha', $fecha->format('Y-m-d'));
        $result_donut = $donut->getResult();
        return $result_donut;
    }
    private function getSolicitudesByProblem2($idp,$fecha) {
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');
        $em = $this->getDoctrine()->getManager();
        $donut = $em->createQuery(
                'SELECT s.id,p.nombre as servicio,s.estado,u.name as usuario,s.fechaSolicitud,s.horaSolicitud,s.fechaSolucion,s.horaAtencion
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema p
                  WHERE s.soporte=:id
                  AND p.idp=:idp
                  AND s.fechaSolucion>=:fecha');
        $donut->setParameter('id', $u->getId());
        $donut->setParameter('idp', $idp);
        $donut->setParameter('fecha', $fecha->format('Y-m-d'));
        $result_donut = $donut->getResult();
        return $result_donut;
    }
    private function getProblems() {
        $session = $this->getRequest()->getSession();
        $u = $session->get('support');

        $em = $this->getDoctrine()->getManager();
        $donut = $em->createQuery(
                'SELECT p.idp,p.nombre
                  FROM SupportBundle:DocmanProblema p');
        $result_donut = $donut->getResult();
        return $result_donut;
    }
    public function updateAction()
    {
        $r = $this->getRequest();
        $parameter = $r->get('c');
        $resp=$this->getNumSol();
        $val='0';
        foreach ($resp as $value) {
            if($value['total']==$parameter){
                $val='0';
            }  else {
                $val='1';
            }
        }
        $respuesta = new Response();
        //$respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($val);
        return $respuesta;
    }
    private function getNumSol()
    {
        $session = $this->getRequest()->getSession();
        $u = new DocmanUser();
        $u = $session->get('support');
        $fecha=new DateTime();
        $em = $this->getDoctrine()->getManager();
        $s = $em->createQuery(
                  'SELECT count(s)as total
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u 
                  WHERE s.soporte=:id
                  AND s.estado=0');
        $s->setParameter('id', $u->getId());
        if($s->getResult())
        {
            return $s->getResult();
        }  else {
            return 0;
        }
    }
}
