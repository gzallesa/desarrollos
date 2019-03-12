<?php
require_once 'lib/db.php';
require_once 'lib/group.php';
require_once 'lib/folder.php';
require_once 'lib/user.php';
require_once 'sessionCheck.php';

//$g=group::getGroupByName('Departamento de Sistemas');
//$_SESSION['path']=$g->getFolderID();
?>
<!DOCTYPE html>
<html>
<head>
    <title>ooppIntranet</title>
    <link href="styles/style.css" rel="stylesheet">
    <link href="css/myPopupStyle.css" rel="stylesheet">
    <script src="js/myPopup.js"></script>
    <script src="js2/login_1_1.js"></script>
    <script src="js2/verifica.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-1.8.3.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="codebase/dhtmlxcommon.js"></script>
    <script src="codebase/dhtmlxaccordion.js"></script>
    <link rel="stylesheet" type="text/css" href="codebase/dhtmlxtabbar.css">
    <link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxaccordion_dhx_skyblue.css">
    <link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_skyblue.css">
    <link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxgrid.css">
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_skyblue.css">
    <script src="codebase/dhtmlxtoolbar.js"></script>    
    <script src="codebase/dhtmlxgrid.js"></script>
    <script src="codebase/dhtmlxgridcell.js"></script>
    <script src="codebase/dhtmlxcontainer.js"></script>
    <script src="codebase/dhtmlxtabbar.js"></script>
<script type="text/javascript">
function goHome()
{
    document.location='panel.php';
}
</script>
</head>
<body onload="doOnLoad()">
<div class="marco" id="marco">
    <div class="window" id="win">
        <div class="titlebar" onmousedown="ggg(event);" id="titlebar">
            <div style="float:left;margin-top: 5px;margin-left: 5px;" class="title"></div>
            <div id="closebutton"></div>
        </div>
        <div id="cont" style="margin:5px;overflow-y:auto;max-height:500px;">s</div>
    </div>
</div>
<div class="p">
    <div class="contenedor">
        <div style="float: left;margin-left: 10px;margin-top: 3px;"><img src="images/logo.png"/></div>
        <div class="bienvenido">
            <span style="font-weight: bold;">Bienvenido: </span><?php echo $_SESSION['user']->getName(); ?>
        </div>
        <div class="top">
            <ul>
                <li><a href="#">Administrar&#124</a></li>
                <?php echo '<li><a href="javascript:edituser2('.$_SESSION['user']->getIDU().');">Mi Cuenta&#124</a></li>';?>
                <li><a href="#">Ayuda&#124</a></li>
                <li><a href="logout.php">Salir</a></li>
            </ul>
        </div>
        <div class="toolbar">
            <div class="toolbarleft">
                <div class="gohome" onclick="goHome();" title="Inicio"></div>
            </div>
        </div>
        <div class="leftbar">
            <div id="contenido" class="contenido">
                <div id="box" style="margin-top:10px; width:100%;height:550px;"></div>
            </div>
        </div>
        <div class="rightbar">
            <iframe src="agenda_1.php" style="width: 245px;height:700px;overflow: hidden;border: none"></iframe>
        </div>
    </div>

    <div class="footer">
        Ministerio de Obras P&uacute;blicas Servicios y Vivienda<br>
        Av. Mariscal Santa Cruz Esq. Calle Oruro Edif. Centro de Comunicaciones La Paz 5to piso.<br>
        Copyright &copy; Sistemas 2012 - Ministerio de Obras P&uacute;blicas, Servicios y Vivienda <br>
    </div>
</div>
</body>
</html>