var dhxAccord;
var tabbar;
var dhxWins,w1;
var mygrid,usersgrid;
function me()
{
    var e=document.getElementById('sleep');
    e.style.display='block';
}
function oe()
{
    var e=document.getElementById('sleep');
    e.style.display='none';
}
function doOnLoad() {
    dhxAccord = new dhtmlXAccordion("box");
    dhxAccord.addItem("ac1", "Usuarios & Grupos");
    dhxAccord.openItem("ac1");
    tabbar=dhxAccord.cells("ac1").attachTabbar(); 
    tabbar.setImagePath("codebase/imgs/");
    tabbar.addTab("a1","Usuarios","200px");
    tabbar.setTabActive("a1");
    dhxAccord.setEffect(true);
    usersgrid= tabbar.cells("a1").attachGrid();
       usersgrid.setImagePath("codebase/imgs/");
       usersgrid.setHeader("NOMBRE DE USUARIO,ESTADO,GRUPO(S),TIPO DE USUARIO,MODIFICAR,ELIMINAR");
       usersgrid.setColAlign("left,center,left,left,center,center")
       usersgrid.setSkin("light");
       usersgrid.setColSorting("str,str,str,str,na,na");
       usersgrid.setColTypes("ro,ro,ro,ro,ro,ro");
       usersgrid.init();
       usersgrid.load("controller/getUsers.php","xml");
    var toolbar2=tabbar.cells("a1").attachToolbar();
        toolbar2.setIconsPath("codebase/common/imgs/");
        toolbar2.addButton("nuevo", "1", "Nuevo Usuario","newu.png",null);
        toolbar2.attachEvent("onClick", function(id){   
            var content='<form onsubmit="return false" id="frmuser">'+
            '<table  class="newUser">'+
            '<tr><td>Nombre(s) y Apellido(s):</td><td><input type="text" name="nombre" onchange="verifica(this,0);" onkeyup="verifica(this,0);"></td></tr>'+
            '<tr><td>CI:</td><td><input type="text" name="ci" onchange="verifica(this,3);" onkeyup="verifica(this,3);"></td></tr>'+
            '<tr><td>E-mail:</td><td><input type="text" name="email" onchange="verifica(this,2);" onkeyup="verifica(this,2);"></td></tr>'+
            '<tr><td>Nombre de usuario:</td><td><input type="text" name="username" onchange="verifica(this,0);" onkeyup="verifica(this,0);"></td></tr>'+
            '<tr><td>Contrase&ntilde;a</td><td><input id="pass2" type="password" name="password" onkeyup="verifica(this,4);"></td></tr>'+
            '<tr><td>Confirme:</td><td><input type="password" onkeyup="verifica2(this,pass2);"></td></tr>'+
            '<tr><td>Tel&eacute;fono:</td><td><input type="text" name="telefono"  onchange="verifica(this,5);" onkeyup="verifica(this,5);"></td></tr>'+
            '<tr><td>M&oacute;vil:</td><td><input type="text" name="movil"  onchange="verifica(this,6);" onkeyup="verifica(this,6);"></td></tr>'+
            '<tr><td>#Seguro:</td><td><input type="text" name="seguro"  onchange="verifica(this,1);" onkeyup="verifica(this,1);"></td></tr>'+
            '<tr><td>Direcci&oacute;n:</td><td><input type="text" name="direccion"  onchange="verifica(this,1);" onkeyup="verifica(this,1);"></td></tr>'+
            '<tr><td>Tel&eacute;fono Referencia:</td><td><input type="text" name="referencia"  onchange="verifica(this,5);" onkeyup="verifica(this,5);"></td></tr>'+
            '<tr><td>Interno:</td><td><input type="text" name="interno"  onchange="verifica(this,1);" onkeyup="verifica(this,1);"></td></tr>'+
            '<tr><td>Cuenta habilitada:</td><td><input name="state" checked type="checkbox" style="float:left"></td></tr>'+
            '<tr><td>Es Administrador:</td><td><input name="isadmin" type="checkbox" style="float:left"></td></tr>'+
            '<tr><td></td><td><button class="button" onclick="registrarUsuario();">Registrar</button><button class="button" onclick="cerrar();">Cancelar</button></td></tr>'+
            '</table></form>';
            var p=new myPopup();
            p.setTitle('Nuevo Usuario');
            p.setContent(content);
            p.show();
        });
}
function registrarUsuario()
{
    var b='';
    var u=document.getElementById("frmuser");
    if(!isValid(u))
    {
        alert('Verifique los campos en rojo o vacios');
        return;
    }
    for(i=0;i<u.elements.length;i++)
    {
        if(u.elements[i].type=='password' && u.elements[i].name!='')
        {
          b=b+u.elements[i].name+'='+u.elements[i].value+'&'  
        }
        if(u.elements[i].type=='text' && u.elements[i].name!='')
        {
          b=b+u.elements[i].name+'='+u.elements[i].value+'&'  
        }
        if(u.elements[i].type=='checkbox')
        {
          b=b+u.elements[i].name+'='+u.elements[i].checked+'&'; 
        }
        if(u.elements[i].type=='select-one')
        {
          b=b+u.elements[i].name+'='+u.elements[i].value+'&'; 
        }
    }
    var parametros = {
            
        };
        $.ajax({
            data:  parametros,
            url:   'controller/newUser.php?'+b,
            type:  'get',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle(name.value);
            p.setContent(response);
            p.show();
            usersgrid.clearAll();
            usersgrid.load("controller/getUsers.php","xml");
            }
        });    
}
function entrar()
{
    alert('d');
    document.location='panel.php';
}
function cerrar(){
    var p=new myPopup();
    p.hide();
    //document.location.reload();
}
function administrar()
{
    alert('entro');
        var parametros = {
            
        };
        $.ajax({
            data:  parametros,
            url:   'controller/getAdminPanel.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response){
            tabbar.setContentHTML("a1",response);
            }
        });
}
function test(p)
{
    alert(p);
}
function activarU(idu)
{
    var parametros = {
        "idu":idu
    };
    $.ajax({
        data:  parametros,
        url:   'controller/setUserActive.php',
        type:  'post',
        beforeSend: function () {

        },
        success:  function (response){
            usersgrid.clearAll();
            usersgrid.load("controller/getUsers.php","xml");
        }
    });
}
function desactivarU(idu)
{
    var parametros = {
        "idu":idu
    };
    $.ajax({
        data:  parametros,
        url:   'controller/setInactiveU.php',
        type:  'post',
        beforeSend: function () {

        },
        success:  function (response){
            usersgrid.clearAll();
            usersgrid.load("controller/getUsers.php","xml");
        }
    });
}
function modiftipo(idu)
{
    if(!confirm('Confirme')) return;
    var parametros = {
        "idu":idu
    };
    $.ajax({
        data:  parametros,
        url:   'controller/setTypeAccount.php',
        type:  'post',
        beforeSend: function () {
        },
        success:  function (response){
            usersgrid.clearAll();
            usersgrid.load("controller/getUsers.php","xml");
        }
    });

}
function edituser(idu)
{
    var parametros = {
        "idu":idu
    };
    $.ajax({
        data:  parametros,
        url:   'controller/editUser.php',
        type:  'post',
        beforeSend: function () {
        },
        success:  function (response){
            var p=new myPopup();
            p.setTitle('Datos personales');
            p.setContent(response);
            p.show();
        }
    });
}
function edituser2(idu)
{
    var parametros = {
        "idu":idu
    };
    $.ajax({
        data:  parametros,
        url:   'controller/editUser_1.php',
        type:  'post',
        beforeSend: function () {
        },
        success:  function (response){
            var p=new myPopup();
            p.setTitle('Datos personales');
            p.setContent(response);
            p.show();
        }
    });
}

