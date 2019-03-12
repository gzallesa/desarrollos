<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
require_once '../lib/group.php';
session_start();
date_default_timezone_set('America/La_Paz');
$fecha=date('Y-m-d H:i:s');
$u=user::getUserById($_POST['idu']);
echo '
<div>Puede modificar los datos personales o contrase&ntilde;a</div>
<form onsubmit="return false;" id="frmuser" >
            <table class="newUser">
            <tr><td>Nombre(s) y Apellido(s):</td><td><input disabled type="text" name="nombre" value="'.$u->getName().'"  onchange="verifica(this,0);" onkeyup="verifica(this,0);"></td></tr>
            <tr><td>CI:</td><td><input disabled  type="text" name="ci" value="'.$u->getCI().'"  onchange="verifica(this,3);" onkeyup="verifica(this,3);"></td></tr>
            <tr><td>Contrase&ntilde;a</td><td><input type="password" id="pass2" name="password" value="'.$u->getPassword().'"  onchange="verifica(this,4);" onkeyup="verifica(this,4);"></td></tr>
            <tr><td>Confirme:</td><td><input type="password" value="'.$u->getPassword().'" onkeyup="verifica2(this,pass2);"></td></tr>
            <tr><td>Tel&eacute;fono:</td><td><input type="text" name="telefono" value="'.$u->getTelefono().'"  onchange="verifica(this,5);" onkeyup="verifica(this,5);"></td></tr>
            <tr><td>M&oacute;vil:</td><td><input type="text" name="movil" value="'.$u->getMovil().'"  onchange="verifica(this,6);" onkeyup="verifica(this,6);"></td></tr>
            <tr><td>#Seguro:</td><td><input type="text" name="seguro" value="'.$u->getNumSegMed().'"  onchange="verifica(this,1);" onkeyup="verifica(this,1);"></td></tr>
            <tr><td>Direcci&oacute;n:</td><td><input type="text" name="direccion" value="'.$u->getDireccion().'"  onchange="verifica(this,1);" onkeyup="verifica(this,1);"></td></tr>
            <tr><td>Tel&eacute;fono Referencia:</td><td><input type="text" name="referencia" value="'.$u->getTelRef().'"  onchange="verifica(this,5);" onkeyup="verifica(this,5);"></td></tr>
            <tr><td>Interno:</td><td><input type="text" name="interno" value="'.$u->getInterno().'"  onchange="verifica(this,1);" onkeyup="verifica(this,1);"></td></tr>
            <tr><td></td><td><button class="button" onclick="actualizarDatos('.$u->getIDU().');" disabled  >Guardar Cambios</button><button class="button" onclick="cerrar();">Cancelar</button></td></tr>
            </table></form>    
';
?>
