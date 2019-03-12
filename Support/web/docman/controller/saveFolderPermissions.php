<?php
require_once '../lib/db.php';
require_once '../lib/folder.php';
require_once '../lib/permissions.php';
$f=  folder::getFolderById($_POST['idf']);
$c=str_replace('false', '-',$_POST['chk']);
$c=str_replace('chk[]=', '',$c);
$p=explode('&',$c);
$users='';
$groups='';
$users=$users.(str_replace('true','r',$p[0]));
$users=$users.(str_replace('true','w',$p[2]));
$users=$users.(str_replace('true','x',$p[4]));
$groups=$groups.(str_replace('true','r',$p[1]));
$groups=$groups.(str_replace('true','w',$p[3]));
$groups=$groups.(str_replace('true','x',$p[5]));
$per=new permissions($f->getIDF(), $users, $groups);
$f->setPermissions($per);
if($f->updateFilePermissions())
{
    echo 'Permisos guardados correctamente.<br><button class="button" onclick="cerrar();">Aceptar</button>';
}else
{
    echo 'Error al cambiar permisos';
}
?>
