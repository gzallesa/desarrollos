<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
$u=user::getUsersBirthDaysNow();
echo '<img src="images/backcumple.png"><div class="cumpletext">';
for($i=0;$i<$u->length();$i++)
{
    echo $u->getElement($i)->getElement(1).' ';
}
echo '</div>';
?>
