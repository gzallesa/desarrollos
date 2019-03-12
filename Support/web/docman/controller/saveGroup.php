<?php
require_once '../lib/db.php';
require_once '../lib/group.php';
require_once '../lib/user.php';
session_start();
if(!preg_match("/^[[:alnum:]\ \-\_]+$/", $_POST['name']))
{
    echo 'Nombre de grupo invalido...<br><button class="button" onclick="cerrar();">Aceptar</button>';
    exit();
}
if($_SESSION['user']->getUserType1()!='0')
{
    echo 'No tiene permisos para crear Grupos';
    exit();
}
date_default_timezone_set('America/La_Paz');
$fecha=date('Y-m-d H:i:s');
$f=new folder('', $_POST['name'], '', '0', $fecha,$_SESSION['user']->getIDU());
$f->saveFolder();
$g=new group('', $_POST['name'], $f->getIDF());
if($g->saveGroup())
{
    echo 'Grupo agregado<br><button class="button" onclick="cerrar();">Aceptar</button>';
}
?>
