<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php echo $output; ?>
<!--    <div id="dlg" name="dlg" class="easyui-dialog" title="Ingresar Fecha Salida" data-options="modal:true" closed="true" iconCls="icon-ok" buttons="#dlg-buttons" style="width:400px;height:140px;padding:10px">
        <div style="margin-bottom:10px">
            <input class="easyui-datebox" style="width:100%;height:24px"  name="fecha_salida" id="fecha_salida" data-options="" value=""  required="required">
        </div>
        <div id = "dlg-buttons">
		    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="doEliminar()">Guardar</a>
		    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="closeDialog()">Cancelar / Volver</a>
    	</div>
    	<input type="hidden" id="codPersonalAux" name="codPersonalAux"/>
    </div>-->
<script>
	function confirmActivar(delUrl, valor) {
 		if (confirm("Activar Personal " + valor + " ?")) {
  			document.location = delUrl + "/" +valor;
 		}
	}
	/*function openDialog(valor){
		$.noConflict()
		$('#fecha_salida').datebox('setValue', '');
		$('#codPersonalAux').val(valor);
		$('#dlg').dialog('open');
 	}

	
    function closeDialog(){
    	$.noConflict()
    	$('#fecha_salida').datebox('setValue', '');
        $('#dlg').dialog('close');
    }
    
    function doEliminar(){
    	$.noConflict()
    	var fechaSalida = $('#fecha_salida').datebox('getValue');
    	var codPersonal = $('#codPersonalAux').val();
        var url = '<?= base_url() ?>personal/eliminar/' + codPersonal;
        
        event.preventDefault();
		
        $.ajax({
                type:"post",
                url: url,
                dataType: "json",
                data:{ fechaSalida: fechaSalida},
                success:function(response)
                {
					if (response.resultado == 1){
						$.messager.alert('Error',response.error,'error');
					}else{
						window.location.href = "<?= base_url() ?>personal";	
					}
					
                }
            });
		
	}

	//$.noConflict();

	$.fn.datebox.defaults.formatter = function(date) {
		var y = date.getFullYear();
		var m = date.getMonth() + 1;
		var d = date.getDate();
		return (d < 10 ? '0' + d : d) + '/' + (m < 10 ? '0' + m : m) + '/' + y;
	};

	$.fn.datebox.defaults.parser = function(s) {
		if (s) {
			var a = s.split('/');
			var d = new Number(a[0]);
			var m = new Number(a[1]);
			var y = new Number(a[2]);
			var dd = new Date(y, m-1, d);
			return dd;
		} else {
			return new Date();
		}
	};*/


</script>