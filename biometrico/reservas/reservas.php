<?php
	require 'C:\xampp\htdocs\biometrico\conBd.php';
    $nombre=$_POST['nombre'];	
    $nombre=$_POST['apellido'];
    if (strpos($_POST['email'],"@")){
		$nombre=$_POST['email'];
    }
    else{
		header("location: index.html");
		echo "El email es invalido";
	}
        		
 	echo "Datos guardados correctamente<br><a href='index.html'>Volver</a>";
?>	