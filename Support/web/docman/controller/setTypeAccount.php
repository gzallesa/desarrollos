<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
$u=user::getUserByID($_POST['idu']);
if($u->getType()=='1')
{
    echo $u->setType('2');
}
if($u->getType()=='2'){
    echo $u->setType('1');    
}

?>
