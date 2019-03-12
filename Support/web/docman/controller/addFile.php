<?php
require_once '../lib/db.php';
require_once '../lib/folder.php';
require_once '../lib/group.php';
date_default_timezone_set('America/La_Paz');
$fecha=date('Y-m-d H:i:s');
session_start();
$p= folder::getPathByIDFolder($_SESSION['currentpath']);
$f=new folder('', $_POST['name'], $p,$_SESSION['currentpath'], $fecha);
echo $g->addFolder($f);
?>