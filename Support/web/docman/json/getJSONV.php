<?php
require_once '../lib/db.php';
require_once '../lib/video.php';
$v=video::getVideos();
$a=array();
for($i=0;$i<count($v);$i++)
{
    array_push($a, array("idc"=>$v[$i]->getIDc(),"iframecode"=>$v[$i]->getIframeCode()));
}
echo json_encode($a);
header('Content-type: text/json');
?>
