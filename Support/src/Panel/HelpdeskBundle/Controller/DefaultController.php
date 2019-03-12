<?php

namespace Panel\HelpdeskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('HelpdeskBundle:Default:index.html.twig', array('name' => 'asdasd'));
    }

    public function abiertasAction() {
        $r = $this->getRequest();
        $parameter = $r->get('parameter');
        $r = '{
            "draw": 1,
  "recordsTotal": 1,
  "recordsFiltered": 1,
  "data": [
    [
      "Tiger Nixon",
      "System Architect",
      "5421"
    ]]}';
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($r);
        return $respuesta;
    }

    public function solicitudesAction() {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $fecha = new \DateTime();
            $ff = $fecha->format('Y-m-d');
            $sol = $this->exec(array('value' => $ff), 'call solicitudesPorFecha(?)');
            $atendidas_por_soporte = $this->exec(array('value' => $ff), 'call solicitudesPorSoporte(?)');
            $totales = $this->exec(array(), 'call totales');
            $totales_dia = $this->exec(array('value' => $ff), 'call totalesDelDia(?)');
            $abiertas = $this->exec(array(), 'call solicitudesAbiertas');
            $rep_sol_por_soporte = $this->exec(array(), 'call solicitudesPorSoporteReporte');
            $rep_problema = $this->exec(array(), 'call reportePorProblema');
            $rep_problema_fecha = $this->exec(array('value' => $ff), 'call reportePorProblemaPorFecha(?)');
            $bar = $this->exec(array(), 'call estadistico');

            /* $respuesta = new Response();
              $respuesta->headers->set('Content-Type', 'application/json');
              $respuesta->setCharset('UTF-8');
              $respuesta->setStatusCode(200);
              $respuesta->setContent(json_encode($result));
              return $respuesta; */
            return $this->render('HelpdeskBundle:Default:index.html.twig', array(
                        'solicitudes' => $sol,
                        'por_soporte' => $atendidas_por_soporte,
                        'totales' => $totales,
                        'totalDia' => $totales_dia,
                        'abiertas' => $abiertas,
                        'reporte' => $rep_sol_por_soporte,
                        'rep_problema' => $rep_problema,
                        'rep_problema_fecha' => $rep_problema_fecha,
                        'bar' => $bar
                            )
            );
        }
    }

    private function exec($values, $procedure) {
        $em = $this->getDoctrine()->getManager();
        $rr = $em->getConnection()->prepare($procedure);
        $i = 1;
        foreach ($values as $value) {
            $rr->bindValue($i, $value);
            $i++;
        }
        $rr->execute();
        $result = $rr->fetchAll();
        return $result;
    }

}
