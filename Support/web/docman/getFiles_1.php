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
$folder=folder::getFolderById($_POST['idf']);
$p=new permissions('', '', '');
$nf='';
$_SESSION['currentpath']=$_POST['idf'];
echo '<input id="currentpath" type="hidden" value="'.$_SESSION['currentpath'].'">';
if(!$_SESSION['bread']->exist($_POST['idf']))
{
    $_SESSION['bread']->addCrumb($_POST['idf']);
}
echo '<table class="tablefolders" id="tablefoldersload">';
echo '<tr><th class="path">';
echo $_SESSION['bread']->getCrumbs();
echo '</th></tr>';
if($_SESSION['bread']->length()==1)
{
    //getSharedFolders1($folder);
    echo '<tr><td><div style="float:left"><div class="foldericon"></div><a href="javascript:opensharefolders('.$folder->getIDF().');">Documentos compartidos</a></div>';
}
$nf=getFolders1($folder);
$f=$folder->getFiles();
$nfi=$f->length();
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
                <span>Fecha de Creaci&oacute;n:</span>'.$f1.'
              </div><br>
              <div>
                    <div class="cargadopor"></div>
                    <span>Cargado Por:</span>'.$u->getName().'<span> Tama&ntilde;o:</span>'.round($f->getElement($i)->getFileSize()/1024,2).'Kb</div></div>';
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
        echo '<tr><td onmouseover="hiddeInstant();">
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
            if($f->getElement($i)->getFileExt()=='pdf')
            {
                echo '<div class="instant" onmousemove="showInstant(event,'.chr(39).$f->getElement($i)->getPathFile().'/'.$f->getElement($i)->getFileName().chr(39).');"></div>';
            }
            echo '<div style="float:right;">';
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
echo '</table>';
echo '<div class="path"><div class="pie">Folders:'.$nf.'</div><div class="pie">Archivos:'.$nfi.'</div></div>';
function getFolders1(folder $folder)
{
    $f=$folder->getFolders();
    for($i=0;$i<$f->length();$i++)
    {
        $p=$f->getElement($i)->getPermissions();
        $u=user::getUserByID($f->getElement($i)->getUser());
        //$fecha=new fecha($f->getElement($i)->getDateCreation());
        //$f1=$fecha->getDay().'/'.$fecha->getLiteralMonth().'/'.$fecha->getYear().' Hrs:'.$fecha->getTime();
        if($_SESSION['user']->getType()=='0'or $f->getElement($i)->getUser()==$_SESSION['user']->getIDU())
        {
            echo '<tr><td>
                  <div style="float:left">
                       <div class="foldericon"></div><a href="javascript:openfolder('.$f->getElement($i)->getIDF().');">'.$f->getElement($i)->getName().'</a>
                       <br><div style="width:600px;">
                                <div><div class="cargadopor"></div>'.$u->getName().'</div>
                           </div></div>';
            echo '<div style="float:right;"><button class="icons2" title="Eliminar" onclick="deletefolder('.$f->getElement($i)->getIDF().');"><div class="deletefolder"></div></button>';
            echo '<button class="icons2" title="Cambiar Nombre" onclick="renamefolder('.$f->getElement($i)->getIDF().');"><div class="renamefolder"></div></button></div></td></tr>';
            //echo '<button class="icons2" title="Permisos" onclick="folderpermissions('.$f->getElement($i)->getIDF().');"><div class="permisos"></div></button></div></td></tr>';    
        }else
        {
            if($p->getUsersRead() or $p->getGroupRead())
            {
                echo '<tr><td><div style="float:left"><div class="foldericon"></div><a href="javascript:openfolder('.$f->getElement($i)->getIDF().');">'.$f->getElement($i)->getName().'</a></div>';
            }
            if($p->getUsersX() or $p->getGroupX())
            {
                echo '<div style="float:right;"><button class="icons2" title="Eliminar" onclick="deletefolder('.$f->getElement($i)->getIDF().');"><div class="deletefolder"></div></button>';
            }
            if($p->getUsersWrite() or $p->getGroupWrite())
            {
                echo '<button class="icons2" title="Cambiar Nombre" onclick="renamefolder('.$f->getElement($i)->getIDF().');"><div class="renamefolder"></div></button></div></td></tr>';
                //echo '<button class="icons2" title="Permisos" onclick="folderpermissions('.$f->getElement($i)->getIDF().');"><div class="permisos"></div></button></div></td></tr>';    
            }
        }
    }
    return $f->length();
}
function getSharedFolders1(folder $folder)
{
    $f=$folder->getShareFolders();
    for($i=0;$i<$f->length();$i++)
    {
        echo '<tr><td><div style="float:left"><div class="foldericon"></div><a href="javascript:opensharefolder('.$f->getElement($i)->getIDF().');">Documentos compartidos:'.$f->getElement($i)->getName().'</a></div>';
    }
}
?>
