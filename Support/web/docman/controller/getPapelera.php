<?php
require_once '../lib/db.php';
require_once '../lib/file.php';
require_once '../lib/folder.php';
require_once '../lib/fecha.php';
require_once '../lib/collection.php';
require_once '../lib/user.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$_SESSION['currentpath']=$_SESSION['path'];
$c=file::getFilesRecicled($_SESSION['user']->getIDU());

$folder=folder::getFolderById($_SESSION['path']);
echo '<tr><th class="path">';
echo '<div><a href="javascript:openfolder('.$folder->getIDF().');">'.$folder->getName().'</a></div><img src="images/bc_separator.png" style="float:left;">';
echo '<div><a href="#">Papelera'.$c->length().' archivos</a></div><img src="images/bc_separator.png" style="float:left;">';
echo '</th></tr>';
for($i=0;$i<$c->length();$i++)
{
    $f=$c->getElement($i);
    $u=user::getUserByID($f->getUser());
    $fecha=new fecha($f->getDateCreation());
    $f1=$fecha->getDay().'/'.$fecha->getLiteralMonth().'/'.$fecha->getYear().' Hrs:'.$fecha->getTime();
    echo '<tr><td><div style="float:left"><input type="checkbox" style="float:left;"><div class="'.$f->getFileExt().'"></div><a href="javascript:openfile('.$f->getIDF().');">'.$f->getFileName().'</a>';
    echo '<div class="description"><span>Fecha de Creaci&oacute;n:</span>'.$f1.' <span>Cargado Por:</span>'.$u->getName().' <span>Tama&ntilde;o:</span>'.round($f->getFileSize()/1024,2).'Kb</div></div>';
    echo '<div style="float:right;">';
    echo '<button class="icons2" title="Eliminar" onclick="deletefile('.$f->getIDF().');"><div class="deletefolder"></div></button>';
    echo '<button class="icons2" title="Recuperar" onclick="restaurar('.$f->getIDF().');"><div class="restaurar"></div></button>';
    echo '<button class="icons2" title="Descargar" onclick="download('.$f->getIDF().');"><div class="download"></div></button></div></td></tr>';
    
}
?>