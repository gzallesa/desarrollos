<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
$u=user::getUserByID($_POST['idu']);
echo 'Feliz Cumplea&ntilde;os '.$u->getName().'<br>
      <img src="images/cumple.png">';
?>
