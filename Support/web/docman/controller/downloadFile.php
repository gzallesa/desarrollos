<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
require_once '../lib/file.php';
require_once '../lib/folder.php';
require_once '../sessionCheck.php';
require_once '../lib/mimetype.php';
require_once '../lib/download.php';
date_default_timezone_set('America/La_Paz');
$fecha=date('Y-m-d H:i:s');
$file= file::getFileById($_GET['idf']);
$f='../rootfolder/'.$file->getPathFile().'/'.$file->getFileName();
header('Content-Disposition: attachment; filename="'.$file->getFileName().'"');
$m=new mimetype($file->getFileName());
header('Content-type:'.$m->getMimeType());
readfile($f);
$d=new download($_SESSION['user']->getIdu(), $_GET['idf'], $fecha);
$d->save();
?>
