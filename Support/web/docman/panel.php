<?php
require_once 'lib/db.php';
require_once 'lib/group.php';
require_once 'lib/folder.php';
require_once 'lib/user.php';
require_once 'lib/collection.php';
require_once 'sessionCheck.php';
require_once 'lib/breadCrumb.php';
$_SESSION['path']=$_SESSION['paths']->getElement(0)->getElement(3);
$_SESSION['bread']=new breadCrumb($_SESSION['path']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ooppIntranet</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="styles/style.css" rel="stylesheet"/>
    <link href="css/myPopupStyle.css" rel="stylesheet"/>
    <link rel="Shortcut Icon" href="images/icon.png"/>
    <script src="js/myPopup.js"></script>
    <script src="js2/login.js"></script>
    <script src="js2/clock.js"></script>
    <script src="js2/verifica.js"></script>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/pdfobject_source.js" type="text/javascript"></script>
    <script src="js/jquery-1.8.3.js"></script>
    <script src="js/trailScroll.js"></script>
<script type="text/javascript">
var trailscrl=new trailScroll();
function getGroupFolder()
{
    openfolder(<?php echo $_SESSION['path'];?>);
}
function goHome()
{
    document.location.reload();
}
</script>
</head>
<body onload="getGroupFolder();">
    
<div id="instantpreview">
</div>
<div id="sleep">
        <img src="images/espera.gif"><br>
        Espere un momento...
</div>
<div class="marco" id="marco">
    <div class="window" id="win">
        <div class="titlebar" onmousedown="ggg(event);" id="titlebar">
            <div style="float:left;margin-top: 5px;margin-left: 5px;" class="title"></div>
            <div id="closebutton"></div>
        </div>
        <div id="cont" style="margin:5px; overflow-y: auto; max-height:400px">s</div>
    </div>
</div>
<div class="p">
    <div class="contenedor">
            <div class="xmp" id="xmp"></div>
            <div class="xmp1" id="xmp1"></div>
            <div class="xmp2" id="xmp2"></div>
        <div style="float: left;margin-left: 10px;margin-top: 3px;"><img src="images/logo.png"/></div>
        <div class="bienvenido">
            <span style="font-weight: bold;">Bienvenido: </span><?php echo $_SESSION['user']->getName(); ?>
        </div>
        <div class="top">
            <ul>
                <?php
                if($_SESSION['user']->getUserType1()=='1')
                {
                    echo '<li><a href="administrator.php">Administrar&#124</a></li>';
                }elseif ($_SESSION['user']->getUserType1()=='0') {
                    echo '<li><a href="administrator_1.php">Administrar&#124</a></li>';
                }
                    echo '<li><a href="javascript:edituser2('.$_SESSION['user']->getIDU().');">Mi Cuenta&#124</a></li>';
                ?>
                <li><a href="#">Ayuda&#124</a></li>
                <li><a href="logout.php">Salir</a></li>
            </ul>
        </div>
        <div class="toolbar">
            <div class="toolbarleft">
                <div class="gohome" onclick="goHome();" title="Inicio"></div>
                <div class="statistic" onclick="stat();" title="Estadisticas"></div>
            </div>
            <div style="float: right;margin: 4px;">
                    <div class="search"><button title="Buscar" onclick="buscar();"></button><input type="text" id="srch" onkeyup="keypress(event,2);"/></div>
            </div>
            <div class="clock" id="clock"></div>
        </div>
        <div class="leftbar">
            <div id="contenido" class="contenido">
                <div class="foldertoolbar">
                    <div style="float: left;">
                            <?php
                                if($_SESSION['paths']->length()>1)
                                {
                                    echo '<select style="width:200px;" onchange="test(this);">';
                                    for($i=0;$i<$_SESSION['paths']->length();$i++)
                                    {
                                        $c=$_SESSION['paths']->getElement($i);
                                        echo '<option value="'.$c->getElement(3).'">'.$c->getElement(2).'</option>';
                                    }
                                    echo '</select>';
                                }
                            ?>
                    </div>
                    <div style="float: right" id="buttons">
                        <button class="icons" onclick="mostrar();"><div class="upload"></div>Cargar Archivo</button>
                        <button class="icons" onclick="nuevoFolder();"><div class="folder"></div>Nueva Carpeta</button>
<!--                        <button class="icons" onclick="nuevoDoc();"><div class="file"></div>Nuevo Documento</button>-->
                    </div>
                </div>
                <div id="tablefolders">
                    <img src="images/espera.gif">
                </div>
            </div>
        </div>
        <div class="rightbar">
                Buscador de Funcionarios:<br>
                <div class="buscfun">
                    <div class="btnsrch"></div><input type="text" id="txtbf" onkeyup="keypress(event,1);"/>
                </div>
                <button class="button" onclick="buscarf();">Buscar</button>
                <br style="clear: both">
                <div id="resultadofun">
                    
                </div>
                Agenda de Actividades:<br>
                <iframe src="calendar.php" height="650" width="245" frameborder="0" style="overflow-x: hidden">
                </iframe>
<!--                <div class="papelera" onclick="getGroupFolderRecycled();">

                </div>-->
        </div>
    <div class="f">
    
    </div>
    </div>
    <div class="footer">
        Ministerio de Obras P&uacute;blicas Servicios y Vivienda<br>
        Av. Mariscal Santa Cruz Esq. Calle Oruro Edif. Centro de Comunicaciones La Paz 5to piso.<br>
        Copyright &copy; Sistemas 2014<br>
    </div>
</div>
</body>
</html>
