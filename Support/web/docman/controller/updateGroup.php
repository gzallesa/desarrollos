<?php
require_once '../lib/db.php';
require_once '../lib/group.php';
require_once '../lib/folder.php';
require_once '../lib/user.php';
session_start();
if(!preg_match("/^[[:alnum:]\ \-\_]+$/", $_POST['newname']))
{
    echo 'Nombre de grupo invalido...<br><button class="button" onclick="cerrar();">Aceptar</button>';
    exit();
}
if($_SESSION['user']->getUserType1()!='0')
{
    echo 'No tiene permisos para crear Grupos';
    exit();
}
$g=group::getGroupByID($_POST['idg']);
$f=folder::getFolderById($g->getFolderID());
$g->setLongName($_POST['newname']);
$f->setName($_POST['newname']);
if($g->updateGroup()AND $f->renameFolder())
{
    echo 'Guardado<br><button class="button" onclick="cerrar();">Aceptar</button>';
}?>
