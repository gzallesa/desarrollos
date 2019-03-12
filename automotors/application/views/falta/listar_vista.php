<?php echo form_open('falta',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:70%;padding:30px 60px;">
        <div style="margin-bottom:20px;text-align:center;">
            <select id="cc" class="easyui-combobox" name="cod_personal" style="width:300px;" data-options="
                    valueField:'cod_personal',
                    textField:'nombre_completo',
                    panelHeight:'auto',
                    label: 'Personal:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $data_combo ?>;
                </select>
	    	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" style="height:25px" onclick="doSearch()">Buscar</a>
        </div>
    
    <table id="tt" class="easyui-datagrid" width="100%"
            title="Faltas" iconCls="icon-save"
            rownumbers="true" pagination="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
            	<th field="cod_dia_falta" width="80"><b>CODIGO</b></th>
                <th field="cod_personal" width="100"><b>PERSONAL</b></th>
                <th field="nombre_completo" align="right"><b>NOMBRE COMPLETO</b></th>
                <th field="desc_tipo_planilla" align="right"><b>TIPO PLANILLA</b></th>
                <th field="descripcion" align="right"><b>DESCRIPCION</b></th>
                <th field="periodo" align="right"><b>PERIODO</b></th>
                <th field="valor" align="right"><b>VALOR</b></th>
                <th field="fecha_creacion" align="right"><b>FECHA CREACION</b></th>
                <th data-options="field:'ACCION'" formatter="BotonesAccion"><b>ACCION</b></th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
    	<?php if(isset($acc_registrar) && $acc_registrar == 'FA_I'):?>
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
</form>

<script>
    data_grilla=<?= $data_grilla ?>;
    console.log('Data grilla : ' + JSON.stringify(data_grilla));
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

        //var accionVer = 'window.location.href = \'<?= base_url() ?>medioscontacto//'+row.menu_web_opcion+'\'';
        var accionEditar = 'window.location.href = \'<?= base_url() ?>falta/actualizar_form/'+row.cod_dia_falta+'\'';
        var accionEliminar='eliminar(\''+row.cod_dia_falta+'\',\''+row.nombre_completo+'\')';
        
        //var btnVer='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+ accionVer +'"><span class="l-btn-text"></span><span class="l-btn-icon icono-magnifier">&nbsp;</span></span>';
        btnVer="";
        var btnEditar='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Editar"    onclick="'+accionEditar+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-pencil">&nbsp;</span></span>';
        var btnEliminar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" title="Eliminar"  onclick="'+accionEliminar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-remove">&nbsp;</span></span>';
        //var btnActivar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"  title="Activar"   onclick="'+accionActivar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-ok">&nbsp;</span></span>';
        
        acc_editar = '<?= $acc_editar ?>';
        acc_eliminar = '<?= $acc_eliminar ?>';
        /*acc_activar = '<?= $acc_activar ?>';*/
        var menusRole = '';
        if(acc_editar != '0') {
			menusRole += btnEditar;
		}
		if(acc_eliminar != '0') {
			menusRole += btnEliminar;
		}
		/*if(acc_eliminar != '0') {
			menusRole += btnEliminar;
		}*/
		/*if(acc_activar != '0') {
			menusRole += btnActivar;
		}*/		
//		return btnEditar + btnEliminar + btnActivar;
        return menusRole;
    }  
    
    function eliminar(id,nombre) {
        var r = confirm("Desea eliminar el registro\nId: "+id+"\nPersonal: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>falta/eliminar/"+id;
        } 
    }
    
    /*function activar(id,nombre) {
        var r = confirm("Desea activar el registro\nId: "+id+"\nIP: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>ip/activar/"+id;
        } 
    }*/
    
    function nuevo_registro() {
      var codPersonal;
      //console.log('valor seleccionado: ' + $('#cc').val());
      if ($('#cc').val() == '') {
	  	codPersonal = 'null';
	  }else{
	  	codPersonal = $('#cc').val();
	  }
       window.location.href = "<?= base_url() ?>falta/Insertar_form/" + codPersonal; 
    }
</script>