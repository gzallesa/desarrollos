<?php
require_once '../lib/db.php';
require_once '../lib/group.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$g=group::getGroups();
echo '
            <form onsubmit="return false" id="frmuser">'.
            '<table  class="newUser">'.
            '<tr><td>Nombre(s) y Apellido(s):</td><td><input type="text" name="nombre" onchange="verifica(this,0);" onkeyup="verifica(this,0);"></td></tr>'.
            '<tr><td>CI:</td><td><input type="text" name="ci" onchange="verifica(this,3);" onkeyup="verifica(this,3);"></td></tr>'.
            '<tr><td>E-mail:</td><td><input type="text" name="email" onchange="verifica(this,2);" onkeyup="verifica(this,2);"></td></tr>'.
            '<tr><td>Nombre de usuario:</td><td><input type="text" name="username" onchange="verifica(this,0);" onkeyup="verifica(this,0);"></td></tr>'.
            '<tr><td>Contrase&ntilde;a:</td><td><input id="pass2" type="password" name="password" onkeyup="verifica(this,4);"></td></tr>'.
            '<tr><td>Confirme:</td><td><input type="password" onkeyup="verifica2(this,pass2);"></td></tr>'.
            '<tr><td>Telefono:</td><td><input type="text" name="telefono"  onchange="verifica(this,5);" onkeyup="verifica(this,5);"></td></tr>'.
            '<tr><td>Movil:</td><td><input type="text" name="movil"  onchange="verifica(this,6);" onkeyup="verifica(this,6);"></td></tr>'.
            '<tr><td>#Seguro:</td><td><input type="text" name="seguro"  onchange="verifica(this,1);" onkeyup="verifica(this,1);"></td></tr>'.
            '<tr><td>Direcci&oacute;n:</td><td><input type="text" name="direccion"  onchange="verifica(this,1);" onkeyup="verifica(this,1);"></td></tr>'.
            '<tr><td>Telefono Referencia:</td><td><input type="text" name="referencia"  onchange="verifica(this,5);" onkeyup="verifica(this,5);"></td></tr>'.
            '<tr><td>Interno:</td><td><input type="text" name="interno"  onchange="verifica(this,1);" onkeyup="verifica(this,1);"></td></tr>'.
            '<tr><td>Grupo:</td><td><select name="grupo" style="width:100%;">';
            for($i=0;$i<$g->length();$i++)
            {
                echo '<option value="'.$g->getElement($i)->getIDG().'">'.$g->getElement($i)->getLongName().'</option>';
            }
            echo '</select></td></tr>'.
            '<tr><td>Cuenta habilitada:</td><td><input name="state" checked type="checkbox" style="float:left"></td></tr>'.
            '<tr><td>Es Administrador:</td><td><input name="isadmin" type="checkbox" style="float:left"></td></tr>'.
            '<tr><td></td><td><button class="button" onclick="registrarUsuario();">Registrar</button><button class="button" onclick="cerrar();">Cancelar</button></td></tr>'.
            '</table></form>';
    
?>
