<?php 
   //Creamos la conexión
   require_once 'data.php';
   $conexion = mysqli_connect($server, $user, $pass, $bd); 
   //or die("Ha sucedido un error inexperado en la conexion de la base de datos");
   	if (mysqli_connect_errno())
   	  {
	     die('Could not connect: ' . mysql_error()); 
		 $msj = 'Problemas Conexion Base de Datos';
         $error = 1;
	     $mostrar = array("error"=>$error,"descripcion"=>$msj);
		// $conexion->close();
	     exit(json_encode( $mostrar));
       }
   else
   {
      //generamos la consulta
      $sql = "SELECT codigo,dominio,descripcion FROM mon_dominio WHERE dominio IN ('EXPEDIDO') AND codigo in ('LPZ','SCZ','CBA')";
      mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

      if(!$result = mysqli_query($conexion, $sql)) die();
         $clientes = array(); //creamos un array
         while($row = mysqli_fetch_array($result)) 
         { 
            $dominio=$row['dominio'];
            $codigo=$row['codigo'];
            $descripcion=$row['descripcion'];
    
            $clientes[] = array_map('utf8_encode',array('dominio'=> $dominio, 'codigo'=>$codigo, 'descripcion'=> $descripcion));

         }
         
      //Creamos el JSON
      $json_string = json_encode($clientes);
      echo $json_string;        
      
      $sql = "SELECT codigo,dominio,descripcion FROM mon_dominio WHERE dominio IN ('MARCA VEHICULO','KILOMETRAJE','MANTENIMIENTO','ANIO')";
      mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

      if(!$result = mysqli_query($conexion, $sql)) die();
         $clientes = array(); //creamos un array
         while($row = mysqli_fetch_array($result)) 
         { 
            $dominio=$row['dominio'];
            $codigo=$row['codigo'];
            $descripcion=$row['descripcion'];
    
            $clientes[] = array_map('utf8_encode',array('dominio'=> $dominio, 'codigo'=>$codigo, 'descripcion'=> $descripcion));

         }
         
      //Creamos el JSON
      $json_string = json_encode($clientes);
      echo $json_string;
      
      
      $sql = "select cod_modelo,desc_modelo,marca from v_getmodelo";
      mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

      if(!$result = mysqli_query($conexion, $sql)) die();
         $clientes = array(); //creamos un array
         while($row = mysqli_fetch_array($result)) 
         { 
            $cod_modelo=$row['cod_modelo'];
            $desc_modelo=$row['desc_modelo'];
            $marca=$row['marca'];
            $dominio = "MODELO"; 
            $clientes[] = array_map('utf8_encode',array('dominio'=> $dominio, 'cod_modelo'=>$cod_modelo, 'desc_modelo'=> $desc_modelo, 'marca'=> $marca));

         }
         
      //Creamos el JSON
      $json_string = json_encode($clientes);
      echo $json_string;
            
         
      $sql = "SELECT codigo,dominio,descripcion,valor_caracter FROM mon_dominio WHERE dominio IN ('TALLER') and codigo in ('0201','0301')";
      mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

      if(!$result = mysqli_query($conexion, $sql)) die();
         $clientes = array(); //creamos un array
         while($row = mysqli_fetch_array($result)) 
         { 
            $dominio=$row['dominio'];
            $codigo=$row['codigo'];
            $descripcion=$row['descripcion'];
            $valor_caracter=$row['valor_caracter'];
    
            $clientes[] = array_map('utf8_encode',array('dominio'=> $dominio, 'codigo'=>$codigo, 'descripcion'=> $descripcion, 'valor_caracter'=> $valor_caracter));

         }         
      //desconectamos la base de datos
      $close = mysqli_close($conexion) 
      or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
 
      //Creamos el JSON
      $json_string = json_encode($clientes);
      echo $json_string;
}
?>