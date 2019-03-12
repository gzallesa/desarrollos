<?php
require_once '../lib/db.php';
require_once '../lib/collection.php';
require_once '../lib/event.php';
require_once '../lib/user.php';
session_start();
$a=event::getEventsGroupAll($_SESSION['user']->getIdGroup());
date_default_timezone_set('America/La_Paz');
echo '[';
for($i=0;$i<$a->length();$i++)
{
    $micro= new DateTime($a->getElement($i)->getFecha().' '.$a->getElement($i)->getHora());
    $d=$micro->getTimestamp()*1000;
    if($i==$a->length()-1)
    {
        echo '{ "date": "'.$d.'", "type": "meeting", "title": "'.strtoupper($a->getElement($i)->getEvent()).'", "description": "'.$a->getElement($i)->getDescription().'", "url": "#"}';
    }else
    {
        echo '{ "date": "'.$d.'", "type": "meeting", "title": "'.$a->getElement($i)->getEvent().'", "description": "'.$a->getElement($i)->getDescription().'", "url": "#"},';
    }   
}
echo ']';
header('Content-type: text/json');
/*echo '[';
  echo '{ "date": "1350532800000", "type": "meeting", "title": "Firma de Contrato", "description": "El 18 de Octubre del presente a&ntilde;o se firma el contrato con xxx a Hrs 14:30 en palacio.", "url": "#"},';
  echo '{ "date": "1350757800000", "type": "meeting", "title": "Prueba", "description": "test test nada mas<br>ksjdhfkjsdhf ksjdhfk jsdfh k","url": "#"}';
echo ']';*/
?>