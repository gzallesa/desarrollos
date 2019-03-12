<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
require_once '../lib/group.php';
if(user::deleteUser($_POST['idu'])==1)
{
    echo 'Eliminado.<br><button class="button" onclick="cerrar();">Aceptar</button>';
}else
{
    echo 'error al eliminar';
}
?>
