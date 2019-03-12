<?php
require_once '../lib/db.php';
require_once '../lib/event.php';
require_once '../lib/user.php';
session_start();
$m=array("Enero"=>"01",
                 "Febrero"=>"02",
                 "Marzo"=>"03",
                 "Abril"=>"04",
                 "Mayo"=>"05",
                 "Junio"=>"06",
                 "Julio"=>"07",
                 "Agosto"=>"08",
                 "Septiembre"=>"09",
                 "Octubre"=>"10",
                 "Noviembre"=>"11",
                 "Diciembre"=>"12",);
$fecha=$_POST['fecha'];
if($_POST['public']=='true')
{
    $g='1';
}  else {
    $g='0';
}
if(strpos($fecha,'DATE')!==FALSE)
{
    $fecha=substr($fecha, 4);
    $d= explode("/",$fecha);
    $fecha=$d[2].'/'.$d[1].'/'.$d[0];
}else
{
    $d= explode("/",$_POST['fecha'] );
    $fecha=$d[2].'/'.$m[$d[0]].'/'.$d[1];
}
date_default_timezone_set('America/La_Paz');
$e=new event('', $fecha, $_POST['titulo'], $_POST['text'],$_POST['time'],$g,$_SESSION['user']->getIdGroup());
if($e->saveEvent())
{
    echo 'Evento guardado...';
}else
{
    echo 'Error al guardar...';
}
?>
