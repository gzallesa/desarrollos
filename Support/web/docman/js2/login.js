function showInstant(e,file)
{
    if($("#instantpreview").css('display')=='block')return;
    $("#instantpreview").css('left',e.clientX-1);
    $("#instantpreview").fadeIn(200, "linear");
    $("#instantpreview").html('<div id="pdf"><a href="rootfolder/"+file></a></div>');
    var success = new PDFObject({ url: "rootfolder/"+file,pdfOpenParams: {
				navpanes: 0,
				toolbar: 0,
				statusbar: 0,
				view: "FitH"
			} }).embed("pdf");
}
function hiddeInstant()
{
    $("#instantpreview").fadeOut(200, "linear");
}
function marcartodos(si)
{
    var y=document.getElementsByName('chk[]');
    for(i=0;i<y.length;i++)
    {
        y[i].checked=si;
    }
}
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
function nuevoFolder()
{
    var c='Nombre:<input type="text" id="newname"><br><br><button class="button" onclick="makefolder();">Crear</button><button class="button" onclick="cerrar();">Cancelar</button>';
    var p=new myPopup();
    p.setTitle('Nuevo Directorio.');
    p.setContent(c);
    p.show();
}
function entrar()
{
    alert('d');
    document.location='panel.php';
}
function mostrar(){
    var p=new myPopup();
    p.setTitle('Carg de archivos');
    p.setContent('<iframe src="indexup.php" width="420" height="200" style="border:none;overflow-y:scroll;"></iframe><br><button class="button" onclick="cerrar();">Aceptar</button>');
    p.show();
}
function cerrar(){
    var p=new myPopup();
    p.hide();
}
function actualizar(){
    var p=new myPopup();
    p.hide();
    openfolder(document.getElementById('currentpath').value);
    //document.location.reload();
}
function stat()
{
    var x=document.getElementById('contenido');
    x.innerHTML='<iframe id="iframe1" src="charts/index.html" style="width:100%;height:700px;border:none;" scrolling="no"></iframe>';
}
function makefolder()
{
    me();
    var name=document.getElementById('newname');
    var parametros = {
            "name" : name.value
        };
        $.ajax({
            data:  parametros,
            url:   'controller/createFolder.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
                oe();
                if(response=='0')
                {
                    
                }
                var p=new myPopup();
                    p.setTitle(name.value);
                    p.setContent(response);
                    p.show();
            }
        });
}
function openfile(idf)
{
    document.location='controller/downloadFile.php?idf='+idf;
}
function openfolder(idf)
{
    var x=document.getElementById('buttons');
    for(i=0;i<x.childNodes.length;i++)
    {
        if(x.childNodes[i].nodeName=='BUTTON')
        {
            x.childNodes[i].disabled=false;
        }
    }
     var parametros = {
            "idf" : idf
        };
        $.ajax({
            data:  parametros,
            url:   'controller/getFiles_1.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var x=document.getElementById('tablefolders');
            if(document.getElementById('currentpath')!=null)
            {
                trailscrl.addTrail(document.getElementById('currentpath').value,window.pageYOffset);
            }    
                    x.innerHTML=response;
                    jQuery('body,html').animate({
                    scrollTop: trailscrl.getPosition(idf)
                    }, 800);
            }
        });   
}
function opensharefolders(idf)
{
    var x=document.getElementById('buttons');
    for(i=0;i<x.childNodes.length;i++)
    {
        if(x.childNodes[i].nodeName=='BUTTON')
        {
            x.childNodes[i].disabled=true;
        }
    }
     var parametros = {
            "idf" : idf
        };
        $.ajax({
            data:  parametros,
            url:   'controller/getShareFolders.php',
            type:  'post',
            beforeSend: function () {
            },
            success:function (response) {
            var x=document.getElementById('tablefolders');
            x.innerHTML=response;
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            }
        });   
}

function opensharefolder(idf)
{
    var x=document.getElementById('buttons');
    for(i=0;i<x.childNodes.length;i++)
    {
        if(x.childNodes[i].nodeName=='BUTTON')
        {
            x.childNodes[i].disabled=true;
        }
    }
     var parametros = {
            "idf" : idf
        };
        $.ajax({
            data:  parametros,
            url:   'controller/getShareFiles.php',
            type:  'post',
            beforeSend: function () {
            },
            success:function (response) {
            var x=document.getElementById('tablefolders');
            x.innerHTML=response;
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            }
        });   
}
function renamefolder(idf)
{
    var c='Nombre:<input type="text" id="newname"><br><br><button class="button" onclick="removefolder('+idf+');">Aceptar</button><button class="button" onclick="cerrar();">Cancelar</button>';
    var p=new myPopup();
    p.setTitle('Renombrar carpeta.');
    p.setContent(c);
    p.show();
}
function renamefile(idf)
{
    var c='Nuevo nombre:<input type="text" id="newname"><br><br><button class="button" onclick="rename('+idf+');">Aceptar</button><button class="button" onclick="cerrar();">Cancelar</button>';
    var p=new myPopup();
    p.setTitle('Renombrar archivo.');
    p.setContent(c);
    p.show();
}
function rename(idf)
{
    var name=document.getElementById('newname');
       var parametros = {
            "idf" : idf,
            "newname":name.value
        };
        $.ajax({
            data:  parametros,
            url:   'controller/renameFile.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle('Renombrado');
            p.setContent(response);
            p.show();
            }
        });
}
function removefolder(idf)
{
    var name=document.getElementById('newname');
       var parametros = {
            "idf" : idf,
            "newname":name.value
        };
        $.ajax({
            data:  parametros,
            url:   'controller/renameFolder.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle('Renombrado');
            p.setContent(response);
            p.show();
            }
        });
}
function deletefolder(idf)
{
    if(!confirm('Confirme'))return;
       var parametros = {
            "idf" : idf
        };
        $.ajax({
            data:  parametros,
            url:   'controller/deleteFolder.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle('Eliminado');
            p.setContent(response);
            p.show();
            }
        });
}
function deletefolder2(idf)
{
    if(!confirm('Confirme'))return;
       var parametros = {
            "idf" : idf
        };
        $.ajax({
            data:  parametros,
            url:   'controller/deleteFolder2.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle('Eliminado');
            p.setContent(response);
            p.show();
            }
        });
}

