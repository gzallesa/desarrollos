<?php

namespace Support\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Support\SupportBundle\Entity\DocmanSolicitud;
use Support\SupportBundle\Entity\DocmanUser;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Support\SupportBundle\Entity\DocmanLoginLog;
use Support\SupportBundle\Entity\Gcm;
use DateTime;
use DateInterval;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\HttpFoundation\Response;

class RestFulController extends Controller {

    public function listAction($ids) {
        $u = new DocmanUser();
        $em = $this->getDoctrine()->getManager();
        $hoy = new \DateTime("now");
        $r = $em->createQuery(
                'SELECT s.id,s.horaSolicitud,u.name,pr.nombre,u.id as idu
          FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema pr
          WHERE u.soporte=:id
          AND s.fechaSolicitud=:fecha
          AND s.estado=0
          Order By s.horaSolicitud');
        $r->setParameter('id', $ids);
        $r->setParameter('fecha', $hoy->format('Y/m/d'));
        $result = $r->getResult();
        $pendientes=array();
        foreach ($result as $pendiente) {
            $p=array(
                'ids'=>$pendiente['id'],
                'hora'=>$pendiente['horaSolicitud']->format('H:i:s'),
                'usuario'=>$pendiente['name'],
                'idu'=>$pendiente['idu'],
            );
            array_push($pendientes, $p);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'text/html');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($pendientes));
        return $respuesta;
    }
    public function addAction() {
        $em = $this->getDoctrine()->getManager();
        $r = $this->getRequest();
        $regid = $r->get('regid');
        $number = $r->get('number');
        $gcm=new Gcm();
        $gcm->setRegid($regid);
        $gcm->setSoporte($number);
        $em->persist($gcm);
        $em->flush();
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'text/html');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent('ok');
        return $respuesta;
    }
}
