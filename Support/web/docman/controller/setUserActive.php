<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$u=user::getUserByID($_POST['idu']);
echo $u->setActive('1');
?>
