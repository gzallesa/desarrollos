<?php

namespace Support\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Support\SupportBundle\Entity\DocmanSolicitud;
use Support\SupportBundle\Entity\DocmanUser;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Support\SupportBundle\Entity\DocmanLoginLog;
use DateTime;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\HttpFoundation\Response;

class FunController extends Controller {

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
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema pr
                  WHERE pr.fun=:id
                  AND s.derivado=1
                  group by s.estado');
            $donut->setParameter('id', $u->getId());
            //$donut->setParameter('fecha', $hoy->format('Y/m/d'));
            $result_donut = $donut->getResult();
            $q2 = $em->createQuery(
                            'SELECT p,c 
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr
                  WHERE pr.fun=:id
                  AND p.estado=0
                  AND p.derivado=1')->setParameter('id', $u->getId());
            $cont = $q2->getResult();
            $q = $em->createQuery(
                    'SELECT p,c 
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr
                  WHERE pr.fun=:id 
                  AND p.problema=:p
                  AND p.estado=0
                  AND p.derivado=1');
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
                array_push($data, $dat);
            }
            $dnt[0] = 0;
            $dnt[1] = 0;
            foreach ($result_donut as $value) {
                $dnt[$value['estado']] = $value['total'];
            }
            $q = $em->createQuery(
                    'SELECT c.name as name,count(p)as y,c.id
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c  JOIN p.problema pr
                  WHERE pr.fun=:id
                  AND p.estado=1
                  AND p.derivado=1
                  Group By p.solicitante');
            $q->setParameter('id', $u->getId());
            $q->setMaxResults(10);
            $bars = $q->getResult();
            return $this->render('SupportBundle:Default:index.html_1.twig', array(
                        'donut' => $dnt,
                        'contador' => $cont,
                        'problemas' => $p,
                        'solicitudes' => $data,
                        'support' => $session->get('support'),
                        'bars' => $bars,
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
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema pr
                  WHERE pr.fun=:id
                  AND s.derivado=1
                  group by s.estado')->setParameter('id', $u->getId());
            $result_donut = $donut->getResult();
            $q = $em->createQuery(
                            'SELECT p,c 
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr
                  WHERE p.estado=0
                  AND p.derivado=1
                  AND pr.fun=:fun
                  Order By p.fechaSolicitud, p.horaSolicitud');
            $q->setParameter('fun',$u->getId());
            $result = $q->getResult();
            $cd = new DateTime(date('Y-m-d H:i:s'));
            $data = array();
            foreach ($result as $value) {
                $var = $value->getFechaSolicitud();
                $var->setTime($value->getHoraSolicitud()->format('H'), $value->getHoraSolicitud()->format('i'), $value->getHoraSolicitud()->format('s'));
                $d = $cd->diff($var);
                $dat[0] = $d;
                $dat[1] = $value;
                //$dat[2] = $this->getFuncional($value->getProblema()->getIdp());
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
            $q = $em->createQuery(
                    'SELECT c.name as name,count(p)as y,c.id
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr 
                  WHERE pr.fun=:id
                  AND p.estado=1
                  AND p.derivado=1
                  Group By p.solicitante');
            $q->setParameter('id', $u->getId());
            $q->setMaxResults(10);
            $bars = $q->getResult();
            return $this->render('SupportBundle:Default:index.html_1.twig', array(
                        'donut' => $dnt,
                        'contador' => $cont,
                        'problemas' => $p,
                        'solicitudes' => $data,
                        'support' => $session->get('support'),
                        'bars' => $bars,
            ));
        }
    }
    private function getFuncional($idp)
    {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                        'SELECT p,f 
                  FROM SupportBundle:DocmanProblema p JOIN p.fun f
                  WHERE p.idp=:idp')->setParameter('idp', $idp);
        $result = $q->getResult();
        if(count($result)>0)
        {
            return $result[0]->getFun()->getName();
        }
        return null;

    }
    public function agregarrSolicitudAction() {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                        'SELECT p,c 
                  FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c
                  WHERE c.soporte=:id
                  AND p.estado=0')->setParameter('id', '59');
        $result = $q->getResult();
        return $this->render('SupportBundle:Default:index.html_1.twig', array('solicitudes' => $result));
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

    public function getJsonSupportAction() {
        $session = new Session();
        $session->start();
        $u = $session->get('support');
        $em = $this->getDoctrine()->getManager();
        $g = $em->createQuery(
                        'SELECT count(s)as total,s.fechaSolicitud
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema pr 
                  WHERE pr.fun=:id
                  AND s.estado=1
                  AND s.derivado=1
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
        $r=$this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $s=$em->getRepository('SupportBundle:DocmanSolicitud')->find($r->get('id'));
        $s->setDerivado('1');
        $em->flush();
        $respuesta = new Response();
        //$respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($r->get('id'));
        return $respuesta;
    }
}
