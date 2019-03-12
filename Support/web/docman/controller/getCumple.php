<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
$u=user::getUserByID($_POST['idu']);
echo '<img src="images/backcumple.png"><div class="cumpletext">';
echo $u->getName().'</div>';
?>
