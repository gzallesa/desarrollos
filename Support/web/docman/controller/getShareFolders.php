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
echo '<tr><th><div class="path">';
echo $_SESSION['bread']->getCrumbs();
echo '</div></th></tr>';
$folder=folder::getFolderById($_POST['idf']);
$f=$folder->getShareFolders();
for($i=0;$i<$f->length();$i++)
{
    echo '<tr><td><div style="float:left"><div class="foldericon"></div><a href="javascript:opensharefolder('.$f->getElement($i)->getIDF().');">Documentos compartidos:'.$f->getElement($i)->getName().'</a></div>';
}
echo '</table>';

