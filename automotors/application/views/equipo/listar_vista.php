<?php echo form_open('equipo',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:100%;padding:10px 10px;">
   
    <table id="tt" class="easyui-datagrid" width="100%"
            title="Equipos" iconCls="icon-save"
            rownumbers="true" pagination="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
            	<th field="cod_equipo" width="80"><b>CODIGO</b></th>
                <th field="desc_tipo_equipo" width="100"><b>TIPO EQUIPO</b></th>
                <th field="desc_marca" align="right"><b>MARCA</b></th>
                <th field="descripcion" align="right"><b>DESCRIPCION</b></th>
                <th field="observacion" align="right"><b>OBSERVACION</b></th>
                <th field="serie" align="right"><b>SERIE</b></th>
                <th field="fecha_registro" align="right"><b>FECHA_REGISTRO</b></th>
                <th field="desc_moneda" align="right"><b>MONEDA</b></th>
                <th field="valor" align="right"><b>VALOR</b></th>
                <th field="desc_tipo" align="right"><b>TIPO</b></th>
                <th field="desc_proveedor" align="right"><b>PROVEEDOR</b></th>
                <th field="desc_estado" align="right"><b>ESTADO</b></th>
                <th field="fecha_creacion" align="right"><b>FECHA CREACION</b></th>
                <th data-options="field:'ACCION'" formatter="BotonesAccion"><b>ACCION</b></th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
    	<?php if(isset($acc_registrar) && $acc_registrar == 'EQ_I'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo_registro()">Nuevo Registro</a>
        <?php endif;?>
		<?php $mensaje = $this->session->flashdata('mensaje');?>
    		<?php if($mensaje) :?>
	    		<div class="alert alert-<?= $mensaje['tipo']?>">
<!--	    			<strong>
						<?= $mensaje['titulo']?>
					</strong>-->
					<?= $mensaje['mensaje']?>
				</div>
			<?php endif;?>
    </div>

</div>
<input type="hidden" name="elemento" id="elemento" >
<input type="hidden" name="tipoAcc" id="tipoAcc" >
<input type="hidden" name="idAcc" id="idAcc" >
</form>

    <div id="dlg" class="easyui-dialog" title="Ingresar observacion" data-options="modal:true" style="width:400px;height:200px;padding:10px" iconCls="icon-ok" buttons="#dlg-buttons">
        	<div style="margin-bottom:10px">
        	    <input class="easyui-textbox" label="" labelPosition="top" style="width:100%;height:80px" id="inp_observacion" name="inp_observacion" data="required:true" data-options="multiline:true" value="" >
        	</div>
        <div id = "dlg-buttons">
		    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="doConfirmar()">Guardar</a>
		    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="closeDialog()">Cancelar / Volver</a>
    	</div>
    </div>

<script>
    data_grilla=<?= $data_grilla ?>;
     $('#cc').combobox({
		/*filter: function(q, row){
			var opts = $(this).combobox('options');
			return row[opts.textField].toLowerCase().indexOf(q.toLowerCase()) >= 0;
		},*/
        //onChange: function(seleccion,anterior){
        /*onSelect: function(row){
        		//console.log('valor: ' + seleccion.cod_personal + "  " + JSON.stringify(seleccion) + " " + JSON.stringify(anterior));
        	//if (seleccion.cod_personal){
        	if (row.cod_personal){
        		console.log('entre choco!!');
				//submitForm();	
				null;
			}
        },
        onkey: function(e){
			if(e.which == 13){
			    var inputVal = $(this).val();
			    alert("You've entered: " + inputVal);
			}
		}*/
    });
	function doSearch(){
		submitForm();
	}
	
    function submitForm() {
        $('#ff').form('submit');
    }

    function BotonesAccion(value,row) {
        if(row.menu_padre=="")
            return;

        var accionEditar = 'window.location.href = \'<?= base_url() ?>equipo/actualizar_form/'+row.cod_equipo+'\'';
        var accionEliminar = "openDialog('ELIMINAR','"+row.cod_equipo+"')";
        var accionActivar = "openDialog('ACTIVAR','"+row.cod_equipo+"')";

        btnVer="";
        var btnEditar='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Editar"    onclick="'+accionEditar+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-pencil">&nbsp;</span></span>';
        var btnEliminar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" title="Eliminar"  onclick="'+accionEliminar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-remove">&nbsp;</span></span>';
        var btnActivar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"  title="Activar"   onclick="'+accionActivar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-ok">&nbsp;</span></span>';
        
        acc_editar = '<?= $acc_editar ?>';
        acc_eliminar = '<?= $acc_eliminar ?>';
        acc_activar = '<?= $acc_activar ?>';
        
        
        var menusRole = '';
        if(acc_editar != '0') {
			menusRole += btnEditar;
		}
		if(acc_eliminar != '0') {
			menusRole += btnEliminar;
		}
		if(acc_activar != '0') {
			menusRole += btnActivar;
		}		
        return menusRole;
    }  
    
    function eliminar(id,nombre) {
        var r = confirm("Desea eliminar el registro\nId: "+id+"\nNombre: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>equipo/eliminar/"+id;
        } 
    }
    
    function activar(id,nombre) {
        var r = confirm("Desea activar el registro\nId: "+id+"\nNombre: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>equipo/activar/"+id;
        } 
    }
    
    function nuevo_registro() {
       window.location.href = "<?= base_url() ?>equipo/insertar_form/";
    }
    
    function doConfirmar(){
    	
    	var tipo = $('#tipoAcc').val();
    	var id = $('#idAcc').val();
    	var observacion = $('#inp_observacion').val();
    	var url;
		if (tipo == 'ACTIVAR'){
			url = "<?= base_url() ?>equipo/activar/"+id;
		} else {
			url = "<?= base_url() ?>equipo/eliminar/"+id;
		}
        event.preventDefault();
		
        $.ajax({
                type:"post",
                url: url,
                data:{ observacion: observacion},
                success:function(response)
                {
					window.location.href = "<?= base_url() ?>equipo";
                }
            });
		
	}
	
	function openDialog(tipo, id){
		$('#inp_observacion').val('');
		$('#tipoAcc').val(tipo);
		$('#idAcc').val(id);		
		$('#dlg').dialog('open');

	}
	
    function closeDialog(){
        $('#inp_observacion').val('');
        $('#dlg').dialog('close');
        $('#tipoAcc').val('');
		$('#idAcc').val('');
    }
    
	$(document).ready(function() {
		$('#dlg').dialog('close');
		$('#tipoAcc').val('');
		$('#idAcc').val('');
		
    });

</script>