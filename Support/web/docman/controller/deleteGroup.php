<?php
require_once '../lib/db.php';
require_once '../lib/group.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$g=group::getGroupByID($_POST['idg']);
if($g->delete()=='1')
{
    echo 'Eliminado<br><button class="button" onclick="cerrar();">Aceptar</button>';
}else
{
    echo 'error';
}
?>
