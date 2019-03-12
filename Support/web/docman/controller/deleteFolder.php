<?php
require_once '../lib/db.php';
require_once '../lib/folder.php';
require_once '../lib/group.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$f=folder::getFolderById($_POST['idf']);
xxx($f);
echo 'Directorio eliminado<br><button class="button" onclick="cerrar();">Aceptar</button>';
function xxx(folder $f)
{
    $f->deleteFolder();
    $s=$f->getSubFolders();
    for($i=0;$i<$s->length();$i++)
    {
        $f2=$s->getElement($i);
        if($f2->getSubFolders()->length()>0)
        {
            xxx($f2);
        }
    }
}
?>
