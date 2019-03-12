function keyup(txt)
{
    var pattern=/^[a-zA-Z0-9 \.\,\-_\n\@áéíóúÁÉÍÓÚ\ñ\Ñ]+$/;
    txt.style.color='black';
    if(!pattern.test(txt.value))
    {
        txt.style.color='red';
    }
}
function eliminarActividad(ida)
{
    if(!confirm('Confirme'))return;
    var parametros = {
        "ida":ida
        };
        $.ajax({
                data:  parametros,
                url:   'controller/delActividad.php',
                type:  'post',
                beforeSend: function () {
                        
                },
                success:  function (response) {
                        location.reload();
                        $('#contenid').html(response) ;
                }
        });
}
function guardarActividad(f)
{
    var t=document.getElementById('ta');
    var tp=document.getElementById('timePicker');
    var pub=document.getElementById('public');
    var cad=t.value.replace(/\n/gi,'<br>');
    var titulo=document.getElementById('tituloa');
    keyup(titulo);
    keyup(t);
    if(t.style.color=='red')return;
    if(titulo.style.color=='red')return;
    if(!confirm('Confirme'))return;
    var parametros = {
                "fecha":f,
                "titulo":titulo.value,
                "text":cad,
                "time":tp.value,
                "public":pub.checked
        };
        $.ajax({
                data:  parametros,
                url:   'controller/saveEvent.php',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (response) {
                    alert(response);
                        $('#contenid').html(response) ;
                         location.reload();
                }
        });
}
function contar(t)
{
    $('#contador').html(200-t.value.length+' restantes..');
    keyup(t);
}
function nuevaActividad()
{
    if($('.eventsCalendar-subtitle').html().length<20)
    {
        alert('No selecciono una fecha para la actividad.');
        return;
    }
    var rr=document.getElementById('contenid');
    rr.style.display='block';
    var d=$('.eventsCalendar-subtitle').html().split(' ');
    if(d.length==4)
    {
        d=d[0]+'/'+d[1]+'/'+d[2];
    }else
    {
       d= 'DATE'+$('.meeting em').html();
    }
    var response='<label>Hora de la Actividad:</label><select id="timePicker" style="width:200px; font-size:15px;">';
   for(i=6;i<=23;i++)
   {
       if(i<10)
       {
           response=response+'<option value="0'+i+':00">0'+i+':00</option>';
           response=response+'<option value="0'+i+':15">0'+i+':15</option>';
           response=response+'<option value="0'+i+':30">0'+i+':30</option>';
           response=response+'<option value="0'+i+':45">0'+i+':45</option>';
       }else
       {
           response=response+'<option value="'+i+':00">'+i+':00</option>';
           response=response+'<option value="'+i+':15">'+i+':15</option>';
           response=response+'<option value="'+i+':30">'+i+':30</option>';
           response=response+'<option value="'+i+':45">'+i+':45</option>';
       }
   }
   response=response+'</select><input type="checkbox" id="public">esta actividad es para todo el MOPSV<br><label>T&iacute;tulo de la Actividad:</label><br><input id="tituloa" type="text" maxlength="50" onkeyup="keyup(this);"/><br><label>Actividad:</label><textarea id="ta" maxlength="200" onkeyup="contar(this);"></textarea><br><div id="contador"></div><button class="button" onclick="guardarActividad('+String.fromCharCode(39)+d+String.fromCharCode(39)+');">Guardar</button>';
   response=response+'<button class="button" onclick="cancelar();">Cancelar</button>';
   $('#contenid').html(response) ;
}
function cancelar()
{
   var rr=document.getElementById('contenid');
   rr.style.display='none';
}
function espera(param)
{
    var d=document.getElementById('resultado');
    if(param=='1')
    {
            d.style.display='block';
    }else
    {
            d.style.display='none';
    }
}
function ocultar(){
    $("#popupwindow").fadeOut(200, "linear");
}

