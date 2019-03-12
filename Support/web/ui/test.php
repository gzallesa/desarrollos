<?php
require_once 'sms.php';
$sms=new sms();
echo $sms->respuesta();
$sms->enviarMensage('172', 'saldo');
echo $sms->respuesta();
sleep(5);
echo $sms->getSaldo();
echo $sms->respuesta();
//echo $sms->getSaldo();
//dio_write('AT+CMGL="REC UNREAD"\r');
//var_dump(dio_read ($fd));
// imprime el nombre de usuario que tiene control del proceso php/httpd activo
// (en un sistema con el ejecutable "whoami" disponible en la ruta)
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

