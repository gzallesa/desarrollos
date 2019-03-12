<?php
require_once '../lib/db.php';
require_once '../lib/event.php';
require_once '../lib/collection.php';
$e=event::getEvents();
$f=$e->getElement(0)->getFecha();
$f=explode(' ', $f);
echo $e->getElement(0)->getIde().'|'.$f[0].'|'.$f[1].'|'.$e->getElement(0)->getEvent();
//echo $e->getElement(0)->getFecha();
?>
