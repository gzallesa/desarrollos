<?php 
    // Parametros de Entrada	
	$pin = $_GET["pin"];
	$imei = $_GET["imei"];
	//$token = $_GET["token"];
	$idApp = $_GET["idApp"];	
	
	// Variables de Salida
	$msj = "";
    $error = 0;
	
	// Limpia parametros de entrada
	$pin = trim($pin);
	$imei = trim($imei);
	//$token = trim($token);
	$idApp = trim($idApp);

	// Validar parametros de entrada
	if(strlen($pin) <=0){
       $msj = 'Debe ingresar el pin';
       $error = 1;
	   $mostrar = array("error"=>$error,"descripcion"=>$msj);
	   exit(json_encode( $mostrar));
    }
	else if(strlen($imei) <=0){
       $msj = 'Debe ingresar el imei';
       $error = 1;
	   $mostrar = array("error"=>$error,"descripcion"=>$msj);
	   exit(json_encode( $mostrar));
    }
	else if(strlen($idApp) <=0){
       $msj = 'Debe ingresar el IdApp';
       $error = 1;
	   $mostrar = array("error"=>$error,"descripcion"=>$msj);
	   exit(json_encode( $mostrar));
    }	
	//else if(strlen($token) <=0){
    //   $msj = 'Debe ingresar el token';
    //   $error = 1;
	//   $mostrar = array("error"=>$error,"descripcion"=>$msj);
	//   exit(json_encode( $mostrar));
    //}	

    //ConectBd, Inserta Info, Valida
	require_once 'dbConfig.php';
	$conexion = new mysqli(SERVER, USER, PASSWORD, DATABASE);
	if (mysqli_connect_errno())
	  {
	     die('Could not connect: ' . mysql_error()); 
		 $msj = 'Problemas Conexion Base de Datos';
         $error = 1;
	     $mostrar = array("error"=>$error,"descripcion"=>$msj);
		 $conexion->close();
	     exit(json_encode( $mostrar));
       }
    else 
	   {
		  //Valida IdApp, Usuario	y Pin 
		  //$sql = "SELECT count(1) as total FROM back_mobile WHERE token = '$token' and imei = $imei //and  status = 'C' and id_App = '$idApp' and pin = $pin";
		  $sql = "SELECT count(1) as total FROM app_customer";
		  if (mysqli_connect_errno())
		  {
	         die('Could not connect: ' . mysql_error());
	      } 	
		  $result = mysqli_query($conexion, $sql);
		  $dato = mysqli_fetch_assoc($result);
		  $num_rows = $dato['total']; 
		  //exit(json_encode( $num_rows));
		  if ($num_rows > 0) 
		  {
			 $sql = "select numero+1 as secuencia from secuencia where tabla = 'syncdown'";   
			 $result = mysqli_query($conexion, $sql);
		     $dato = mysqli_fetch_assoc($result);
		     $secuencia = $dato['secuencia'];  
			 
	         //$fecha=strftime( "%Y-%m-%d-%H-%M-%S", time() ); 
			 date_default_timezone_set("America/Caracas");
		     $fecha = date("Y-m-d H:i:s");
			 $sql = "SELECT * FROM app_customer";
			 $result = mysqli_query($conexion, $sql);
			 if (($result) && ($result->num_rows > 0))
			 {
		 	    $results = array();
                $resultSyncs = array();
	            //convert query result into an associative array
	            $cont = 0;
                $operation = "I";
	            $acknoledge = 0;
				$applied = 0;
				$info_type = "APP_CUSTOMER";
		        while ($row = $result->fetch_assoc())
	            {
                   $cont++;
		           //$results[] = array_map('utf8_encode', array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>$token,'pin'=>$pin,'imei'=>$imei));
				   $results[] = array_map('utf8_encode', array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>'123','pin'=>$pin,'imei'=>$imei,'legacy_id'=>$secuencia));
	            }
			}
			$sql1 = "SELECT * FROM app_location";
			$result1 = mysqli_query($conexion, $sql1);
            if (($result1) && ($result1->num_rows > 0))
            {
	           //convierte el query en array
		       $results1 = array();
               $info_type = "APP_LOCATION";
  	           while ($row1 = $result1->fetch_assoc())
	           {
                  $cont++;
				  $results[] = array_map('utf8_encode',array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row1)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>'123','pin'=>$pin,'imei'=>$imei,'legacy_id'=>$secuencia));
	           }
            }	
            $sql2 = "SELECT * FROM app_parameter";
            $result2 = mysqli_query($conexion, $sql2);
            if (($result2) && ($result2->num_rows > 0))
            {
	           //convierte el query en array
			   $results2 = array();
	           $info_type = "APP_PARAMETER";
         	   while ($row2 = $result2->fetch_assoc())
	           {
                  $cont++;
				  $results[] = array_map('utf8_encode',array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row2)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>'123','pin'=>$pin,'imei'=>$imei,'legacy_id'=>$secuencia));
	           }
            }				
			
            $sql3 = "SELECT * FROM app_price";
            $result3 = mysqli_query($conexion, $sql3);
            if (($result3) && ($result3->num_rows > 0))
            {
	           //convierte el query en array
			   $results3 = array();
	           $info_type = "APP_PRICE";
         	   while ($row3 = $result3->fetch_assoc())
	           {
                  $cont++;
				  $results[] = array_map('utf8_encode',array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row3)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>'123','pin'=>$pin,'imei'=>$imei,'legacy_id'=>$secuencia));
	           }
            }			

            $sql4 = "SELECT * FROM app_stock";
            $result4 = mysqli_query($conexion, $sql4);
            if (($result4) && ($result4->num_rows > 0))
            {
	           //convierte el query en array
			   $results4 = array();
	           $info_type = "APP_STOCK";
         	   while ($row4 = $result4->fetch_assoc())
	           {
                  $cont++;
				  $results[] = array_map('utf8_encode',array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row4)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>'123','pin'=>$pin,'imei'=>$imei,'legacy_id'=>$secuencia));
	           }
            }
			
            $sql5 = "SELECT * FROM app_stock_move";
            $result5 = mysqli_query($conexion, $sql5);
            if (($result5) && ($result5->num_rows > 0))
            {
	           //convierte el query en array
			   $results5 = array();
	           $info_type = "APP_STOCK_MOVE";
         	   while ($row5 = $result5->fetch_assoc())
	           {
                  $cont++;
				  $results[] = array_map('utf8_encode',array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row5)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>'123','pin'=>$pin,'imei'=>$imei,'legacy_id'=>$secuencia));
	           }
            }		

            $sql6 = "SELECT * FROM app_supplier";
            $result6 = mysqli_query($conexion, $sql6);
            if (($result6) && ($result6->num_rows > 0))
            {
	           //convierte el query en array
			   $results6 = array();
	           $info_type = "APP_SUPPLIER";
         	   while ($row6 = $result6->fetch_assoc())
	           {
                  $cont++;
				  $results[] = array_map('utf8_encode',array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row6)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>'123','pin'=>$pin,'imei'=>$imei,'legacy_id'=>$secuencia));
	           }
            }		
			
            $sql7 = "SELECT * FROM app_collections";
            $result7 = mysqli_query($conexion, $sql7);
            if (($result7) && ($result7->num_rows > 0))
            {
	           //convierte el query en array
			   $results7 = array();
	           $info_type = "APP_COLLECTIONS";
         	   while ($row7 = $result7->fetch_assoc())
	           {
                  $cont++;
				  $results[] = array_map('utf8_encode',array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row7)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>'123','pin'=>$pin,'imei'=>$imei,'legacy_id'=>$secuencia));
	           }
            }	

            $sql8 = "SELECT * FROM app_collections_invoice";
            $result8 = mysqli_query($conexion, $sql8);
            if (($result8) && ($result8->num_rows > 0))
            {
	           //convierte el query en array
			   $results8 = array();
	           $info_type = "APP_COLLECTIONS_INVOICE";
         	   while ($row8 = $result8->fetch_assoc())
	           {
                  $cont++;
				  $results[] = array_map('utf8_encode',array('id_sync_up'=>$cont, 'info_type'=>$info_type,'operation'=>$operation,'data_sql'=>json_encode(array_map('utf8_encode', $row8)),'received'=>$fecha,'acknoledge'=>$acknoledge, 'confirmed'=>"",'applied'=>$applied,'app_key'=>'123','pin'=>$pin,'imei'=>$imei,'legacy_id'=>$secuencia));
	           }
            }	

			
			$sql = "UPDATE secuencia SET numero = $secuencia WHERE  tabla = 'syncdown'";
		    $resu = $conexion->query($sql);
		    if (mysqli_connect_errno()){
	        die('Could not connect: ' . mysql_error()); 
            }
            if ($resu === TRUE) {
		      $msj = 'OK';
            } else {
		      $msj = 'Problemas Conexion Base de Datos';
              $error = 1;
	          $mostrar = array("error"=>$error,"descripcion"=>$msj);
			  $conexion->close();
			  exit(json_encode( $mostrar));
            }  
		    $msj = 'OK';
	        $mostrar = array("error"=>$error,"descripcion"=>$msj);
			
			$mostrar = $results;
			$error = 0;
			$conexion->close();
		  }
		 else 
		  {
		     $msj = 'No Existe Informacion con esos Datos';
             $error = 1;
	         $mostrar = array("error"=>$error,"descripcion"=>$msj);
		     $conexion->close();
			 exit(json_encode( $mostrar));
          }
	   }
	exit(json_encode( $mostrar));
?>