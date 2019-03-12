<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
require_once '../lib/group.php';
session_start();
date_default_timezone_set('America/La_Paz');
$fecha=date('Y-m-d H:i:s');
if($_GET['state']=='true')
{
    $e=1;
}else{
    $e=0;
}
if($_GET['isadmin']=='true')
{
    $e2=1;
}else{
    $e2=2;
}
$u=new user('', $_GET['nombre'], $_GET['email'],$_GET['username'], $_GET['password'], $_GET['movil'], $_GET['interno'], $_GET['ci'], $fecha, '', $e,$e2,$_GET['telefono'],$_GET['direccion'],$_GET['referencia'],$_GET['seguro']);
$u->saveUser();
if($_SESSION['user']->getUserType1()=='1')
{
    $g=group::getGroupByIdFolder($_SESSION['path']);
    $g->setUserGroup($g->getIDG(), $u->getIDU());
    echo 'Usuario agregado...<br><button class="button" onclick="cerrar();"></button>';
}
?>
