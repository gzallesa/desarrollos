<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
require_once '../lib/collection.php';
//$u=user::searchUser($_GET['txtbf']);
//$criterio=$_GET['txtbf'];
//$user=new user($idu, $name, $email, $password, $movil, $interno, $ci, $datereg, $lastaccess, $state, $type, $telefono, $direccion, $telefref, $numseguro);
//if($u->length()==0)/
//{
//    echo 'Lamentablemente su busqueda no produjo resultados.';
//    exit();/
//}
$conn = mysql_connect("localhost", "root", "");
mysql_select_db("docman");
//mysql_query("SET NAMES 'utf8'");
include("../inc/jqgrid_dist.php");
$g = new jqgrid();
$grid["caption"] = "Usuarios MOPSV";
$grid["multiselect"] = false;
$grid["rowNum"] = 50;
$grid["rowList"] = array(20,40,60,80,100);
$grid["autowidth"]=true;
//$grid["altRows"]=true;
//$grid["scroll"] = true; 
//$grid["viewrecords"] = true;
$g->set_options($grid);
$g->set_actions(array( 
    "add"=>false,
    "edit"=>FALSE,
    "delete"=>false,
    "search" => "simple",
    "rowactions"=>false,
    "export"=>true,
    "autofilter"=>true,
    "inlineadd"=>false,
    "showhidecolumns"=>false
    ) 
);
$g->table = "test";
//$g->select_command = "SELECT name from docman_user";
//$val1="<img src=../images/externo.png>";
//$val2="<img src=../images/interno.png>";
/*$g->select_command = "SELECT interno,name,ci,email,telefono,movil,direccion,cargo,'$val2' as xx
FROM docman_user 
UNION
SELECT interno,name,ci,email,telefono,movil,direccion,cargo,'$val1' as xx
FROM docman_extern_user";
$v1='<a href="#">si</a>';*/
$cols=array(array("title"=>"INTERNO","name"=>"interno","search"=>true,"width"=>"60"),
            array("title"=>"NOMBREs y APELLIDOs","name"=>"name","search"=>true,"width"=>"400"),
            array("title"=>"CI","name"=>"ci","search"=>true),
            array("title"=>"CORREO","name"=>"email","search"=>true,"width"=>"300"),
            array("title"=>"TEL&Eacute;FONO","name"=>"telefono","search"=>true),
            array("title"=>"CELULAR","name"=>"movil","search"=>true),
            array("title"=>"DIRECCI&Oacute;N","name"=>"direccion","search"=>true),
            array("title"=>"CARGO","name"=>"cargo","search"=>true)
    );
$g->set_columns($cols);
$out = $g->render("list1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" media="screen" href="../js/themes/redmond/jquery-ui.custom.css"></link>	
	<link rel="stylesheet" type="text/css" media="screen" href="../js/jqgrid/css/ui.jqgrid.css"></link>	
	<script src="../js/jqgrid/jquery.min.js" type="text/javascript"></script>
	<script src="../js/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
	<script src="../js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>	
	<script src="../js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
</head>
<body>
	<div style="margin:-8px">
	<?php echo $out?>
	</div>
        <script>
        $('.ui-search-toolbar').hide();
        </script>
</body>
</html>

