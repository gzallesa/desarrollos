<?php
require_once '../lib/db.php';
require_once '../lib/collection.php';
require_once '../lib/event.php';
require_once '../lib/user.php';
require_once '../lib/fecha.php';
//session_start();
$a=event::getEventsGroupAll($_POST['idg']);
date_default_timezone_set('America/La_Paz');
for($i=0;$i<$a->length();$i++)
{
    $z=new fecha($a->getElement($i)->getFecha().' '.$a->getElement($i)->getHora());
    //$d=str_replace('-', '/', $a->getElement($i)->getFecha()).' a horas '.$a->getElement($i)->getHora();
    echo 'En fecha '.$z->getDay().' de '.$z->getLiteralLongMonth().' de '.$z->getYear().chr(13);
    echo $a->getElement($i)->getDescription().chr(13);
}
//header('Content-type: text/json');
/*echo '[';
  echo '{ "date": "1350532800000", "type": "meeting", "title": "Firma de Contrato", "description": "El 18 de Octubre del presente a&ntilde;o se firma el contrato con xxx a Hrs 14:30 en palacio.", "url": "#"},';
  echo '{ "date": "1350757800000", "type": "meeting", "title": "Prueba", "description": "test test nada mas<br>ksjdhfkjsdhf ksjdhfk jsdfh k","url": "#"}';
echo ']';*/
?>