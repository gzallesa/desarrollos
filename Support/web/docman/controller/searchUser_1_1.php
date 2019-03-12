<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
require_once '../lib/collection.php';
$conn = mysql_connect("localhost", "root", "");
mysql_select_db("docman");
include("../inc/jqgrid_dist.php");
$g = new jqgrid();
$grid["caption"] = "Usuarios MOPSV";
$grid["multiselect"] = false;
$grid["rowNum"] = 50;
$grid["rowList"] = array(20,40,60,80,100);
$grid["autowidth"]=true;
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
$g->table = "test2";
$cols=array(array("title"=>"INTERNO","name"=>"interno","search"=>true,"width"=>"60"),
            array("title"=>"NOMBREs y APELLIDOs","name"=>"name","search"=>true,"width"=>"300"),
            array("title"=>"CI","name"=>"ci","search"=>true),
            array("title"=>"CORREO","name"=>"email","search"=>true,"width"=>"300"),
            array("title"=>"TEL&Eacute;FONO","name"=>"telefono","search"=>true),
            array("title"=>"CELULAR","name"=>"movil","search"=>true),
            array("title"=>"DIRECCI&Oacute;N","name"=>"direccion","search"=>true),
            array("title"=>"CARGO","name"=>"cargo","search"=>true),
            array("title"=>"IP","name"=>"ip","search"=>true,"editable"=>true),
            array("title"=>"DEPENDIENTE","name"=>"depende_de","search"=>true,"editable"=>true),
            array("title"=>"FOTOGRAFIA","name"=>"idu","search"=>false,"editable"=>false,"default"=>"<img width='50px' src='../../fotos/{idu}.jpg'/>"),
            
    
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

