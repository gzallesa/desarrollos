<?php
require_once '../lib/db.php';
require_once '../lib/group.php';
require_once '../lib/folder.php';
require_once '../lib/fecha.php';
require_once '../lib/collection.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$col=new collection();
$circulares=new collection();
date_default_timezone_set('America/La_Paz');
$r=group::getGroupByName('RRHH');
$d=group::getGroupByName('DGAA');
$s=group::getGroupByName('Sistemas');
$f=folder::getFolderById($r->getFolderID());
$f1=folder::getFolderById($d->getFolderID());
$f2=folder::getFolderById($s->getFolderID());
$c=$f->getFolderByName('circulares');
$c1=$f1->getFolderByName('circulares');
$c2=$f2->getFolderByName('circulares');
$circulares->addCollection($c);
$circulares->addCollection($c1);
$circulares->addCollection($c2);
for($i=0;$i<$circulares->length();$i++)
{
    $col->addCollection($circulares->getElement($i)->getFiles());
}
$opt='';
echo '[';
for($i=0;$i<$col->length();$i++)
{
    $f= new fecha($col->getElement($i)->getDateCreation());
    $fech=$f->getYear().'-'.$f->getMonth().'-'.$f->getDay();
    if($i<($col->length()-1))
    {
        $opt=',';
    }  else {
        $opt='';
    }
    if(date('Y-m-d')==$fech)
    {
        echo '{"url":"'.'docman/rootfolder/'.$col->getElement($i)->getPathFile().'/'.$col->getElement($i)->getFileName().'"}'.$opt;
        //echo ('docman/rootfolder/'.$col->getElement($i)->getPathFile().'/'.$col->getElement($i)->getFileName());
    }else
    {
        echo '{"url":"'.'docman/rootfolder/'.$col->getElement($i)->getPathFile().'/'.$col->getElement($i)->getFileName().'"}'.$opt;
    }
}
echo ']';
//header('Content-type: text/json');
//echo '{ "date": "1350532800000", "type": "meeting", "title": "Firma de Contrato", "description": "El 18 de Octubre del presente a&ntilde;o se firma el contrato con xxx a Hrs 14:30 en palacio.", "url": "#"},';

?>
