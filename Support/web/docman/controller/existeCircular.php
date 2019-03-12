<?php
require_once '../lib/db.php';
require_once '../lib/group.php';
require_once '../lib/folder.php';
require_once '../lib/fecha.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set('America/La_Paz');
$col=new collection();
$circulares=new collection();
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
    $col->addCollection($circulares->getElement($i)->getFilesByDate(date('Y-m-d')));
}
$opt='2000-01-01 12:00:00';
$o=-1;
for($i=0;$i<$col->length();$i++)
{
    if($col->getElement($i)->getDateCreation()>$opt)
    {
        $o=$i;
        $opt=$col->getElement($i)->getDateCreation();
    }
}
if($o!=-1)
{
    echo 'docman/rootfolder/'.$col->getElement($o)->getPathFile().'/'.$col->getElement($o)->getFileName();
}else
{
    echo 'no';
}
    
?>
