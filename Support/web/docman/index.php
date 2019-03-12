<!DOCTYPE html>
<html>
<head>
    <title>ooppIntranet</title>
<style>
    .w{
        font-size: 12px;
        text-align: center;
        color: white;
        width: 500px;
        background-color: #cc0000;
        border-radius: 5px;
        margin: auto;
        overflow: hidden;
    }
</style>
</head>
<body style="color:white; font-family: arial">
<style scoped>
    td{
        padding: 15px;
    }
input{
    background-image: url('images/logintext.png');
    background-position: 0px 0px;
    padding: 4px;
    border: none;
    width: 188px;
    height: 20px;
}
button{
    position: relative;
    background-image: url('images/botonlogin.png');
    background-color: transparent;
    border: none;
    cursor: pointer;
    color: white;
    top:240px;
    font-weight: bold;
    width: 94px;
    height: 30px;
}
button:hover{
    background-position: 0px 30px;
}
</style>

        <?php
        if(isset($_GET['stat']))
        {
            switch ($_GET['stat']) {
                case 0:
                    echo '<div id="w" class="w">Error</div>';
                    break;
                case 1:
                    echo '<div id="w" class="w">Nombre de Usuario y/o contrasena invalidos</div>';
                    break;
                case 2:
                    echo '<div id="w" class="w">La cuenta se encuentra inactiva<br>Para activar su cuenta contactese con el administrador del sitio</div>';
                    break;
                }
                        }
        ?>
<table style="font-size: 13px; margin:auto; border-radius: 10px; box-shadow: 0px 0px 5px #999999;border-color: #cccccc;border-style: solid;border-width: 10px;">
    <tr><td>
    <div style="color: dimgrey;width: 300px;font-family: arial">
        <h3>Que es la Intranet Institucional?</h3>
        <div>
          <div style="float: left; padding: 0px;border-color: #cccccc;border-style: solid;border-width: 5px; border-radius: 5px">
              <img src="../images/page1-img1.jpg" width="120" />
          </div>
        <p style="text-align:justify;font-family:arial">
La Intranet Institucinal es un Sistema de gesti&oacute;n documental 
creado para la gesti&oacute;n de grandes cantidades de documentos
, para almacenar documentos electr&oacute;nicos, im&aacute;genes de documentos en papel,
 cualquier otro tipo de documentos multimedia como im&aacute;genes, audio o videos.<br>
Los sistemas de gesti&oacute;n de documentos com&uacute;nmente proporcionan medios de almacenamiento, 
seguridad, as&iacute; como capacidades de recuperaci&oacute;n e indexaci&oacute;n.
        </p>

        </div>
        </div>
            </td><td>
    <div style=" background-image: url('images/forecast.png');width:390px;height: 317px;margin: auto">
            <form method="post" action="login.php">
                
                    <input style=" position: relative;left: 95px;top:158px;" type="text" name="usuario" placeholder="Nombre de usuario">
                    <input style=" position: relative;left: 95px;top:163px;" type="password" name="password" placeholder="Contrase&ntilde;a">
                    <button>Entrar</button>
                
            </form>
    </div>
                </td></tr></table>
</body>
</html>
