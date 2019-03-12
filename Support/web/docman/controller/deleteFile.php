<?php
require_once '../lib/db.php';
require_once '../lib/folder.php';
require_once '../lib/group.php';
$f=  file::getFileById($_POST['idf']);
if($f->deleteFile())
{
    echo 'Documento eliminado<br><button class="button" onclick="cerrar();">Aceptar</button>';
}
?>
