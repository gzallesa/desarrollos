<?php

namespace Support\AdminBundle\Controller;

use DateInterval;
use DateTime;
use Support\SupportBundle\Entity\DocmanUser;
use Support\SupportBundle\Entity\Tipusr;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller {

    public function indexAction() {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $u = new DocmanUser();
            $u = $session->get('support');
            $em = $this->getDoctrine()->getManager();
            $p = $em->getRepository('SupportBundle:DocmanProblema')->findAll();
            $totalSolicitudes = $this->getTotasSolicitudes();
            $t = $this->getTotasSolicitudesAtendidas();
            $totalSolicitudesAtendidas = array(
                'n' => $t,
                'p' => round((100 * ($this->getTotasSolicitudesAtendidas())) / $totalSolicitudes)
            );
            
            return $this->render('AdminBundle:Default:index.html.twig', array(
                        'totalSolicitudes' => $totalSolicitudes,
                        'totalSolicitudesAtendidas' => $totalSolicitudesAtendidas,
                        'menu' => $this->getMenu(),
                        'active' => $this->get('support.active')->getActive($session),
                        'user' => $session->get('support')));
        }
        
    }

    private function getSoportes() {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT u
                  FROM SupportBundle:DocmanUser u 
                  WHERE u.type=3 
                  AND u.state=1');
        return $q->getResult();
    }

    public function getSolicitudesAction() {
        $r = $this->getRequest();
        $idu = $r->get('idu');
        $u = new DocmanUser();
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                        'SELECT p,c 
              FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr
              WHERE p.soporte=:id
              AND p.estado=0')->setParameter('id', $idu);
        $result = $q->getResult();
        $cd = new DateTime(date('Y-m-d H:i:s'));
        $data = array();
        foreach ($result as $value) {
            $ff = $value->getHoraSolicitud();
            $hs = $value->getFechaSolicitud()->setTime($ff->format('H'), $ff->format('i'));
            $d = $cd->diff($hs);
            $dat[0] = $d;
            $dat[1] = $value;
            array_push($data, $dat);
        }
        return $this->render('AdminBundle:Default:index.html_1.twig', array('data' => $data));
    }

    public function getChartsAction() {
        $p = $this->getProblemas();
        $u = $this->getSoportes();
        $s = array();
        foreach ($u as $usuario) {
            $t = array();
            foreach ($p as $problema) {
                $c = $this->getAtendidasBySupport($problema['idp'], 1, $usuario->getId());
                foreach ($c as $value) {
                    array_push($t, $value['total']);
                }
            }
            array_push($s, $t);
        }
        return $this->render('AdminBundle:Default:charts.html.twig', array(
                    'data' => $this->problemas(),
                    'bars' => $s,
                    'problemas' => $p,
                    'soportes' => $u,
        ));
    }

    public function getAtendidasBySupport($problema, $estado, $soporte) {
        $u = new DocmanUser();
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT count(p) as total,u.soporte
              FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante u JOIN p.problema pr
              WHERE p.estado=:estado
              AND pr.idp=:problema
              AND p.soporte=:soporte
              ');
        $q->setParameter('problema', $problema);
        $q->setParameter('estado', $estado);
        $q->setParameter('soporte', $soporte);
        $result = $q->getResult();
        if ($result) {
            return $result;
        }
        return array(
            array(
                'total' => '0',
                'soporte' => $soporte,
            )
        );
    }

    public function problemas() {
        $u = new DocmanUser();
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT count(p)as total,pr.nombre 
              FROM SupportBundle:DocmanSolicitud p JOIN p.problema pr
              Group by p.problema');
        $result = $q->getResult();
        return $result;
    }

    public function getProblemas() {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT p.nombre,p.idp
              FROM SupportBundle:DocmanProblema p');
        $result = $q->getResult();
        return $result;
    }

    public function panelAction() {
        return $this->render('AdminBundle:Default:admin.html.twig', array(
                    'values'=>$this->getValues(),
        ));
    }

    public function grillaAction() {
        return $this->render('AdminBundle:Default:soporte.html.twig'
        );
    }

    private function getColor($dif) {
        $suma = $dif->h;
        $color = '';
        if ($dif->d > 0 or $dif->m > 0) {
            $color = 'Alerta';
            return $color;
        }
        if ($suma > 5) {
            $color = 'Alerta';
            return $color;
        }
        if ($suma > 2 && $suma <= 5) {
            $color = 'Medio';
            return $color;
        }
        if ($suma <= 2) {
            $color = 'Bueno';
            return $color;
        }
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
                'SELECT s.id,u.name as usuario,p.nombre as servicio,
                        s.fechaSolicitud,s.horaSolicitud,
                        s.fechaSolucion,s.horaAtencion,sop.name as soporte,sop.id as ids,
                        u.cargo,u.interno,s.estado
                  FROM SupportBundle:DocmanSolicitud s 
                                     JOIN s.solicitante u
                                     JOIN s.problema p
                                     JOIN s.soporte sop
                  WHERE sop.state=1
                  AND sop.type=3');
        $graph = $g->getResult();
        $r = array();
        $fecha = new datetime();
        foreach ($graph as $value) {
            if ($value['fechaSolucion']) {
                $fs = $value['fechaSolicitud'];
                $fa = $value['fechaSolucion'];
                $fa->setTime($value['horaAtencion']->format('H'), $value['horaAtencion']->format('i'), $value['horaAtencion']->format('s'));
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fa->diff($fs);
                $color = $this->getColor($dif);
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'cargo' => $value['cargo'],
                    'interno' => $value['interno'],
                    'servicio' => $value['servicio'],
                    'estado' => ($value['estado']=='1') ? 'Cerrado':'Abierto',
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y/m/d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => $value['fechaSolucion']->format('Y/m/d'),
                    'horaatencion' => $value['horaAtencion']->format('H:i:s'),
                    'soporte' => $value['soporte'],
                    'ids' => $value['ids'],
                    'tiempo' => $dif->d . ' dias ' . $dif->h . ' h ' . $dif->i . ' m ' . $dif->s . ' s',
                    'color' => $color,
                );
            } else {
                $fs = $value['fechaSolicitud'];
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fecha->diff($fs);
                $color = $this->getColor($dif);
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'cargo' => $value['cargo'],
                    'interno' => $value['interno'],
                    'servicio' => $value['servicio'],
                    'estado' => ($value['estado']=='1') ? 'Cerrado':'Abierto',
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y-m-d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => '---',
                    'horaatencion' => '---',
                    'soporte' => $value['soporte'],
                    'ids' => $value['ids'],
                    'tiempo' => $dif->d . ' dias ' . $dif->h . ' h ' . $dif->i . ' m ' . $dif->s . ' s',
                    'color' => $color,
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

    private function getTotalSolicitudesByProblema($soporte, $problema, $fecha) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT count(s)as total 
                 FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante sol JOIN s.problema p
                 WHERE s.soporte=:soporte
                 AND p.idp=:problema
                 AND s.fechaSolicitud>=:fecha
                 Group By s.problema');
        $q->setParameter('soporte', $soporte);
        $q->setParameter('problema', $problema);
        $q->setParameter('fecha', $fecha);
        $r = $q->getResult();
        if ($r) {
            return $r;
        } else {
            return array(
                array('total' => 0)
            );
        }
    }

    public function barsAction() {
        $r = $this->getRequest();
        $u = $r->get('param');
        $fecha = new \DateTime();
        switch ($u) {
            case '1':
                $a = $this->getBarsByDate($fecha);
                break;
            case '2':
                $fecha->sub(new DateInterval('P7D'));
                $a = $this->getBarsByDate($fecha);
                break;
            case '3':
                $fecha1 = new DateTime();
                $fecha1->setDate($fecha->format('Y'), $fecha->format('m'), 1);
                $a = $this->getBarsByDate($fecha1);
                break;
            case '4':
                $fecha1 = new DateTime();
                $fecha1->setDate($fecha->format('Y'), 1, 1);
                $a = $this->getBarsByDate($fecha1);
                break;
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($a));
        return $respuesta;
    }

    public function bubbleAction() {
        $s = $this->getSoportes();
        $p = $this->getProblemas();
        $res = array();
        foreach ($s as $soporte) {
            $arr = array();
            foreach ($p as $problema) {
                $ate = $this->getData($soporte->getId(), '1', $problema['idp']);
                $pen = $this->getData($soporte->getId(), '0', $problema['idp']);
                $total = 0;
                $at = 0;
                $pe = 0;
                foreach ($ate as $value) {
                    $at = $value['total'];
                }
                foreach ($pen as $value) {
                    $pe = $value['total'];
                }
                $total = $at + $pe;
                //$datos=array(intval($total),intval($at),intval($pe));
                $datos = array('x' => intval($total),
                    'y' => intval($at),
                    'z' => intval($pe),
                    'customParam' => $problema['nombre']);
                array_push($arr, $datos);
            }
            $arr2 = array('name' => $soporte->getName(), 'data' => $arr);
            array_push($res, $arr2);
        }
        $a = array(
            'serie' => array(
                array(
                    'data' => array(
                        array('x' => 5,
                            'y' => 5,
                            'z' => 5,
                            'customParam' => 'data1'),
                        array('x' => 10,
                            'y' => 5,
                            'z' => 5,
                            'customParam' => 'data2'),
                        array('x' => 15,
                            'y' => 5,
                            'y' => 5,
                            'customParam' => 'data3'),
                    )
                ),
                array(
                    'data' => array(
                        array(11, 5, 6),
                        array(1, 1, 0),
                        array(80, 45, 35),
                    )
                ),
        ));
        $a['serie'] = $res;
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($a));
        return $respuesta;
    }

    public function getData($soporte, $estado, $problema) {
        $em = $this->getDoctrine()->getManager();
        $g = $em->createQuery(
                'SELECT count(s)as total
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema p
                  WHERE s.soporte=:id
                  AND s.estado=:estado
                  AND p.idp=:problema');
        $g->setParameter('id', $soporte);
        $g->setParameter('estado', $estado);
        $g->setParameter('problema', $problema);
        return $g->getResult();
    }

    private function getBarsByDate($fecha) {
        $s = $this->getProblemas();
        $soportes = $this->getSoportes();
        $array = array();
        foreach ($soportes as $soporte) {
            $a = array();
            foreach ($s as $p) {
                $ss = $this->getTotalSolicitudesByProblema($soporte->getId(), $p['idp'], $fecha->format('Y-m-d'));
                foreach ($ss as $value) {
                    array_push($a, intval($value['total']));
                }
            }
            $v = array(
                'name' => $soporte->getName(),
                'data' => $a
            );
            array_push($array, $v);
        }
        $problemas = array();
        foreach ($s as $p) {
            array_push($problemas, $p['nombre']);
        }
        $a = array(
            'categories' => '',
            'series' => ''
        );
        $a['categories'] = $problemas;
        $a['series'] = $array;
        return $a;
    }

    public function getSupportsChartAction($id) {
        $em = $this->getDoctrine()->getManager();
        $g = $em->createQuery(
                        'SELECT count(s)as total,s.fechaSolicitud
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u 
                  WHERE s.soporte=:id
                  AND s.estado=1
                  GROUP BY s.fechaSolicitud')->setParameter('id', $id);
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

    public function getSupport($id) {
        $em = $this->getDoctrine()->getManager();
        $g = $em->createQuery(
                        'SELECT u.name
                  FROM SupportBundle:DocmanUser u
                  WHERE u.id=:id')->setParameter('id', $id);
        if ($g->getResult()) {
            $u = $g->getResult();
            return $u[0]['name'];
        }
        return null;
    }

    public function supportsAction() {
        $u = $this->getUsers(3);
        $a = array();
        foreach ($u as $value) {
            array_push($a, $value['id']);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($a));
        return $respuesta;
    }

    private function getUsers($tipo) {
        $em = $this->getDoctrine()->getManager();
        $g = $em->createQuery(
                'SELECT u.id,u.name
                  FROM SupportBundle:DocmanUser u 
                  WHERE u.type=:tipo');
        $g->setParameter('tipo', $tipo);
        $users = $g->getResult();
        return $users;
    }

    private function getTotasSolicitudes() {
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT count(p) 
                  FROM SupportBundle:DocmanSolicitud p');
        $totalSolicitudes = $q->getResult();
        if (count($totalSolicitudes) > 0) {
            if ($totalSolicitudes[0][1] > 0) {
                return $totalSolicitudes[0][1];
            } else {
                return 1;
            }
        }
        return 1;
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

    private function getSolicitudesRecientes() {
        $u = new DocmanUser();
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT p,c 
              FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr
              Order By p.fechaSolicitud desc, p.horaSolicitud desc');
        $q->setMaxResults(10);
        $result = $q->getResult();
        return $result;
    }

    private function getSolicitudesPendientes() {
        $u = new DocmanUser();
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT p,c 
               FROM SupportBundle:DocmanSolicitud p JOIN p.solicitante c JOIN p.problema pr 
               WHERE p.estado=0
               Order By p.fechaSolicitud desc, p.horaSolicitud desc');
        $q->setMaxResults(10);
        $result = $q->getResult();
        //var_dump($result);
        return $result;
    }

    public function controlAction() {
        $session = $this->getRequest()->getSession();
        if (!$session->get('support')) {
            return $this->render('SupportBundle:Default:login.html.twig', array('err' => 'Combinación de nombre de usuario/correo electrónico y contraseña errónea.'));
        } else {
            $totalSolicitudes = $this->getTotasSolicitudes();
            $t = $this->getTotasSolicitudesAtendidas();
            $totalSolicitudesAtendidas = array(
                'n' => $t,
                'p' => round((100 * ($this->getTotasSolicitudesAtendidas())) / $totalSolicitudes)
            );
            $fecha = new \DateTime();
            $u = new DocmanUser();
            $em = $this->getDoctrine()->getManager();
            $q = $em->createQuery(
                            'SELECT u.id,u.name,l 
              FROM SupportBundle:DocmanLoginLog l JOIN l.usuario u
              WHERE l.fecha=:fecha
              Order By l.usuario, l.inicio')->setParameter('fecha', $fecha->format('Y-m-d'));
            $result = $q->getResult();
            return $this->render('AdminBundle:Default:control.html.twig', array(
                        'data' => $result,
                        'user' => $session->get('support'),
                        'totalSolicitudes' => $totalSolicitudes,
                        'totalSolicitudesAtendidas' => $totalSolicitudesAtendidas,
                        'menu' => $this->getMenu(),
                        'active' => $this->get('support.active')->getActive($session),
            ));
        }
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

    private function getValues() {
        $s = $this->getSoportes();
        $r=array();
        foreach ($s as $value) {
            array_push($r, $this->getValuesBySupport($value->getId()));
        }
        return $r;
    }

    private function getValuesBySupport($ids) {
        $em = $this->getDoctrine()->getManager();
        $p = $em->createQuery(
                'SELECT s.fechaSolicitud,s.horaSolicitud,
                        s.fechaSolucion,s.horaAtencion
               FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante c  
               WHERE s.soporte=:id
               ');
        $p->setParameter('id', $ids);
        $tu = $p->getResult();
        $fecha = new datetime();
        $resultado=array('id'=>$ids,'soporte'=>$this->getSupport($ids),'Alerta'=>0,'Medio'=>0,'Bueno'=>0);
        foreach ($tu as $value) {
            if ($value['fechaSolucion']) {
                $fs = $value['fechaSolicitud'];
                $fa = $value['fechaSolucion'];
                $fa->setTime($value['horaAtencion']->format('H'), $value['horaAtencion']->format('i'), $value['horaAtencion']->format('s'));
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fa->diff($fs);
                $color = $this->getColor($dif);
                //
            } else {
                $fs = $value['fechaSolicitud'];
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fecha->diff($fs);
                $color = $this->getColor($dif);
                //
            }
            $resultado[$color]=$resultado[$color]+1;
        }
        return $resultado;
    }
    public function detallePieAction($val) {
        return $this->render('AdminBundle:detalleCharts:pie.html.twig',array('val'=>$val));
    }
    public function detalleBubbleAction($problema,$soporte) {
        return $this->render('AdminBundle:detalleCharts:bubble.html.twig',array('problema'=>$problema,'soporte'=>$soporte));
    }
    public function getJSONDetallePieAction($val) {
        $em = $this->getDoctrine()->getManager();
        /*
         * SELECT u.`name`as usuario,p.nombre as problema ,s.fecha_solicitud,s.hora_solicitud,s.fecha_solucion,s.hora_atencion
          FROM docman_solicitud s
          INNER JOIN docman_problema p ON p.idp=s.problema
          INNER JOIN docman_user u  ON u.id=s.solicitante
         */
        $g = $em->createQuery(
                'SELECT s.id,u.name as usuario,p.nombre as servicio,
                        s.fechaSolicitud,s.horaSolicitud,
                        s.fechaSolucion,s.horaAtencion,u.soporte,
                        u.cargo,u.interno,s.estado
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema p
                  WHERE p.nombre=:nombre
                  Order By s.id');
        $g->setParameter('nombre',$val);
        $graph = $g->getResult();
        $r = array();
        $fecha = new datetime();
        foreach ($graph as $value) {
            if ($value['fechaSolucion']) {
                $fs = $value['fechaSolicitud'];
                $fa = $value['fechaSolucion'];
                $fa->setTime($value['horaAtencion']->format('H'), $value['horaAtencion']->format('i'), $value['horaAtencion']->format('s'));
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fa->diff($fs);
                $color = $this->getColor($dif);
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'cargo' => $value['cargo'],
                    'interno' => $value['interno'],
                    'servicio' => $value['servicio'],
                    'estado' => $value['estado'],
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y-m-d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => $value['fechaSolucion']->format('Y-m-d'),
                    'horaatencion' => $value['horaAtencion']->format('H:i:s'),
                    'soporte' => $this->getSupport($value['soporte']),
                    'ids' => $value['soporte'],
                    'tiempo' => $dif->d . ' dias ' . $dif->h . ' h ' . $dif->i . ' m ' . $dif->s . ' s',
                    'color' => $color,
                );
            } else {
                $fs = $value['fechaSolicitud'];
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fecha->diff($fs);
                $color = $this->getColor($dif);
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'cargo' => $value['cargo'],
                    'interno' => $value['interno'],
                    'servicio' => $value['servicio'],
                    'estado' => $value['estado'],
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y-m-d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => '---',
                    'horaatencion' => '---',
                    'soporte' => $this->getSupport($value['soporte']),
                    'ids' => $value['soporte'],
                    'tiempo' => $dif->d . ' dias ' . $dif->h . ' h ' . $dif->i . ' m ' . $dif->s . ' s',
                    'color' => $color,
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
    public function getJSONDetalleBubbleAction($problema,$soporte) {
        $em = $this->getDoctrine()->getManager();
        /*
         * SELECT u.`name`as usuario,p.nombre as problema ,s.fecha_solicitud,s.hora_solicitud,s.fecha_solucion,s.hora_atencion
          FROM docman_solicitud s
          INNER JOIN docman_problema p ON p.idp=s.problema
          INNER JOIN docman_user u  ON u.id=s.solicitante
         */
        $g = $em->createQuery(
                'SELECT s.id,u.name as usuario,p.nombre as servicio,
                        s.fechaSolicitud,s.horaSolicitud,
                        s.fechaSolucion,s.horaAtencion,sop.name as soporte,sop.id as ids,
                        u.cargo,u.interno,s.estado
                  FROM SupportBundle:DocmanSolicitud s JOIN s.solicitante u JOIN s.problema p JOIN s.soporte sop
                  WHERE p.nombre=:nombre
                  AND sop.name=:soporte
                  AND sop.type=3
                  Order By s.id');
        $g->setParameter('nombre',$problema);
        $g->setParameter('soporte',$soporte);
        $graph = $g->getResult();
        $r = array();
        $fecha = new datetime();
        foreach ($graph as $value) {
            if ($value['fechaSolucion']) {
                $fs = $value['fechaSolicitud'];
                $fa = $value['fechaSolucion'];
                $fa->setTime($value['horaAtencion']->format('H'), $value['horaAtencion']->format('i'), $value['horaAtencion']->format('s'));
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fa->diff($fs);
                $color = $this->getColor($dif);
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'cargo' => $value['cargo'],
                    'interno' => $value['interno'],
                    'servicio' => $value['servicio'],
                    'estado' => $value['estado'],
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y-m-d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => $value['fechaSolucion']->format('Y-m-d'),
                    'horaatencion' => $value['horaAtencion']->format('H:i:s'),
                    'soporte' => $value['soporte'],
                    'ids' => $value['ids'],
                    'tiempo' => $dif->d . ' dias ' . $dif->h . ' h ' . $dif->i . ' m ' . $dif->s . ' s',
                    'color' => $color,
                );
            } else {
                $fs = $value['fechaSolicitud'];
                $fs->setTime($value['horaSolicitud']->format('H'), $value['horaSolicitud']->format('i'), $value['horaSolicitud']->format('s'));
                $dif = $fecha->diff($fs);
                $color = $this->getColor($dif);
                $s = array(
                    'id' => $value['id'],
                    'usuario' => $value['usuario'],
                    'cargo' => $value['cargo'],
                    'interno' => $value['interno'],
                    'servicio' => $value['servicio'],
                    'estado' => $value['estado'],
                    'fechasolicitud' => $value['fechaSolicitud']->format('Y-m-d'),
                    'horasolicitud' => $value['horaSolicitud']->format('H:i:s'),
                    'fechasolucion' => '---',
                    'horaatencion' => '---',
                    'soporte' => $value['soporte'],
                    'ids' => $value['ids'],
                    'tiempo' => $dif->d . ' dias ' . $dif->h . ' h ' . $dif->i . ' m ' . $dif->s . ' s',
                    'color' => $color,
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
}