function actualizarUsuario(idu)
{
    var b='';
    var u=document.getElementById("frmuser");
    if(!isValid(u))
    {
        alert('Verifique los campos en rojo o vacios');
        return;
    }
    for(i=0;i<u.elements.length;i++)
    {
        if(u.elements[i].name!='')
        {
          b=b+u.elements[i].name+'='+u.elements[i].value+'&'  
        }
    }
    var parametros = {
            
        };
        $.ajax({
            data:  parametros,
            url:   'controller/updateUser.php?'+b+'idu='+idu,
            type:  'get',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle(name.value);
            p.setContent(response);
            p.show();
            }
        });    
}
function actualizarDatos(idu)
{
    var b='';
    var u=document.getElementById("frmuser");
    if(!isValid(u))
    {
        alert('Verifique los campos en rojo o vacios');
        return;
    }
    for(i=0;i<u.elements.length;i++)
    {
        if(u.elements[i].name!='')
        {
          b=b+u.elements[i].name+'='+u.elements[i].value+'&'  
        }
    }
    var parametros = {
            
        };
        $.ajax({
            data:  parametros,
            url:   'controller/updateUser_1.php?'+b+'idu='+idu,
            type:  'get',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle(name.value);
            p.setContent(response);
            p.show();
            }
        });    
}

function deleteuser(idu)
{
    if(!confirm('Confirme'))return;
    var parametros = {
            "idu":idu
        };
        $.ajax({
            data:  parametros,
            url:   'controller/deleteUser.php',
            type:  'post',
            beforeSend: function () {
            },
            success:function(response){
            var p=new myPopup();
            p.setTitle('Eliminar.');
            p.setContent(response);
            p.show();
            usersgrid.clearAll();
            usersgrid.load("controller/getUsers.php","xml");
            }
        });    
}
