<?php
require_once '../lib/db.php';
require_once '../lib/folder.php';
require_once '../lib/group.php';
require_once '../lib/user.php';
session_start();
$var=trim($_POST['name']);
if(!preg_match("/^[[:alnum:]\ \-\_]+$/", $var))
{
    echo 'Nombre de directorio invalido<br><button class="button" onclick="cerrar();">Aceptar</button>';
    exit();
}
$g=folder::getFolderById($_SESSION['currentpath']);
if($g->isGroupFolder() and $g->getIDF()!=$_SESSION['path'])
{
    echo 'No tiene permisos para crear directorios en esta carpeta...';
    exit();
}
date_default_timezone_set('America/La_Paz');
$fecha=date('Y-m-d H:i:s');
$p= folder::getPathByIDFolder($_SESSION['currentpath']);
$f=new folder('', $_POST['name'], $p,$_SESSION['currentpath'], $fecha,$_SESSION['user']->getIDU());
if($g->addFolder($f)=='1')
{
    echo 'Directorio creado...<br><button class="button" onclick="actualizar();">Aceptar</button>';
}else
{
    echo '0';
}
?>
