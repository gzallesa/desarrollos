<?php
require_once '../lib/db.php';
require_once '../lib/folder.php';
require_once '../lib/group.php';
session_start();
$var=trim($_POST['newname']);
if(!preg_match("/^[[:alnum:]\ \-\_]+$/", $var))
{
    echo 'Nombre de directorio invalido<br><button class="button" onclick="cerrar();">Aceptar</button>';
    exit();
}
$g=group::getGroupByIdFolder($_SESSION['path']);
if($g->renameFolder($_POST['idf'],$_POST['newname'])=='1')
{
    echo 'Directorio renombrado...<br><button class="button" onclick="cerrar();">Aceptar</button>';
}else
{
    echo '0';
}

?>
