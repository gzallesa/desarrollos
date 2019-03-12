<?php
require_once 'lib/db.php';
require_once 'lib/file.php';
require_once 'lib/folder.php';
if (isset($_POST["PHPSESSID"]))
{
    session_id($_POST["PHPSESSID"]);
}
session_start();
if(!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
    echo "Error al cargar el archivo";
}
date_default_timezone_set('America/La_Paz');
$filename=$_FILES["Filedata"]["name"];
$fecha=date('Y-m-d H:i:s');
$info=pathinfo('rootfolder/'.$_POST['path'].$filename);
$folder=folder::getFolderById($_POST['idf']);
$i=1;
while($folder->existeFile($filename))
{
    $filename=$info['filename'].'('.$i.')'.'.'.$info['extension'];
    $i++;
}
move_uploaded_file($_FILES["Filedata"]["tmp_name"], 'rootfolder/'.$_POST['path'].$filename);
$file=new file('', $filename, $_FILES["Filedata"]["size"], $fecha, $info['extension'], $folder->getIDF(), $_POST['idu'],'1',$folder->getPath().$folder->getIDF());
echo $folder->addFile($file);
?>