function deletefile(idf)
{
    if(!confirm('Confirme'))return;
       var parametros = {
            "idf" : idf
        };
        $.ajax({
            data:  parametros,
            url:   'controller/deleteFile.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
            var p=new myPopup();
            p.setTitle('Eliminado');
            p.setContent(response);
            p.show();
            }
        });
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
function buscar()
{
    var x=document.getElementById('contenido');
    var b=document.getElementById('srch');
    x.innerHTML='<img src="images/espera.gif">';
    var parametros = {
        "strword":b.value
    };
    $.ajax({
        data:  parametros,
        url:   'controller/search.php',
        type:  'post',
        beforeSend: function () {

        },
        success:  function (response){
            x.innerHTML=response;
        }
    });
}
function openRecycleFolder(idf)
{
    var parametros = {
        "idf":idf
    };
    $.ajax({
        data:  parametros,
        url:   'controller/getRecycledFiles.php',
        type:  'post',
        beforeSend: function () {

        },
        success:  function (response){
            alert(response);
            var x=document.getElementById('tablefolders');
            x.innerHTML=response;
        }
    });
   
}
function modiftipo(idf)
{
    alert(idf);
}
function filepermissions(idf)
{
    var parametros = {
        "idf":idf
    };
    $.ajax({
        data:  parametros,
        url:   'controller/getFilePermissions.php',
        type:  'post',
        beforeSend: function () {

        },
        success:  function (response){
            var p=new myPopup();
            p.setTitle('Permisos de Archivo.');
            p.setContent(response);
            p.show();
        }
    });
}
function folderpermissions(idf)
{
    var parametros = {
        "idf":idf
    };
    $.ajax({
        data:  parametros,
        url:   'controller/getFolderPermissions.php',
        type:  'post',
        beforeSend: function () {

        },
        success:  function (response){
            var p=new myPopup();
            p.setTitle('Permisos de Folder.');
            p.setContent(response);
            p.show();
        }
    });

}
function savePermissions(idf)
{
    var x=document.getElementById('fper');
    var b='';
    for(i=0;i<x.elements.length;i++)
    {
        if(x.elements[i].nodeName!='BUTTON')
        {
            b=b+x.elements[i].name+'='+x.elements[i].checked+'&';
        }
    }
    var parametros = {
        "idf":idf,
        "chk":b
    };
    $.ajax({
        data:  parametros,
        url:   'controller/saveFilePermissions.php',
        type:  'post',
        beforeSend: function () {

        },
        success:  function (response){
            var p=new myPopup();
            p.setTitle('Permisos de Archivo.');
            p.setContent(response);
            p.show();
        }
    });
}
function saveFPermissions(idf)
{
    var x=document.getElementById('fper');
    var b='';
    for(i=0;i<x.elements.length;i++)
    {
        if(x.elements[i].nodeName!='BUTTON')
        {
            b=b+x.elements[i].name+'='+x.elements[i].checked+'&';
        }
    }
    var parametros = {
        "idf":idf,
        "chk":b
    };
    $.ajax({
        data:  parametros,
        url:   'controller/saveFolderPermissions.php',
        type:  'post',
        beforeSend: function () {
        },
        success:  function (response){
            var p=new myPopup();
            p.setTitle('Permisos de Archivo.');
            p.setContent(response);
            p.show();
        }
    });

}
function buscarf()
{
    var c=document.getElementById('txtbf');
    var x=document.getElementById('contenido');
    x.innerHTML='<iframe src="controller/searchUser_1.php?txtbf='+c.value+'" style="width:100%;height:600px;border:none;padding:none;" scrolling="no"></iframe>';
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
function keypress(e,index)
{
    switch(index)
    {
        case 1:
            if(e.keyCode==13)
            {
                buscarf();
            }
            break;
        case 2:
            if(e.keyCode==13)
            {
                buscar();
            }
            break;
    }
    
}
function deletgroup()
{
    var tbl=document.getElementById('tablefoldersload');
    for(i=0;i<tbl.rows.length;i++)
    {
        alert(tbl.rows[i].cells[0].childNodes[1].nodeName);
    }
}