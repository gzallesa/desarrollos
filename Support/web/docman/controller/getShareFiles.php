<?php
require_once '../lib/db.php';
require_once '../lib/file.php';
require_once '../lib/folder.php';
require_once '../lib/fecha.php';
require_once '../lib/group.php';
require_once '../lib/collection.php';
require_once '../lib/user.php';
require_once '../lib/permissions.php';
require_once '../lib/breadCrumb.php';
session_start();
$p=new permissions('', '', '');
$_SESSION['currentpath']=$_POST['idf'];
if(!$_SESSION['bread']->exist($_POST['idf']))
{
    $_SESSION['bread']->addCrumb($_POST['idf']);
}
echo '<table class="tablefolders" >';
echo '<tr><th class="path">';
echo $_SESSION['bread']->getCrumbs();
echo '</th></tr>';
$folder=folder::getFolderById($_POST['idf']);
$f=$folder->getShareFiles();
getShareFiles1($f);
function getShareFiles1($f)
{
    for($i=0;$i<$f->length();$i++)
    {
        $u=user::getUserByID($f->getElement($i)->getUser());
        $fecha=new fecha($f->getElement($i)->getDateCreation());
        $f1=$fecha->getDay().'/'.$fecha->getLiteralMonth().'/'.$fecha->getYear().' Hrs:'.$fecha->getTime();
        $p=$f->getElement($i)->getPermissions();
        if($_SESSION['user']->getType()=='0'or $f->getElement($i)->getUser()==$_SESSION['user']->getIDU())
        {
        echo '<tr><td onmouseover="hiddeInstant();">
              <div style="float:left;width:730px;">
                <div class="'.$f->getElement($i)->getFileExt().'"></div>';
        echo '<a style="float:left;width:670px;overflow:hidden;" title="'.$f->getElement($i)->getFileName().'" href="javascript:openfile('.$f->getElement($i)->getIDF().');">'.$f->getElement($i)->getFileName().'</a><br>
              <div class="description">
              <div>
                <div class="fechacrea"></div>
                Fecha de Creaci&oacute;n:'.$f1.'
              </div><br>
              <div>
                    <div class="cargadopor"></div>
                    Cargado Por:'.$u->getName().'<span>Tama&ntilde;o:</span>'.round($f->getElement($i)->getFileSize()/1024,2).'Kb</div></div>';
            if($f->getElement($i)->getFileExt()=='pdf')
            {
                echo '<div class="instant" onmousemove="showInstant(event,'.chr(39).$f->getElement($i)->getPathFile().'/'.$f->getElement($i)->getFileName().chr(39).');"></div>';
            }
            echo '<div style="float:right;width:200px;">';
            echo '<button class="icons2" title="Eliminar" onclick="deletefile('.$f->getElement($i)->getIDF().');"><div class="deletefolder"></div></button>';
            echo '<button class="icons2" title="Permisos" onclick="filepermissions('.$f->getElement($i)->getIDF().');"><div class="permisos"></div></button>';
            echo '<button class="icons2" title="Cambiar Nombre" onclick="renamefile('.$f->getElement($i)->getIDF().');"><div class="renamefolder"></div></button>';
            echo '<button class="icons2" title="Descargar" onclick="openfile('.$f->getElement($i)->getIDF().');"><div class="download"></div></button></div></div></td></tr>';
        }else
        {
            if($p->getUsersRead() or $p->getGroupRead())
            {
        echo '<tr><td>
              <div style="float:left;width:730px;">
                <div class="'.$f->getElement($i)->getFileExt().'">
              </div>';
        echo '<a style="float:left;width:670px;overflow:hidden;" title="'.$f->getElement($i)->getFileName().'" href="javascript:openfile('.$f->getElement($i)->getIDF().');">'.$f->getElement($i)->getFileName().'</a><br>
              <div class="description">
              <div>
                <div class="fechacrea"></div>
                Fecha de Creaci&oacute;n:'.$f1.'
              </div><br>
              <div>
                    <div class="cargadopor"></div>
                    Cargado Por:'.$u->getName().'<span>Tama&ntilde;o:</span>'.round($f->getElement($i)->getFileSize()/1024,2).'Kb</div></div>';
                echo '<div style="float:right;width:200px;">';
                    if($p->getUsersWrite() or $p->getGroupWrite())
                    {
                        echo '<button class="icons2" title="Cambiar Nombre" onclick="renamefile('.$f->getElement($i)->getIDF().');"><div class="renamefolder"></div></button>';            
                    }
                    if($p->getUsersX() or $p->getGroupX())
                    {
                        echo '<button class="icons2" title="Eliminar" onclick="deletefile('.$f->getElement($i)->getIDF().');"><div class="deletefolder"></div></button>';
                    }
                    echo '<button class="icons2" title="Descargar" onclick="openfile('.$f->getElement($i)->getIDF().');"><div class="download"></div></button></div>';
                }
                    echo '</div></div></td></tr>';
        }
    }
}
echo '</table>';
?>
