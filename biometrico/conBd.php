<?php
   $mysqli=new mysqli("129.150.181.216","root","","dwh");
   if(mysqli_connect_errno()){
   	  echo 'Conexion Fallida : ',mysqli_connect_error();
   	  exit();
   }
   
?>