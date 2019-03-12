<?php
require_once '../lib/db.php';
require_once '../lib/group.php';
require_once '../lib/user.php';
$g=group::getGroups();
$u=user::getUserByID($_POST['idu']);
echo '<div style="font-size:15px;">';
echo 'Usuaro:'.$u->getName().'<br>Grupo:'.$u->getGroup().'<br>';
echo 'Reasignar A:<br>';
echo '<select id="selg" name="selg">';
for($i=0;$i<$g->length();$i++)
{
    $group=$g->getElement($i);
    echo '<option value="'.$group->getIDG().'">'.$group->getLongName().'</option>';
}
echo '</select><br>';
echo '<button class="button" onclick="reAsignar('.$u->getIDU().');">Aceptar</button>';
echo '<button class="button" onclick="cerrar();">Cancelar</button>
      </div>';
?>
