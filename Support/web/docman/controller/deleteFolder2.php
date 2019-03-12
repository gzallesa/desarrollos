<?php
require_once '../lib/db.php';
require_once '../lib/folder.php';
require_once '../lib/group.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//$g=group::getGroupByName('Departamento de Sistemas');
$f=  folder::getFolderById($_POST['idf']);
if($f->trueDeleteFolder())
{
    echo 'Directorio eliminado<br><button class="button" onclick="cerrar();">Aceptar</button>';
}
?>
