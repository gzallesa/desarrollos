<?php
require_once '../lib/db.php';
require_once '../lib/group.php';
require_once '../lib/user.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//exit();
if(group::updateUserGroup($_POST['idg'], $_POST['idu']))
{
    echo 'Guardado<br><button class="button" onclick="cerrar();">Aceptar</button>';
}
?>
