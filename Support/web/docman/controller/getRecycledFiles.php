<?php
require_once '../lib/db.php';
require_once '../lib/file.php';
require_once '../lib/folder.php';
require_once '../lib/fecha.php';
require_once '../lib/group.php';
require_once '../lib/collection.php';
require_once '../lib/user.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$_SESSION['currentpath']=$_POST['idf'];
$folder=folder::getFolderById($_POST['idf']);
echo '<tr><th class="path">';
$idf=NULL;
$pf=$folder;
$a=array();
$i=0;
while($pf->getParentFolder()>0)
{
    $idf=$pf->getIDF();
    $a[$i]='<div><a href="javascript:openRecycleFolder('.$idf.');">'.$pf->getName().'</a></div><img src="images/bc_separator.png" style="float:left;">';
    $pf=$pf->getParentFolderObject();
    $i++;
}
$a[$i]='<div><a href="javascript:openRecycleFolder('.$_SESSION['path'].');">Papelera</a></div><img src="images/bc_separator.png" style="float:left;">';
for($i=count($a)-1;$i>=0;$i--)
{
    echo $a[$i];
}
echo '</th></tr>';
$f=$folder->getRecycledFolders($_SESSION['user']->getIDU());
for($i=0;$i<$f->length();$i++)
{
    echo '<tr><td><div style="float:left"><input type="checkbox" style="float:left;"><div class="foldericon"></div><a href="javascript:openRecycleFolder('.$f->getElement($i)->getIDF().');">'.$f->getElement($i)->getName().'</a></div>';
    echo '<div style="float:right;"><button class="icons2" title="Eliminar" onclick="deletefolder2('.$f->getElement($i)->getIDF().');"><div class="deletefolder"></div></button>';
    echo '<button class="icons2" title="Cambiar Nombre" onclick="renamefolder('.$f->getElement($i)->getIDF().');"><div class="renamefolder"></div></button>';
    echo '<button class="icons2" title="Permisos" onclick="folderpermissions('.$f->getElement($i)->getIDF().');"><div class="permisos"></div></button></div></td></tr>';
}
$f=$folder->getRecycledFiles();
for($i=0;$i<$f->length();$i++)
{
    $u=user::getUserByID($f->getElement($i)->getUser());
    $fecha=new fecha($f->getElement($i)->getDateCreation());
    $f1=$fecha->getDay().'/'.$fecha->getLiteralMonth().'/'.$fecha->getYear().' Hrs:'.$fecha->getTime();
    echo '<tr><td><div style="float:left"><input type="checkbox" style="float:left;"><div class="'.$f->getElement($i)->getFileExt().'"></div><a href="javascript:openfile('.$f->getElement($i)->getIDF().');">'.$f->getElement($i)->getFileName().'</a>';
    echo '<div class="description"><span>Fecha de Creaci&oacute;n:</span>'.$f1.' <span>Cargado Por:</span>'.$u->getName().' <span>Tama&ntilde;o:</span>'.round($f->getElement($i)->getFileSize()/1024,2).'Kb</div></div>';
    echo '<div style="float:right;">';
    echo '<button class="icons2" title="Eliminar" onclick="deletefile('.$f->getElement($i)->getIDF().');"><div class="deletefolder"></div></button>';
    echo '<button class="icons2" title="Permisos" onclick="filepermissions('.$f->getElement($i)->getIDF().');"><div class="permisos"></div></button>';
    echo '<button class="icons2" title="Cambiar Nombre" onclick="renamefile('.$f->getElement($i)->getIDF().');"><div class="renamefolder"></div></button>';
    echo '<button class="icons2" title="Descargar" onclick="download('.$f->getElement($i)->getIDF().');"><div class="download"></div></button></div></td></tr>';
}
if($_SESSION['currentpath']==$_SESSION['path'])
{
    $f=$folder->getRecycledFiles2($_SESSION['user']->getIDU());
    for($i=0;$i<$f->length();$i++)
    {
        $u=user::getUserByID($f->getElement($i)->getUser());
        $fecha=new fecha($f->getElement($i)->getDateCreation());
        $f1=$fecha->getDay().'/'.$fecha->getLiteralMonth().'/'.$fecha->getYear().' Hrs:'.$fecha->getTime();
        echo '<tr><td><div style="float:left"><input type="checkbox" style="float:left;"><div class="'.$f->getElement($i)->getFileExt().'"></div><a href="javascript:openfile('.$f->getElement($i)->getIDF().');">'.$f->getElement($i)->getFileName().'</a>';
        echo '<div class="description"><span>Fecha de Creaci&oacute;n:</span>'.$f1.' <span>Cargado Por:</span>'.$u->getName().' <span>Tama&ntilde;o:</span>'.round($f->getElement($i)->getFileSize()/1024,2).'Kb</div></div>';
        echo '<div style="float:right;">';
        echo '<button class="icons2" title="Eliminar" onclick="deletefile('.$f->getElement($i)->getIDF().');"><div class="deletefolder"></div></button>';
        echo '<button class="icons2" title="Permisos" onclick="filepermissions('.$f->getElement($i)->getIDF().');"><div class="permisos"></div></button>';
        echo '<button class="icons2" title="Cambiar Nombre" onclick="renamefile('.$f->getElement($i)->getIDF().');"><div class="renamefolder"></div></button>';
        echo '<button class="icons2" title="Descargar" onclick="download('.$f->getElement($i)->getIDF().');"><div class="download"></div></button></div></td></tr>';
    }
}
?>
