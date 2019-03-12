<?php
require_once '../lib/db.php';
require_once '../lib/file.php';
require_once '../lib/folder.php';
require_once '../lib/fecha.php';
require_once '../lib/collection.php';
require_once '../lib/user.php';
//$time1=time();
session_start();
$_SESSION['currentpath']=$_SESSION['path'];
$c=file::searchFiles($_POST['strword']);
//$time2=time();
//$time=$time2-$time1;
//$folder=folder::getFolderById($_SESSION['path']);
echo '<table class="tablefolders">';
echo '<tr><th><div class="path">';
//echo '<div><a href="javascript:openfolder('.$folder->getIDF().');">'.$folder->getName().'</a></div><img src="images/bc_separator.png" style="float:left;">';
echo '<div><a href="#">Encontrados '.$c->length().' archivos</a></div><img src="images/bc_separator.png" style="float:left;">';
echo '</div></th></tr>';
for($i=0;$i<$c->length();$i++)
{
    $f=$c->getElement($i);
    $u=user::getUserByID($f->getUser());
    $fecha=new fecha($f->getDateCreation());
    $f1=$fecha->getDay().'/'.$fecha->getLiteralMonth().'/'.$fecha->getYear().' Hrs:'.$fecha->getTime();
    echo '<tr><td onmouseover="hiddeInstant();"><div style="float:left;width:730px;"><div class="'.$f->getFileExt().'"></div>
        <a style="float:left;width:670px;overflow:hidden;" title="'.$f->getFileName().'" href="javascript:openfile('.$f->getIDF().');">'.$f->getFileName().'</a>';
    echo '<div class="description">
            <div>
                <div class="fechacrea"></div>
                <span>Fecha de Creaci&oacute;n:</span>'.$f1.'
            </div><br>
            <div class="cargadopor"></div>
            <span>Cargado Por:</span>'.$u->getName().' <span>Tama&ntilde;o:</span>'.round($f->getFileSize()/1024,2).'Kb</div>';
    if($f->getFileExt()=='pdf')
    {
        echo '<div class="instant" onmousemove="showInstant(event,'.chr(39).$f->getPathFile().'/'.$f->getFileName().chr(39).');"></div>';
    }
    echo '<div style="float:right;">';
//    echo '<button class="icons2" title="Eliminar" onclick="deletefile('.$f->getIDF().');"><div class="deletefolder"></div></button>';
//    echo '<button class="icons2" title="Permisos" onclick="filepermissions('.$f->getIDF().');"><div class="permisos"></div></button>';
//    echo '<button class="icons2" title="Cambiar Nombre" onclick="renamefile('.$f->getIDF().');"><div class="renamefolder"></div></button>';
    echo '<button class="icons2" title="Descargar" onclick="openfile('.$f->getIDF().');"><div class="download"></div></button></div></div></td></tr>';
    
}
echo '</table>';
?>

