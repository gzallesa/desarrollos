<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
require_once '../lib/collection.php';
//$u=user::searchUser($_GET['txtbf']);
$criterio=$_GET['txtbf'];
//$user=new user($idu, $name, $email, $password, $movil, $interno, $ci, $datereg, $lastaccess, $state, $type, $telefono, $direccion, $telefref, $numseguro);
//if($u->length()==0)/
//{
//    echo 'Lamentablemente su busqueda no produjo resultados.';
//    exit();/
//}
$conn = mysql_connect("172.16.0.12", "irollano", "bloodmoon");
mysql_select_db("docman");
//mysql_query("SET NAMES 'utf8'");
include("../inc/jqgrid_dist.php");
$g = new jqgrid();
$grid["caption"] = "Usuarios";
$grid["multiselect"] = false;
$grid["autowidth"]=true;
$grid["altRows"]=true;
$grid["scroll"] = true; 
$g->set_options($grid);
$g->set_actions(array( 
    "add"=>false,
    "edit"=>FALSE,
    "delete"=>false,
    "rowactions"=>false,
    "export"=>true,
    "autofilter"=>true,
    "inlineadd"=>false,
    "showhidecolumns"=>false
    ) 
);
//$g->table = "docman_user";
//$g->select_command = "SELECT name from docman_user";
$val1="<img src=../images/externo.png>";
$val2="<img src=../images/interno.png>";
$g->select_command = "SELECT interno,name,ci,email,telefono,movil,direccion,cargo,'$val2' as xx
FROM docman_user 
WHERE name LIKE '%$criterio%' 
or email LIKE '%$criterio%' 
or interno LIKE '%$criterio%' 
or ci LIKE '%$criterio%' GROUP BY name
UNION
SELECT interno,name,ci,email,telefono,movil,direccion,cargo,'$val1' as xx
FROM docman_extern_user 
WHERE name LIKE '%$criterio%' 
or email LIKE '%$criterio%' 
or interno LIKE '%$criterio%' 
or ci LIKE '%$criterio%' GROUP BY name";
$v1='<a href="#">si</a>';
$cols=array(array("title"=>"INTERNO","name"=>"xx","search"=>false,"width"=>"50"),
            array("title"=>"INTERNO","name"=>"interno","search"=>false,"width"=>"60"),
            array("title"=>"NOMBREs y APELLIDOs","name"=>"name","search"=>false,"width"=>"400"),
            array("title"=>"CI","name"=>"ci","search"=>false),
            array("title"=>"CORREO","name"=>"email","search"=>false,"width"=>"300"),
            array("title"=>"TEL&Eacute;FONO","name"=>"telefono","search"=>false),
            array("title"=>"CELULAR","name"=>"movil","search"=>false),
            array("title"=>"DIRECCI&Oacute;N","name"=>"direccion","search"=>false),
            array("title"=>"CARGO","name"=>"cargo","search"=>false)
    );
//$cols[] = $col; 
//$cols[] = $col2; 
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

