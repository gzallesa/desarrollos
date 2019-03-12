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
use Support\SupportBundle\Entity\Monitoreo;
use Support\SupportBundle\Entity\Fuente;
use DOMDocument;
use DateInterval;

class MonitoreoController extends Controller {

    private function getFuentes() {
        $em = $this->getDoctrine()->getManager();
        $s = $em->createQuery(
                'SELECT f
                  FROM SupportBundle:Fuente f');
        return $s->getResult();
    }

    private function existeNoticia($title, $fuente,$ext) {
        $em = $this->getDoctrine()->getManager();
        $s = $em->createQuery(
                'SELECT m
                  FROM SupportBundle:Monitoreo m
                  WHERE m.title=:title
                  AND m.pubdate=:pubdate
		  AND m.ext=:ext	
                  AND m.fuente=:fuente');
        $s->setParameter('title', $title);
        $s->setParameter('pubdate', new DateTime('NOW'));
        $s->setParameter('fuente', $fuente->getId());
	$s->setParameter('ext', $ext);
        $r = $s->getResult();
        if (count($r) > 0) {
            return true;
        }
        return false;
    }

    public function guardarMonitoreoAction() {

        $this->monitoreoFps();exit();
//$this->sendMail('irollano@oopp.gob.bo');
        $em = $this->getDoctrine()->getManager();
        $fuentes = $this->getFuentes();
        $nombre_fichero = "keywords.json";
        $gestor = fopen($nombre_fichero, "r");
        $contenido = fread($gestor, filesize($nombre_fichero));
        $keywords = json_decode($contenido);
        var_dump($keywords);
        $existe = 0;
        $patron = '/' . $keywords->keywords . '/';
        $v = 'ok';
        try {
            foreach ($fuentes as $fuente) {
                $articulos = simplexml_load_string(file_get_contents($fuente->getUrl()));
                foreach ($articulos->channel->item as $value2) {
                    if (preg_match($patron, strtolower(strip_tags($value2->title)))) {
                        //var_dump($value2->description);
                        echo '<br>ENCONTRADO:'.$value2->title;
                        if (!$this->existeNoticia($value2->title, $fuente,0)) {
                            echo '<br>NUEVO:'.$value2->title . '<br>';
                            echo $value2->pubDate . '<br>';
                            $existe = 1;
                            $m = new Monitoreo();
                            $m->setTitle($value2->title);
                            $m->setDescription($value2->description);
                            $m->setLink($value2->link);
			    $m->setExt(0);
                            $m->setPubdate($value2->pubDate);
                            $m->setFuente($fuente);
                            $em->persist($m);
                            $em->flush();
                        }else{echo ' EXISTE';}
                    }
                }
            }
            //$em->flush();
        } catch (Exception $ex) {
            $v = $ex;
        }
var_dump($existe);
            $this->sendMail('irollano@oopp.gob.bo');
	    $this->sendMail('marce@oopp.gob.bo');
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'text/html');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($v);
        return $respuesta;
    }
    public function monitoreoFps() {
$time = strtotime('10/16/2003');
echo $time;
        $this->sendMailFps('marce@oopp.gob.bo');
        $this->sendMailFps('ltelleria@fps.gob.bo');
$this->sendMailFps('irollano@oopp.gob.bo');
exit();
        $em = $this->getDoctrine()->getManager();
        $fuentes = $this->getFuentes();
        $nombre_fichero = "keywordsfps.json";
        $gestor = fopen($nombre_fichero, "r");
        $contenido = fread($gestor, filesize($nombre_fichero));
        $keywords = json_decode($contenido);
        var_dump($keywords);
        $existe = 0;
        $patron = '/' . $keywords->keywords . '/';
        $v = 'ok';
        try {
            foreach ($fuentes as $fuente) {
                $articulos = simplexml_load_string(file_get_contents($fuente->getUrl()));
                foreach ($articulos->channel->item as $value2) {
                    if (preg_match($patron, strtolower(strip_tags($value2->title)))) {
                        //var_dump($value2->description);
                        echo $value2->title.'<br>';
                        if (!$this->existeNoticia($value2->title, $fuente,1)) {
                            echo $value2->title . '<br>';
                            echo $value2->pubDate . '<br>';
                            $existe = 1;
                            $m = new Monitoreo();
                            $m->setTitle($value2->title);
                            $m->setDescription($value2->description);
                            $m->setLink($value2->link);
                            $m->setPubdate(new \DateTime($value2->pubDate));
                            $m->setFuente($fuente);
                            $m->setExt(1);
                            $em->persist($m);
                            $em->flush();
                        }
                    }
                }
            }
            //$em->flush();
        } catch (Exception $ex) {
            $v = $ex;
        }
        $this->sendMailFps('irollano@oopp.gob.bo');
//	$this->sendMailFps('marce@oopp.gob.bo');
//	$this->sendMailFps('ltelleria@fps.gob.bo');
    }
    private function sendMailFps($email) {
        $pubDate=new DateTime();
	//$pubDate->sub(new DateInterval('P1D'));
        $em = $this->getDoctrine()->getManager();
        $r=new Monitoreo();
	    $s = $em->createQuery(
                    'SELECT m,f
                  FROM SupportBundle:Monitoreo m JOIN m.fuente f
                  WHERE m.pubdate>=:pubdate
                  AND m.ext=1
                  Order By m.id desc');
            $s->setParameter('pubdate', $pubDate->format('Y-m-d'));
        $r = $s->getResult();
        $cuerpo='';
        foreach ($r as $value) {
            $cuerpo.='<div style="border-radius:10px;background-color:#ffffff;padding:10px;"><b style="color:#00468c;font-size:16px;">'.$value->getTitle().' - FUENTE: '.$value->getFuente()->getNombre().'</b> <br>';
            $cuerpo.='<div style="color:#000000;">'.$value->getDescription().'</div>';
            $cuerpo.='<br><a href="'.$value->getLink().'">Ver</a></div><br><hr><br>';
        }
        $fecha = new DateTime();
        $titulo = 'Monitoreo Informativo';
        $mensaje = '<div style="padding:10px;border-radius:10px;background:#eeeeee;"><div style="text-decoration: underline;color:#00468c;"><h1>Monitoreo Informativo - Intranet:</h1></div>' .
                '<img  style="border-radius:5px;" src="https://www.oopp.gob.bo/fps.jpg"><br>' .
                '<b style="color:#00468c;font-weight: bold;">FECHA:</b> ' . $fecha->format('d-m-Y') . '<br>' .
                '<b style="color:#00468c;font-weight: bold;">NOTICIAS DEL SECTOR</b><br>' .
                $cuerpo.'</div>';
        $headers = "From: intranet@fps.gob.bo\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
//	var_dump($mensaje);
	echo mail($email, $titulo, $mensaje, $headers);
    }
    private function sendMail($email) {
        $pubDate=new DateTime();
	//$pubDate->sub(new DateInterval('P10D'));
        $em = $this->getDoctrine()->getManager();
        $r=new Monitoreo();
	    $s = $em->createQuery(
                    'SELECT m,f
                  FROM SupportBundle:Monitoreo m JOIN m.fuente f
                  WHERE m.pubdate>=:pubdate
		  AND m.ext=0
                  Order By m.id desc');
            $s->setParameter('pubdate', $pubDate->format('Y-m-d'));
        $r = $s->getResult();
        $cuerpo='';
        foreach ($r as $value) {
            $cuerpo.='<div style="border-radius:10px;background-color:#ffffff;padding:10px;"><b style="color:#00468c;font-size:16px;">'.$value->getTitle().' - FUENTE: '.$value->getFuente()->getNombre().'</b><br>';
            $cuerpo.='<div style="color:#000000;">'.$value->getDescription().'</div>';
            $cuerpo.='<br><a href="'.$value->getLink().'">Ver</a></div><br><hr><br>';
        }
        $fecha = new DateTime();
        $titulo = 'Monitoreo Informativo Intranet';
        $mensaje = '<div style="padding:10px;border-radius:10px;background:#eeeeee;"><div style="text-decoration: underline;color:#00468c;"><h1>Monitoreo Informativo - Intranet:</h1></div>' .
                '<img  style="border-radius:5px;" src="https://www.oopp.gob.bo/logo.jpg"><br>' .
                '<b style="color:#00468c;font-weight: bold;">FECHA:</b> ' . $fecha->format('d-m-Y') . '<br>' .
                '<b style="color:#00468c;font-weight: bold;">NOTICIAS DEL SECTOR</b><br>' .
                $cuerpo.'</div>';
        $headers = "From: intranet@oopp.gob.bo\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	//var_dump($mensaje);
	echo mail($email, $titulo, $mensaje, $headers);
    }
	
    public function getMonitoreoAction() {

        $resp = $this->getRequest();
        $fecha1 = $resp->request->get('fecha');
        $em = $this->getDoctrine()->getManager();
        if ($fecha1 != "") {
            $fecha = new \DateTime($fecha1);
            $s = $em->createQuery(
                    'SELECT m,f
                  FROM SupportBundle:Monitoreo m JOIN m.fuente f
                  WHERE m.pubdate=:pubdate
          AND m.ext!=1
                  Order By m.pubdate desc');
            $s->setParameter('pubdate', $fecha->format('Y-m-d'));
        } else {
            $fecha = new \DateTime();
            // $fecha->sub(new DateInterval('P3D'));
            $s = $em->createQuery(
                    'SELECT m,f
                  FROM SupportBundle:Monitoreo m JOIN m.fuente f
                  WHERE m.pubdate>=:pubdate
            AND m.ext=1
                  Order By m.pubdate desc');
            $s->setParameter('pubdate', $fecha->format('Y-m-d'));
        }
        $nr = $s->getResult();
        $n = '<ul class="noticias">';
        $v = '';
        foreach ($nr as $value) {
            $v = '<li class="noticia"><div class="title"><a target=_blank href="' . $value->getLink() . '">' . $value->getTitle() . '</a><div style="margin-top:2px;">FUENTE: ' . $value->getFuente()->getNombre() . '</div></div>';
            $v = $v . '<div class="description">' . $value->getDescription() . '</div>';
            $v = $v . '<div class="pubDate">' . $value->getPubDate()->format('Y-M-d') . '</div></li>';
            $n = $n . $v;
        }
        $n = $n . '</ul>';

        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'text/html');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($n);
        return $respuesta;

        /*
        $sql = "SELECT
                    m.link, m.title, f.nombre as nombreFuente, m.description, m.pubDate
                FROM
                    monitoreo m
                        INNER JOIN
                    fuente f ON (m.fuente = f.id)
                WHERE
                    m.pubdate = '2017-01-01' AND m.ext != 1
                ORDER BY m.pubdate DESC";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $result_query = $stmt->fetchAll();

        $html = '<ul class="noticias">';

        foreach ($result_query as $value) {

            $fila = '<li class="noticia">
                        <div class="title">
                            <a target="_blank" href="' . $value['link'] . '">' .
                                $value['title'] . '
                            </a>
                            <div style="margin-top:2px;">
                                FUENTE: ' . $value['nombreFuente'] . '
                            </div>
                        </div>
                        <div class="description">' .
                            $value['description'] . '
                        </div>
                        <div class="pubDate">' .
                            $value['pubDate']->format('Y-M-d') . '
                        </div>
                    </li>';

            echo $fila . '<br>';

            $html = $html . $fila;
        }

        $html = $html . '</ul>';

        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'text/html');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($html);
        return $respuesta;
        */
    }

    public function monitoreoAction() {
        $fecha = new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $s = $em->createQuery(
                'SELECT m
                  FROM SupportBundle:Monitoreo m
                  WHERE m.pubdate=:pubdate AND m.ext!=1');
        $s->setParameter('pubdate', $fecha->format('Y-m-d'));
        $n = $s->getResult();
        return $this->render('SupportBundle:Default:monitoreo.html.twig', array('noticias' => $n));
    }
	public function testMailAction() {
	$this->sendMail('irra_b@yahoo.es');
$respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'text/html');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($n);
        return $respuesta;
    }


}
