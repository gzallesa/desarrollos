<?php
require_once '../lib/db.php';
require_once '../lib/folder.php';
$f=  folder::getFolderById($_POST['idf']);
echo '<form name="fp" id="fper" onsubmit="return false;"><table>';
echo '<tr><th></th><th>Usuarios</th><th>Grupos</th></tr>';
if($f->getPermissions()->getUsersRead())
{
    echo '<tr><td>Lectura:</td><td><input name="chk[]" type="checkbox" checked></td>';
}else
{
    echo '<tr><td>Lectura:</td><td><input name="chk[]" type="checkbox" ></td>';
}
if($f->getPermissions()->getGroupRead())
{
    echo '<td><input name="chk[]" type="checkbox" checked></td></tr>';
}else
{
    echo '<td><input name="chk[]" type="checkbox" ></td></tr>';
}
if($f->getPermissions()->getUsersWrite())
{
    echo '<tr><td>Escritura:</td><td><input name="chk[]" type="checkbox" checked></td>';
}else
{
    echo '<tr><td>Escritura:</td><td><input name="chk[]" type="checkbox" ></td>';
}
if($f->getPermissions()->getGroupWrite())
{
    echo '<td><input type="checkbox" name="chk[]" checked></td></tr>';
}else
{
    echo '<td><input type="checkbox" name="chk[]"></td></tr>';
}
if($f->getPermissions()->getUsersX())
{
    echo '<tr><td>Eliminar:</td><td><input name="chk[]" type="checkbox" checked></td>';
}else
{
    echo '<tr><td>Eliminar:</td><td><input name="chk[]" type="checkbox" ></td>';
}
if($f->getPermissions()->getGroupX())
{
    echo '<td><input type="checkbox" name="chk[]" checked></td></tr>';
}else
{
    echo '<td><input type="checkbox" name="chk[]"></td></tr>';
}
echo '<tr><td></td><td><button class="button" onclick="saveFPermissions('.$f->getIDF().');">Guardar</button></td><td><button class="button" onclick="cerrar();">Cancelar</button></td></tr>';
echo '</table></form>';
?>
