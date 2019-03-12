<?php

$file=fopen('apple-touch-icon.png','rb');
$data=fread($file,filesize('apple-touch-icon.png'));
$data=chunk_split(base64_encode($data));
fclose($file);
//var_dump($data);
        $bundary=  md5(time());
        $titulo =  'test';
        $mensaje = 'test';
        $headers = "From: HelpDesk@oopp.gob.bo\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed;\r\n boundary=\"$bundary\"";
$headers1 = "--$bundary\r\n";
$headers1 .= "Content-Type: text/html; charset=us-ascii\r\n\r\n";
$headers1 .= "<h1>mmmmmmmm</h1><img src=\"cid:x.png\">\r\n";
$headers1 .= "--$bundary\r\n";
$headers1 .= "Content-Type: image/png;\r\n";
$headers1 .= " name=\"image.png\"\r\n";
$headers1 .= "Content-Disposition: attachment;\r\n";
$headers1 .= "Content-ID: <x.png>\r\n";
$headers1 .= " filename=\"image.png\"\r\n";
$headers1 .= "Content-Transfer-Encoding: base64\r\n\r\n";
$headers1 .= $data."\r\n\r\n";
$headers1 .= "--$bundary--\r\n";
var_dump($headers1);
        var_dump(mail('roshanetty@gmail.com', $titulo, $headers1, $headers));

