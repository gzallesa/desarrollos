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
    tabbar.addTab("a2","Grupos","200px");
    tabbar.setTabActive("a1");
    dhxAccord.setEffect(true);
    mygrid = tabbar.cells("a2").attachGrid();
    usersgrid= tabbar.cells("a1").attachGrid();
       mygrid.setImagePath("codebase/imgs/");
       mygrid.setHeader("Nombre de Grupo,Administrar Usuarios,Modificar,Eliminar");
       mygrid.setColAlign("center,center,center,center")
       mygrid.setSkin("light");
       mygrid.setColSorting("str");
       mygrid.setColTypes("ro,ro,ro,ro");
       mygrid.init();
       mygrid.load("controller/getGrupos.php","xml");
       usersgrid.setImagePath("codebase/imgs/");
       usersgrid.setHeader("NOMBRE DE USUARIO,ESTADO,GRUPO,TIPO DE USUARIO,MODIFICAR,ELIMINAR");
       usersgrid.setColAlign("left,center,left,left,center,center")
       usersgrid.setSkin("light");
       usersgrid.setColSorting("str,str,str,str,na,na");
       usersgrid.setColTypes("ro,ro,ro,ro,ro,ro");
       usersgrid.init();
       usersgrid.load("controller/getUsers.php","xml");
    var toolbar=tabbar.cells("a2").attachToolbar();
        toolbar.setIconsPath("codebase/common/imgs/");
        toolbar.addButton("a", "1", "Nuevo Grupo","newg.png",null);
        toolbar.attachEvent("onClick", function(id){   
                var r=prompt("Nombre del Nuevo Grupo:");
                if(r!=null)
                {
                    nuevoGrupo(r);
                }
            });
    var toolbar2=tabbar.cells("a1").attachToolbar();
        toolbar2.setIconsPath("codebase/common/imgs/");
        toolbar2.addButton("nuevo", "1", "Nuevo Usuario","newu.png",null);
        toolbar2.attachEvent("onClick", function(id){   
            getForm();
        });
}
function getForm()
{
    var parametros = {
        
    };
    $.ajax({
        data:  parametros,
        url:   'controller/getNewUser.php',
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
            usersgrid.clearAll();
            usersgrid.load("controller/getUsers.php","xml");
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
            url:   'controller/newUser_1.php?'+b,
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
function quitarG()
{
    var d=document.getElementById('usugru');
    d.remove(d.selectedIndex);
}
function deleteGroup(id)
{
    if(!confirm('Confirme')) return;
    var parametros = {
            "idg" : id
        };
        $.ajax({
            data:  parametros,
            url:   'controller/deleteGroup.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle(name.value);
            p.setContent(response);
            p.show();
            mygrid.clearAll();
            mygrid.load("controller/getGrupos.php","xml");
            }
        });    

}
function nuevoGrupo(valor)
{
    var parametros = {
            "name" : valor
        };
        $.ajax({
            data:  parametros,
            url:   'controller/saveGroup.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle('Nuevo Grupo');
            p.setContent(response);
            p.show();
            mygrid.clearAll();
            mygrid.load("controller/getGrupos.php","xml");
            }
        });    
}
function reAsignar(idu)
{
    if(!confirm('Confirme'))return;
    var x=document.getElementById('selg');
    var parametros = {
            "idu" : idu,
            "idg":x.value
        };
        $.ajax({
            data:  parametros,
            url:   'controller/saveUserGroup.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle('Reasignar.');
            p.setContent(response);
            p.show();
            usersgrid.clearAll();
            usersgrid.load("controller/getUsers.php","xml");
            }
        });    
}
function asignar(idu)
{
    var parametros = {
            "idu" : idu
        };
        $.ajax({
            data:  parametros,
            url:   'controller/asignGroup.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle('Asignar Grupo');
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
function editGroup(idg)
{
    var p=new myPopup();
    p.setTitle('Modificar nombre de grupo.');
    p.setContent('<input type="text" id="editgr"/><br><button class="button" onclick="updateGroup('+idg+');">Guardar</button><button class="button" onclick="cerrar();">Cancelar</button>');
    p.show();
}
function updateGroup(idg)
{
    var x=document.getElementById('editgr');
    if(!confirm('Confirme')) return;
    var parametros = {
        "idg":idg,
        "newname":x.value
    };
    $.ajax({
        data: parametros,
        url: 'controller/updateGroup.php',
        type: 'post',
        beforeSend: function(){
        },
        success: function(response){
        var p=new myPopup();
            p.setTitle('Grupo.');
            p.setContent(response);
            p.show();
            mygrid.clearAll();
            mygrid.load("controller/getGrupos.php","xml");
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
