<?php echo form_open('personalequipo/asignar_form/' . $cod_personal,array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:700px;padding:30px 60px;">
        <div style="margin-bottom:20px;text-align:center;">
		    <div style="margin-bottom:20px" id="cajaCombo">
		        <input id="tipo_equipo" class="easyui-combobox" name="tipo_equipo" labelPosition="top"
		    	data-options="valueField:'codigo',textField:'descripcion',data:tipo_equipo,prompt:'Elija el tipo equipo',required:true" style="width:100%;height:52px"  label="Tipo Equipo:"value="<?php 
	            if(isset($tipo_equipo)){ echo $tipo_equipo;}
	         	?>">
	         	
		        <input id="marca" class="easyui-combobox" name="marca" labelPosition="top"
		    	data-options="valueField:'codigo',textField:'descripcion',data:marca,prompt:'Elija la marca',required:true" style="width:100%;height:52px"  label="Marca:"value="<?php 
	            if(isset($marca)){ echo $marca;}
	         	?>">
	         	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" style="height:25px" onclick="doSearch()">Buscar</a>
		    </div>
		    
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
<!-- grupos de asignacion -->
    <div class="easyui-panel" title="Asignar Equipos <?= $cod_personal ?>" style="width:600px;height:300px;" data-options="border:false">
        <div class="easyui-layout" data-options="fit:true">
            <div data-options="region:'west'" style="width:250px">
                <ul class="easyui-datalist" title="Equipos disponibles" lines="true" style="width:245px;height:260px" id="listaAsignar" >
        		<?= $datosAAsignar;  ?>
        		</ul>
            </div>
            <div data-options="region:'east'" style="width:250px">
                <ul id="listaAsignados"  class="easyui-datalist" title="Equipos asignados" lines="true" style="width:240px;height:260px"  >
        		<?= $datosAsignados;  ?>
        		</ul>
            </div>
            <div data-options="region:'center'" style="width:100px">
	            <?php if(isset($acc_registrar) && $acc_registrar == 'PE_I'):?>
		            <a id="btn" href="#" class="easyui-linkbutton" data-options="iconCls:'icono-arrow_right',iconAlign:'right'" style="padding:8px;margin:5px;width:90px" onclick="openDialog('#dlgAsignar');">Asignar</a>
		        <?php endif;?>
		        <?php if(isset($acc_eliminar) && $acc_eliminar == 'PE_D'):?>
		            <a id="btn" href="#" class="easyui-linkbutton" data-options="iconCls:'icono-arrow_left'" style="padding:8px;margin:5px;width:90px" onclick="openDialog('#dlgQuitar');">Quitar</a>       
		        <?php endif;?>
            </div>
        </div>
    </div>
    <br>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>
<!--/ grupos de asignacion -->
    <div id="toolbar">

    </div> 
   
    
</div>
<input type="hidden" name="operacion" id="operacion" >
<input type="hidden" value=<?=  $cod_personal ?> name="cod_personal" id="cod_personal">
<input type="hidden" name="elemento" id="elemento" >

</form>

    <div id="dlgAsignar" class="easyui-dialog" title="Confirmar" data-options="modal:true" style="width:400px;height:250px;padding:10px" iconCls="icon-ok" buttons="#dlgAsignar-buttons">
        	
        	<div style="margin-bottom:10px">
        	    <input class="easyui-textbox" label="Nombre Equipo" labelPosition="top" style="width:100%;height:52px" id="nombre_equipo" name="nombre_equipo" data="" data-options="" value="" >
        	</div>
        	
        	<div style="margin-bottom:10px">
        	    <input class="easyui-textbox" label="Descripcion" labelPosition="top" style="width:100%;height:70px" id="descripcion" name="descripcion" data="" data-options="multiline:true" value="" >
        	</div>
        	
        <div id = "dlgAsignar-buttons">
		    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="doConfirmar('I')">Guardar</a>
		    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="closeDialog()">Cancelar / Volver</a>
    	</div>
    </div>
    
    <div id="dlgQuitar" class="easyui-dialog" title="Ingresar Observacion" data-options="modal:true" style="width:400px;height:200px;padding:10px" iconCls="icon-ok" buttons="#dlgQuitar-buttons">
    	
        	<div style="margin-bottom:10px">
        	    <input class="easyui-textbox" label="" labelPosition="left" style="width:100%;height:80px" id="observacion" name="observacion" data="required:true" data-options="multiline:true" value="" >
        	</div>
        	
        	
        <div id = "dlgQuitar-buttons">
		    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="doConfirmar('D')">Guardar</a>
		    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="closeDialog()">Cancelar / Volver</a>
    	</div>
    </div>

<script>
    var tipo_equipo=<?= $tipo_equipo_lst ?>;
    var marca=<?= $marca_lst ?>;
    
	function doSearch(){
		submitForm();
	}
	
    
    $('#cc').combogrid({
        onChange: function(seleccion,anterior){
            submitForm();
        }
    });

    function submitForm(){
        $('#ff').form('submit');
    }
    /*function Asignar()
    {
        try{
            $("#elemento").val($('#listaAsignar').datalist('getSelected').value);
            $("#operacion").val('I');
            submitForm();
        }catch(err){};
    }
    function Quitar()
    {
        try{
            $("#elemento").val($('#listaAsignados').datalist('getSelected').value);
            $("#operacion").val('D');
            submitForm();
        }catch(err){};
    }*/
    
    function cancelar(){
        window.location.href =" <?= base_url() ?>personalequipo";
    }
    
    function doConfirmar(operacion){
    	
    	//var tipo = $('#tipoAcc').val();
    	//var id = $('#idAcc').val();
    	var cod_personal_equipo;
    	var cod_equipo;
    	var cod_personal = $('#cod_personal').val();
    	var nombre_equipo = $('#nombre_equipo').val();
    	var descripcion = $('#descripcion').val();
    	var observacion = $('#observacion').val();
    	var tipo_equipo = $('#tipo_equipo').val();
    	var marca = $('#marca').val();
    	var url;
    	
    	/*console.log('Tipo_equipo: ' + $('#tipo_equipo').val());
    	console.log('marca: ' + $('#marca').val());*/
    	if (operacion == 'I'){
			cod_equipo = $('#listaAsignar').datalist('getSelected').value;
			//console.log('cod_equipo: ' + cod_equipo);
		}else{
			cod_personal_equipo = $('#listaAsignados').datalist('getSelected').value;
		}
    	
		url = "<?= base_url() ?>personalequipo/guardar";
		//console.log('Estoy en doConfirmar: ' + tipo + ' '+ id + ' ' + observacion + ' ' + url);
        event.preventDefault();
		
        $.ajax({
                type:"post",
                url: url,
                dataType: "json",
                data:{ 	operacion: operacion,
                		cod_personal_equipo: cod_personal_equipo,
                		cod_equipo: cod_equipo,
                		cod_personal: cod_personal,
                		nombre_equipo: nombre_equipo,
                		descripcion: descripcion,
                		observacion: observacion,
                		tipo_equipo: tipo_equipo,
                		marca: marca
                		},
                success:function(response)
                {
					/*console.log('resultado: ' + JSON.stringify(response));
					console.log('resultado2: ' + response.resultado);*/
					if ((operacion == 'I')&&(response.resultado == 0)){
						window.open("<?= base_url() ?>reportes/comprobanteAsignacion/" + cod_personal);
					}
					window.location.href = "<?= base_url() ?>personalequipo/asignar_form/" + cod_personal;
                }
            });
		
	}
	
	function openDialog(dlg){
/*		console.log('asginar : ' + JSON.stringify($('#listaAsignar').datalist('getSelected').value));
		console.log('asignado : ' + JSON.stringify($('#listaAsignados').datalist('getSelected').value));
		if (($('#listaAsignar').datalist('getSelected').value == null) && (dlg == '#dlgAsignar')) {
			return;
		}
		
		if (($('#listaAsignados').datalist('getSelected').value == null) && (dlg == '#dlgQuitar')) {
			return;
		}*/
		
	    $('#observacion').val('');
	    $('#descripcion').val('');
	    $('#nombre_equipo').val('');
		$(dlg).dialog('open');
	}
	
    function closeDialog(){
        //window.location.href =" <?= base_url() ?>proveedor";
        $('#observacion').val('');
        $('#descripcion').val('');
        $('#nombre_equipo').val('');
        $('#dlgAsignar').dialog('close');
        $('#dlgQuitar').dialog('close');

    }
    
	$(document).ready(function() {
		$('#dlgAsignar').dialog('close');
		$('#dlgQuitar').dialog('close');
		
    });
    
    
</script>