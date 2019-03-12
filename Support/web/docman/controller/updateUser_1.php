<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
require_once '../lib/group.php';
session_start();
date_default_timezone_set('America/La_Paz');
$fecha=date('Y-m-d H:i:s');
$u=new user($_GET['idu'], $_GET['nombre'], '','', $_GET['password'], $_GET['movil'], $_GET['interno'], $_GET['ci'], '', '', '','',$_GET['telefono'],$_GET['direccion'],$_GET['referencia'],$_GET['seguro']);
if($u->updateUser2()==1)
{
    echo 'Se guardaron los cambios.<br><button class="button" onclick="cerrar();">Aceptar</button>';
}

?>
