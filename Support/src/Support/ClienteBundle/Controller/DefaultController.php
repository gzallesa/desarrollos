<?php

namespace Support\ClienteBundle\Controller;

use DateTime;
use SoapClient;
use Support\SupportBundle\Entity\DocmanContenido;
use Support\SupportBundle\Entity\DocmanOficina;
use Support\SupportBundle\Entity\DocmanProblema;
use Support\SupportBundle\Entity\DocmanSolicitud;
use Support\SupportBundle\Entity\DocmanUser;
use Support\SupportBundle\Entity\Evento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function comunicadosPagAction()
    {
        $r = $this->getRequest();
        $pag = $r->get('pagina');
        $pag = $pag - 1;
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
            'SELECT c.id,c.titulo,c.descripcion,c.url,c.fechaPub,u.foto,u.ci
                  FROM SupportBundle:DocmanContenido c JOIN c.usuario u
                  WHERE c.tipo=:id
                  Order By c.fechaPub desc');
        $q->setParameter('id', '2');
        $q->setFirstResult($pag * 8);
        $q->setMaxResults(8);
        $comunicados = $q->getResult();
        $c = '';
        foreach ($comunicados as $comunicado) {
            $c = $c . '<li>
                            <div class="contentbox2">
                                <div style="position:absolute;">
                                    <div class="titulobox">
                                        <span><i class="fa fa-comments-o fa-1x"></i> ' . strtoupper($comunicado['titulo']) . '
                                        </span>    
                                    </div>
                                    <div class="line"></div>';
            if ($comunicado['url'] != null) {
                $c = $c . '<div class="piec">
                                            <a target="_blank" href="uploads/' . $comunicado['url'] . '">
                                                <i class="fa fa-eye fa-3x"></i>
                                            </a>
                                        </div>';
            }
            $c = $c . '</div> 
                                <div style=" margin-top: 25px">
                                    <div class="textbox">
                                        <img style="border-radius:3px;margin:3px;width:50px;float:left;" src="http://siemi.oopp.gob.bo/doccargados/rrhh/' . $comunicado['ci'] . '/FOTOS/' . $comunicado['foto'] . '"/>
                                        <div style="width:325px;float:left;">
                                            <div style="float:left;margin-top:15px;z-index:100">
                                                <img  src="bundleCliente/css/images/f.png"/>
                                            </div>   
                                            <div class="contenidotexto">
                                                <div><cite>' . $comunicado['fechaPub']->format('d-m-Y') . '</cite></div>
                                                ' . strtoupper($comunicado['descripcion']) . '
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </li>';
        }
        $q = $em->createQuery(
            'SELECT count(c)
                  FROM SupportBundle:DocmanContenido c 
                  WHERE c.tipo=:id
                  Order By c.fechaPub desc');
        $q->setParameter('id', '2');
        $cont = $q->getSingleScalarResult();
        $cont = $cont / 8;
        if (is_float($cont)) {
            $cont = intval($cont) + 1;
        }
        $c = $c . '<li style=" text-align: center">
                        <ul class="pagination">
                            <li><a href="#">&laquo;</a></li>';
        for ($i = 0; $i < 10/*$cont*/; $i++) {
            if ($i == $pag) {
                $c = $c . '<li class="active"><a href="#">' . ($i + 1) . '</a></li>';
            } else {
                $c = $c . '<li><a href="javascript:getContent(' . ($i + 1) . ');">' . ($i + 1) . '</a></li>';
            }
        }
        $c = $c . '<li><a href="javascript:getContent(10);">&raquo;</a></li>
                        </ul>
                    </li>';
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'text/html');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($c);
        return $respuesta;
    }

    public function indexAction()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $fecha = new \DateTime();
        //var_dump($fecha->format('Y-m-d'));
        $em = $this->getDoctrine()->getManager();
        $solicitante = new DocmanUser();
        $q = $em->createQuery(
            'SELECT u
                 FROM SupportBundle:DocmanUser u
                 WHERE u.ip=:ip OR u.ip2=:ip');
        $q->setParameter('ip', $ip);
        $solicitante = $q->getResult();
        
        if (!$solicitante) {

            $q = $em->createQuery(
                        'SELECT u
                         FROM SupportBundle:DocmanUser u
                         WHERE u.ip=:ip OR u.ip2=:ip');
                $q->setParameter('ip', '10.0.6.31');
                $solicitante=$q->getResult();

            return $this->render('ClienteBundle:Default:notfound.html.twig', array(
                'ip' => $ip,
            ));
        }

        $p = new DocmanProblema();
        $p = $em->getRepository('SupportBundle:DocmanProblema')->findAll();
        //enlaces
        $q = $em->createQuery(
            'SELECT c
                  FROM SupportBundle:Enlaces c');
        $enlaces = $q->getResult();
        //video
        $q = $em->createQuery(
            'SELECT c
                  FROM SupportBundle:DocmanContenido c 
                  WHERE c.tipo=:id
                  Order By c.fechaPub desc');
        $q->setParameter('id', '4');
        $video = $q->getResult();
        //Anuncios
        $q = $em->createQuery(
            'SELECT c
                  FROM SupportBundle:DocmanContenido c 
                  WHERE c.tipo=:id
                  AND c.fechaLimite >= :fecha Order By c.fechaPub desc');
        $q->setParameter('id', '1');
        $q->setParameter('fecha', $fecha->format('Y-m-d'));
        $anuncios = $q->getResult();
        //Comunicados circulares etc.
        $q = $em->createQuery(
            'SELECT c
                  FROM SupportBundle:DocmanContenido c 
                  WHERE c.tipo=:id
                  Order By c.fechaPub desc');
        $q->setParameter('id', '2');
        /* Paginado de Comunicados        
        $q->setFirstResult(0);
        $q->setMaxResults(8);
        */
        $comunicados = $q->getResult();
        //solicitud
        $q = $em->createQuery(
            'SELECT count(p)as n,c.idp,p.id
                  FROM SupportBundle:DocmanSolicitud p JOIN p.problema c 
                  WHERE p.solicitante=:id
                  AND p.estado=0 group by p.problema order by c.idp')->setParameter('id', $solicitante[0]->getId());
        $sol = $q->getResult();
        //Cumpleañero de hoy
        $c = $em->createQuery(
            'SELECT u
                  FROM SupportBundle:DocmanUser u 
                  WHERE u.fechanac LIKE :fecha
                  AND u.state=1')->setParameter('fecha', '%' . $fecha->format('m') . '-' . $fecha->format('d'));
        $cumple = $c->getResult();
        $q = $em->createQuery(
            'SELECT count(c)
                  FROM SupportBundle:DocmanContenido c 
                  WHERE c.tipo=:id
                  Order By c.fechaPub desc');
        $q->setParameter('id', '2');
        $cont = $q->getSingleScalarResult();
        $cont = $cont / 8;
        if (is_float($cont)) {
            $cont = intval($cont) + 1;
        }
        $pag = '<ul class="pagination">
                            <li><a href="#">&laquo;</a></li><li class="active"><a href="#">1</a></li>';
        for ($i = 1; $i < 10/*$cont*/; $i++) {
            $pag = $pag . '<li><a href="javascript:getContent(' . ($i + 1) . ');">' . ($i + 1) . '</a></li>';
        }
        $pag = $pag . '<li><a href="#">&raquo;</a></li>
                        </ul>';
        /*
        $sql_popup_intranet = " SELECT 
                                    *
                                FROM
                                    docman.docman_intranet_popup
                                WHERE
                                    (DATE_FORMAT(Fecha_Publicar, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d'))
                                        AND (Estado = 1)
                                ORDER BY Fecha_Publicar DESC;";
        */
        $sql_popup_intranet = " SELECT 
                                    Titulo,
                                    Texto,
                                    Estado,
                                    image_url,
                                    DATE_FORMAT(Fecha_Publicar, '%Y-%m-%d') AS fecha_inicio_publicacion,
                                    DATE_ADD(DATE_FORMAT(Fecha_Publicar, '%Y-%m-%d'),
                                        INTERVAL dias DAY) AS fecha_fin_publicacion,
                                    dias
                                FROM
                                    docman.docman_intranet_popup
                                WHERE
                                    Estado = 1
                                HAVING (DATE_FORMAT(NOW(), '%Y-%m-%d') >= fecha_inicio_publicacion)
                                    AND (DATE_FORMAT(NOW(), '%Y-%m-%d') BETWEEN fecha_inicio_publicacion AND fecha_fin_publicacion)
                                ORDER BY ID DESC;";

        $em_popup_intranet = $this->getDoctrine()->getManager();
        $stmt_popup_intranet = $em_popup_intranet->getConnection()->prepare($sql_popup_intranet);
        $stmt_popup_intranet->execute();

        return $this->render('ClienteBundle:Default:index.html.twig', array(
            'usuario' => $solicitante[0],
            'solicitudes' => $sol,
            'problemas' => $p,
            'cumple' => $cumple,
            'rss' => $this->monitoreo(),
            'anuncio' => $anuncios,
            'comunicados' => $comunicados,
            'videos' => $video,
            'enlaces' => $enlaces,
            'documentos' => $this->getDocumentos(),
            'forms' => $this->getForms(),
            'pag' => $pag,
            'popup_intranet' => $stmt_popup_intranet->fetchAll(),
        ));
    }

    private function enviaSms($numero, $msg)
    {
        $fp = fopen('uploads/data.txt', 'a+');
        $url = "http://172.16.0.19/api/enviar";
        $ch = curl_init($url);
        $data = array();
        $jsonData = array(
            'numero' => $numero,
            'mensaje' => $msg
        );
        array_push($data, $jsonData);
        $jsonDataEncoded = json_encode($data);
        fwrite($fp, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        fwrite($fp, $result);
        fclose($fp);
    }

    public function enviarAction()
    {
        $r = $this->getRequest();
        $p = $r->get('p');
        $ip = $_SERVER['REMOTE_ADDR'];
        $em = $this->getDoctrine()->getManager();
        $solicitante = new DocmanUser();
        $pr = new DocmanProblema();
        $pr = $em->getRepository('SupportBundle:DocmanProblema')->findOneBy(array('idp' => $p));
        $q = $em->createQuery(
            'SELECT u
                 FROM SupportBundle:DocmanUser u
                 WHERE u.ip=:ip OR u.ip2=:ip');
        $q->setParameter('ip', $ip);
        $solicitante = $q->getResult();
        //$id = $em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('id' => $solicitante->getDependeDe()));
        //$soporte = $em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('id' => $id));
        $s = new DocmanSolicitud();
        $s->setSolicitante($solicitante[0]);
        $s->setHoraSolicitud(new \DateTime());
        $s->setFechaSolicitud(new \DateTime());
        $s->setDescripcion('s');
        $s->setProblema($pr);
        $s->setPrioridad('1');
        $s->setEstado('0');
        $em->persist($s);
        $em->flush();
        $this->sendMail("gluna@oopp.gob.bo", $solicitante[0], $pr);
        $this->sendMail("irollano@oopp.gob.bo", $solicitante[0], $pr);
        ////$this->sendMail('marce@oopp.gob.bo', $solicitante[0], $pr);
        $this->notificar($solicitante[0], $solicitante[0], $pr);
        $html = 'Solicitud enviada';
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'text/html');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($html);
        return $respuesta;
    }

    private function notificar($soporte, $usuario, $pr)
    {
        $mensaje = 'Acabas de recibir una solicitud de soporte:';
        $mensaje .= 'NOMBRE : ' . $usuario->getName() . ' ';
        $mensaje .= 'CARGO : ' . $usuario->getCargo() . ' ';
        $mensaje .= 'DIRECCION : ' . $usuario->getDireccion() . ' ';
        $mensaje .= 'PROBLEMA : ' . $pr->getNombre() . ' ';
        //$this->enviaSms('60632665', $usuario->getName() . ' solicita soporte de ' . $pr->getNombre());
        //var_dump(shell_exec('java -jar xmpp2.jar "gluna@conferencias.oopp.gob.bo" "' . $mensaje . '"'));
        //var_dump(shell_exec('java -jar xmpp2.jar "gluna@conferencias.oopp.gob.bo" "' . $mensaje . '"'));
        var_dump(shell_exec('java -jar xmpp2.jar "irrollano@conferencias.oopp.gob.bo" "' . $mensaje . '"'));
    }

    private function sendMail($email, DocmanUser $usuario, DocmanProblema $pr)
    {
        if ($usuario->getFoto()) {
            $foto = 'http://siemi.oopp.gob.bo/doccargados/rrhh/' . $usuario->getCi() . '/FOTOS/' . $usuario->getFoto();
        } else {
            $foto = 'http://intranet.oopp.gob.bo/bundles/new-user.png';
        }
        $titulo = 'Solicitud de soporte del usuario:' . $usuario->getName();
        $mensaje = 'Acabas de recibir una solicitud de soporte del usuario:<br>' .
            '<img  style="width:50px;height:50px;border-radius:50%" src="' . $foto . '">' . $usuario->getName() . '-<cite>' . $usuario->getCargo() . '</cite><br>' .
            'DIRECCION: ' . $usuario->getDireccion() . '<br>' .
            'PROBLEMA: ' . $pr->getNombre() . '<br>';
        $headers = "From: HelpDesk@oopp.gob.bo\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        return mail($email, $titulo, $mensaje, $headers);
    }

    public function finalizarAction()
    {
        $r = $this->getRequest();
        $p = $r->get('ids');
        $codigo = $r->get('codigo');
        $em = $this->getDoctrine()->getManager();
        $s = new DocmanSolicitud();
        $u = new DocmanUser();
        $u = $em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('ci' => $codigo, 'type' => '3'));
        if ($u) {
            $s = $em->getRepository('SupportBundle:DocmanSolicitud')->findOneBy(array('id' => $p));
            $s->setHoraAtencion(new \DateTime());
            $s->setFechaSolucion(new \DateTime());
            $s->setEstado('1');
            $s->setSoporte($u);
            $em->persist($s);
            $em->flush();
            $html = 'Solicitud cerrada';
            $respuesta = new Response();
            $respuesta->headers->set('Content-Type', 'text/html');
            $respuesta->setStatusCode(200);
            $respuesta->setContent($html);
            return $respuesta;
        } else {
            $respuesta = new Response();
            $respuesta->headers->set('Content-Type', 'text/html');
            $respuesta->setStatusCode(200);
            $html = 'El soporte con ci:' . $codigo . ' no se encontra en el sistema.';
            $respuesta->setContent($html);
            return $respuesta;
        }
    }

    public function getUsersAction()
    {
        /*
        $em = $this->getDoctrine()->getManager();
        $usuario = new DocmanUser();
        $usuario = $em->createQuery(
                'SELECT p
                  FROM SupportBundle:DocmanUser p 
                  WHERE p.state=1
                  order by p.name');
        $usuarios = $usuario->getResult();
        $i = 1;
        $res = '[';
        foreach ($usuarios as $usuario) {

            $res = $res . '{"id":"' . $usuario->getId() . '",';
            $res = $res . '"interno":"' . trim($usuario->getInterno()) . '",';
            $res = $res . '"name":"' . trim($usuario->getName()) . '",';
            $res = $res . '"cargo":"' . trim($usuario->getCargo()) . '",';
            $res = $res . '"ci":"' . $usuario->getCi() . '",';
            $res = $res . '"ip":"' . $usuario->getIp() . '",';
            $res = $res . '"email":"' . $usuario->getEmail() . '",';
            $res = $res . '"telefono":"' . $usuario->getTelefono() . '",';
            $res = $res . '"movil":"' . $usuario->getMovil() . '",';
            $res = $res . '"direccion":"' . trim($usuario->getDireccion()) . '",';
            $res = $res . '"foto":"' . $usuario->getCi() . '/FOTOS/' . $usuario->getFoto() . '"';
            $res = $res . '},';
        }
        $res = substr($res, 0, strlen($res) - 1);
        $res = $res . ']';
        //var_dump($res);
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent($res);
        return $respuesta;
        */
        $em = $this->getDoctrine()->getManager();
        $usuario = new DocmanUser();
        $usuario = $em->createQuery(
            'SELECT p
                  FROM SupportBundle:DocmanUser p 
                  WHERE p.state=1
                  order by p.name');
        $usuarios = $usuario->getResult();
        $i = 1;
        $rows = array();
        foreach ($usuarios as $usuario) {

            $rows[] = array(
                'id' => $usuario->getId(),
                'interno' => trim($usuario->getInterno()),
                'name' => trim($usuario->getName()),
                'cargo' => trim($usuario->getCargo()),
                'ci' => $usuario->getCi(),
                'ip' => $usuario->getIp(),
                'email' => $usuario->getEmail(),
                'telefono' => $usuario->getTelefono(),
                'movil' => trim($usuario->getDireccion()),
                'direccion' => trim($usuario->getDireccion()),
                'foto' => $usuario->getCi() . '/FOTOS/' . $usuario->getFoto()
            );
        }
        //var_dump($res);
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setCharset('UTF-8');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($rows));
        return $respuesta;
    }

    private function getUserById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = new DocmanUser();
        $usuario = $em->getRepository('SupportBundle:DocmanUser')->find($id);
        return $usuario->getName();
    }

    public function listaAction()
    {
        return $this->render('ClienteBundle:Default:usuarios.html.twig');
    }

    public function sliderAction()
    {
        /* try {
          //$articulos = simplexml_load_string(file_get_contents('http://www.jornadanet.com/rss/Portada.xml'));
          //http://www3.abi.bo/rss/abi.xml
          $json = file_get_contents('http://www.oopp.gob.bo/index.php/getNews/banner');
          $v = json_decode($json);
          } catch (Exception $ex) {
          var_dump($ex);
          $v = null;
          } */
        $nombre_fichero = "import/noticias.json";
        $gestor = fopen($nombre_fichero, "r");
        $contenido = fread($gestor, filesize($nombre_fichero));
        $n = (json_decode($contenido));
        fclose($gestor);
        return $this->render('ClienteBundle:Default:slider.html.twig', array('news' => $n));
    }

    private function monitoreo()
    {
        /* $a = array();
          $b = array(
          'http://www3.abi.bo/rss/abi.xml',
          'http://www.jornadanet.com/rss/Portada.xml',
          'http://www.la-razon.com/rss/ciudades/',
          );
          try {
          $patron = '/teleférico|unasur|polideportivo|camino|caminos|abc|boa|sabsa|entel|ecobol|att/';
          foreach ($b as $value) {
          $articulos = simplexml_load_string(file_get_contents($value));
          foreach ($articulos->channel->item as $value2) {
          if (preg_match($patron, strtolower($value2->title))) {
          array_push($a, $value2);
          }
          }
          }
          } catch (Exception $ex) {
          $v = null;
          }
          return $a; */
        $nombre_fichero = "import/rss.json";
        $gestor = fopen($nombre_fichero, "r");
        $contenido = fread($gestor, filesize($nombre_fichero));
        $rss = (json_decode($contenido));
        fclose($gestor);

        return $rss;
    }

    private function isRelative($value)
    {

    }

    public function calendarAction()
    {
        return $this->render('ClienteBundle:Default:calendar.html.twig');
    }

    public function grillaAction()
    {
        return $this->render('ClienteBundle:Default:resoluciones.html.twig');
    }

    public function getEventsAction()
    {
        $fecha = new \DateTime('now');
        $em = $this->getDoctrine()->getManager();
        $usuario = new DocmanUser();
        $usuario = $em->createQuery(
            'SELECT p
                  FROM SupportBundle:DocmanUser p 
                  WHERE p.fechanac<>0000-00-00
                  AND p.state=1
                  order by p.fechanac');
        $usuarios = $usuario->getResult();
        $cc = array();
        $eventos = $this->getEventos();
        foreach ($usuarios as $usuario) {
            $dif = $fecha->format('Y') - $usuario->getFechanac()->format('Y');
            $usuario->getFechanac()->modify('+' . $dif . ' year');
            $usuario->getFechanac()->modify('+ 4 hour');
            //var_dump($usuario->getFechanac());
            $aa = array('date' => chr(32) . ($usuario->getFechanac()->getTimestamp() * 1000) . chr(32),
                'type' => 'meeting',
                'title' => $usuario->getName(),
                'description' => '<img class="cumplefoto" src="https://siemi.oopp.gob.bo/doccargados/rrhh/' . $usuario->getCi() . '/FOTOS/' . $usuario->getFoto() . '"/>',
                'url' => '#');
            array_push($cc, $aa);
        }
        foreach ($eventos as $evento) {

            $fecha2 = $evento->getFecha()->setTime($evento->getHora()->format('H'), $evento->getHora()->format('i'), $evento->getHora()->format('s'));
            $a = array(
                'date' => chr(32) . ($fecha2->getTimestamp() * 1000) . chr(32),
                'type' => 'event',
                'title' => $evento->getEvento(),
                'description' => $evento->getDescrip(),
                'url' => '#',
            );
            array_push($cc, $a);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($cc));
        /* /*$respuesta->setContent('[
          {"date":"1389844800000","type":"meeting","title":"Oscar Chavarria","description":"Tecnico en Proyectos","url":"#"},
          {"date":"1389844800000","type":"meeting","title":"Oscar Chavarria","description":"Tecnico en Proyectos","url":"#"}]'); */
        return $respuesta;
    }

    public function getComunicadosAction()
    {
        $fecha = new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
            'SELECT c.titulo,c.descripcion,c.url,c.id,c.fechaPub
                   FROM SupportBundle:DocmanContenido c 
                   WHERE c.tipo=:id
                   AND c.fechaLimite >= :fecha Order By c.fechaPub desc');
        $q->setMaxResults('1');
        $q->setParameter('id', '2');
        $q->setParameter('fecha', $fecha->format('Y-m-d'));
        $comunicados = $q->getResult();
        $a = array();
        foreach ($comunicados as $comunicado) {
            $b = array(
                'titulo' => $comunicado['titulo'],
                'descripcion' => $comunicado['descripcion'],
                'fecha' => $comunicado['fechaPub']->format('Y-m-d H:i:s'),
            );
            array_push($a, $b);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($a));
        return $respuesta;
    }

    public function resolucionesAction()
    {
        $fecha = new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
            'SELECT c
                   FROM SupportBundle:DocmanContenido c 
                   WHERE c.tipo=:id Order By c.fechaPub desc');
        $q->setParameter('id', '6');
        $comunicados = $q->getResult();
        $a = array();
        foreach ($comunicados as $comunicado) {
            $b = array(
                'id' => $comunicado->getId(),
                'titulo' => $comunicado->getTitulo(),
                'descripcion' => $comunicado->getDescripcion(),
                'fecha' => $comunicado->getFechaPub()->format('Y-m-d H:i:s'),
                'url' => $comunicado->getUrl(),
            );
            array_push($a, $b);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($a));
        return $respuesta;
    }

    public function getCumpleAction()
    {
        $fecha = new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $c = $em->createQuery(
            'SELECT u.name,u.cargo
                  FROM SupportBundle:DocmanUser u 
                  WHERE u.fechanac LIKE :fecha
                  AND u.state=1')->setParameter('fecha', '%' . $fecha->format('m') . '-' . $fecha->format('d'));
        $cumple = $c->getResult();
        $a = array();
        foreach ($cumple as $cc) {
            $b = array(
                'name' => $cc->getName(),
                'cargo' => $cc->getCargo(),
            );
            array_push($a, $b);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($a));
        return $respuesta;
    }

    public function getTickerAction()
    {
        $events = $this->getEventos();
        return $this->render('ClienteBundle:Default:newsticket.html.twig', array('eventos' => $events));
    }

    public function chatAction()
    {
        return $this->render('ClienteBundle:Default:chat.html.twig');
    }

    public function flipAction()
    {
        $nombre_fichero = "import/news.json";
        $gestor = fopen($nombre_fichero, "r");
        $contenido = fread($gestor, filesize($nombre_fichero));
        $n = (json_decode($contenido));
        fclose($gestor);
        return $this->render('ClienteBundle:Default:flip.html.twig', array('news' => $n));
    }

    private function getEventos()
    {
        $fecha = new \DateTime();
        $fecha2 = new \DateTime();
        $event = new Evento();
        $em = $this->getDoctrine()->getManager();
        $c = $em->createQuery(
            'SELECT e
                  FROM SupportBundle:Evento e 
                  WHERE e.fecha LIKE :fecha')->setParameter('fecha', '%' . $fecha->format('Y-m-d') . '%');
        $events = $c->getResult();
        return $events;
    }

    public function getEventosAction()
    {
        $fecha = new \DateTime();
        $event = new Evento();
        var_dump($fecha->format('Y-m-d'));
        $em = $this->getDoctrine()->getManager();
        $c = $em->createQuery(
            'SELECT e
                  FROM SupportBundle:Evento e 
                  WHERE e.fecha>=:fecha')->setParameter('fecha', $fecha->format('Y-m-d'));
        $events = $c->getResult();
        $a = array();
        foreach ($events as $event) {
            $b = array(
                'name' => $event->getEvento(),
                'fecha' => $event->getFecha()->format('Y-m-d'),
                'hora' => $event->getHora()->format('H:i'),
            );
            array_push($a, $b);
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->setStatusCode(200);
        $respuesta->setContent(json_encode($a));
        return $respuesta;
    }

    private function getDocumentos()
    {
        /*
        $fecha = new \DateTime();
        $doc = new DocmanContenido();
        $em = $this->getDoctrine()->getManager();
        $c = $em->createQuery(
                'SELECT e
                  FROM SupportBundle:DocmanContenido e 
                  WHERE e.tipo=6');
        //$c->setMaxResults(5);
        $doc = $c->getResult();
        */

        $sql = "SELECT 
                    *
                FROM
                    docman_contenido
                WHERE
                    (tipo = 6) AND (usuario_eliminacion IS NULL)
                ORDER BY id DESC;";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $doc = $stmt->fetchAll();

        return $doc;
    }

    private function getForms()
    {
        $doc = new DocmanContenido();
        $em = $this->getDoctrine()->getManager();
        $c = $em->createQuery(
            'SELECT e
                  FROM SupportBundle:DocmanContenido e 
                  WHERE e.tipo=7');
        $doc = $c->getResult();
        return $doc;
    }

    private function getTipoCambio()
    {
        $client4 = new SoapClient('http://ws01.bcb.gob.bo:8080/ServiciosBCB/indicadores?wsdl');
        $compra = ($client4->obtenerIndicador(array('codIndicador' => '1', 'codMoneda' => '34', 'fecha' => '15/05/2014')));
        $venta = ($client4->obtenerIndicador(array('codIndicador' => '1', 'codMoneda' => '35', 'fecha' => '15/05/2014')));
        $c = $compra->return;
        $v = $venta->return;
        return array('compra' => $c[4]->dato, 'venta' => $v[4]->dato);
    }

    public function serviceAction()
    {

        $client4 = new SoapClient('http://172.16.0.8/Services/services/Srrhh/SRecursos.asmx?WSDL', array('cache_wsdl' => WSDL_CACHE_NONE));
        $em = $this->getDoctrine()->getManager();
        $c = $em->createQuery(
            'SELECT e.datereg
                  FROM SupportBundle:DocmanUser e 
                  Order By e.datereg desc');
        $c->setMaxResults('1');
        $doc = $c->getResult();
        $fecha = $doc[0]['datereg'];
        var_dump($fecha->format('d-m-Y H:i:s'));
        $c = $client4->DatosFuncionario(array('strFechaModificacion' => $fecha->format('d-m-Y H:i:s')));
        var_dump(isset($c->DatosFuncionarioResult->Funcionarios));
        if (isset($c->DatosFuncionarioResult->Funcionarios)) {
            $f = $c->DatosFuncionarioResult->Funcionarios;
            echo 'COUNT' . count($f) . '<br>';
            if (count($f) > 1) {
                foreach ($f as $usuario) {
                    if ($this->existUser($usuario->Documento) == 0) {
                        echo 'INSERT1' . $usuario->Usuario . '<br>';
                        //var_dump($usuario->Foto);
                        $this->addUser($usuario);
                    } else {
                        echo 'EDIT1' . $usuario->Usuario . '<br>';
                        var_dump($usuario->IdOficina);
                        $this->editUser($usuario);
                    }
                }
            } else {
                if ($this->existUser($f->Documento) == 0) {
                    echo 'INSERT0' . $f->Usuario . '<br>';
                    //var_dump($usuario->Foto);
                    $this->addUser($f);
                } else {
                    echo 'EDIT0' . $f->Usuario . '<br>';
                    //var_dump($usuario->Foto);
                    $this->editUser($f);
                }
            }
        }
        $respuesta = new Response();
        $respuesta->headers->set('Content-Type', 'text/html');
        $respuesta->setStatusCode(200);
        $respuesta->setContent('');
        return $respuesta;
    }

    private function existUser($ci)
    {
        $doc = new DocmanUser();
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('ci' => $ci));
        return count($c);
    }

    private function getUserNameByCi($ci)
    {
        $doc = new DocmanUser();
        $em = $this->getDoctrine()->getManager();
        $doc = $em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('ci' => $ci));
        return $doc->getUsername();
    }

    private function getOficina($id)
    {
        $o = new DocmanOficina();
        $em = $this->getDoctrine()->getManager();
        $o = $em->getRepository('SupportBundle:DocmanOficina')->findOneBy(array('id' => $id));
        return $o;
    }

    private function addUser($user)
    {
        // Validar el Campo
        $user->Dependencia = $user->Dependencia != "" ? $user->Dependencia : "0";

        // Insertar Base de Datos
        $u = new DocmanUser();
        $fecha = new DateTime($user->FechaModificacion);
        $fechanac = new DateTime($user->FechaNacimiento);

        $em = $this->getDoctrine()->getManager();
        $u->setCi($user->Documento);
        $u->setUsername($user->Usuario);
        $u->setPassword('sistemas');
        if ($user->Interno) {
            $u->setInterno($user->Interno);
        } else {
            $u->setInterno('000');
        }
        $u->setName($user->Nombre);
        $u->setFechanac($fechanac);
        $u->setEmail($user->Mail);
        $u->setCargo($user->Cargo);
        $u->setNumseguro($user->Oficina);
        $u->setDependeDe($user->Dependencia);
        $u->setMovil($user->Movil);
        $u->setTelefono($user->Telefono);
        $u->setState($user->Estado);
        $u->setDatereg($fecha);
        $u->setLastaccess($fecha);
        $u->setType('2');
        $u->setDireccion($user->IdOficina);
        $u->setTelefref('0');
        if ($user->IdOficina) {
            $oficina = $this->getOficina($user->IdOficina);
            $u->setOficina($oficina);
        }
        if ($user->Ip) {
            $u->setIp($user->Ip);
        } else {
            $u->setIp('0.0.0.0');
        }
        $u->setFoto($user->Foto);
        $u->setSoporte('0');
        $em->persist($u);
        $em->flush();
        return;
        //$c=$em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('ci'=>$ci));
        //return count($c);
    }

    private function editUser($user)
    {
        $u = new DocmanUser();
        $fecha = new DateTime($user->FechaModificacion);
        $em = $this->getDoctrine()->getManager();
        $u = $em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('ci' => $user->Documento));
        //var_dump($user);
        if ($user->Usuario) {
            $u->setUsername($user->Usuario);
        }
        //$u->setPassword('sistemas');
        //$u->setInterno('000');
        if ($user->Interno) {
            $u->setInterno($user->Interno);
        }
        if ($user->Nombre) {
            $u->setName($user->Nombre);
        }
        if ($user->FechaNacimiento) {
            $fechanac = new DateTime($user->FechaNacimiento);
            $u->setFechanac($fechanac);
        }
        if ($user->Mail) {
            $u->setEmail($user->Mail);
        }
        if ($user->Cargo) {
            $u->setCargo($user->Cargo);
        }
        if ($user->IdOficina) {
            $oficina = $this->getOficina($user->IdOficina);
            $u->setOficina($oficina);
        }
        if ($user->Oficina) {
            $u->setDireccion($user->IdOficina);
        }
        if ($user->Oficina) {
            $u->setNumseguro($user->Oficina);
        }
        if ($user->Dependencia) {
            $u->setDependeDe($user->Dependencia);
        }
        if ($user->Movil) {
            $u->setMovil($user->Movil);
        }
        if ($user->Telefono) {
            $u->setTelefono($user->Telefono);
        }
        if ($user->Dependencia) {
            $u->setDireccion($user->Dependencia);
        }
        if ($user->Foto) {
            $u->setFoto($user->Foto);
        }
        if ($user->Ip) {
            $u->setIp($user->Ip);
        }
        $u->setState($user->Estado);
        $u->setDatereg($fecha);
        $em->persist($u);
        $em->flush();
        return;
        //$c=$em->getRepository('SupportBundle:DocmanUser')->findOneBy(array('ci'=>$ci));
        //return count($c);
    }

    // =========== SERVICIOS WEB - APK MOVIL 'ERP MOPSV' ===========
    /*
     * Get Contenido Intranet
     */
    public function getContenidoIntranetAction(Request $request, $limit, $offset)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $sqlStatement = $connection->prepare("CALL intranet_getContenido_appMovil('$limit','$offset');");
        $sqlStatement->execute();
        $result = $sqlStatement->fetchAll();

        $results = array(
            'rows' => $result
        );

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('content-type', 'application/json');
        $response->setContent(json_encode($results));
        return $response;
    }

    /*
     * Get Oficinas Intranet
     */
    public function getOficinasIntranetAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $sqlStatement = $connection->prepare("CALL intranet_getOficinas_appMovil();");
        $sqlStatement->execute();
        $result = $sqlStatement->fetchAll();

        $results = array(
            'rows' => $result
        );

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('content-type', 'application/json');
        $response->setContent(json_encode($results));
        return $response;
    }

    /*
     * Get Contenido por Oficina Intranet
     */
    public function getContenidoPorOficinaIntranetAction(Request $request, $idOficina, $limit, $offset)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $sqlStatement = $connection->prepare("CALL intranet_getContenidoPorOficina_appMovil('$idOficina','$limit','$offset');");
        $sqlStatement->execute();
        $result = $sqlStatement->fetchAll();

        $results = array(
            'rows' => $result
        );

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('content-type', 'application/json');
        $response->setContent(json_encode($results));
        return $response;
    }
    // ==============================================================
}
