<?php
require_once '../lib/db.php';
require_once '../lib/file.php';
require_once '../lib/group.php';
$var=trim($_POST['newname']);
if(!preg_match("/^[[:alnum:]\ \-\_]+$/", $var))
{
    echo 'Nombre de archivo invalido<br><button class="button" onclick="cerrar();">Aceptar</button>';
    exit();
}$f=file::getFileById($_POST['idf']);
if(rename('../rootfolder/'.$f->getPathFile().'/'.$f->getFileName(), '../rootfolder/'.$f->getPathFile().'/'.$_POST['newname'].'.'.$f->getFileExt()))
{
    if($f->rename($_POST['newname'].'.'.$f->getFileExt()))
    {
        echo 'Renombrado<br><button class="button" onclick="actualizar();">Aceptar</button>';
    }else
    {
        echo 'Error al renombrar archivo.';
    }
} else
{
    echo 'Error al renombrar archivo.';
}

?>
