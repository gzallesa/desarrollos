<?php echo form_open('datospersonal',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:3000px;padding:30px 60px;">
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
            title="Datos Personal" iconCls="icon-save"
            rownumbers="true" pagination="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
            	<th field="COD_PERSONAL_PLANILLA" width="80"><b>CODIGO</b></th>
                <th field="DESC_DIVISION_NEGOCIO" align="right"><b>DIVISION NEGOCIO</b></th>
                <th field="DESC_CENTRO_GESTION" align="right"><b>CENTRO GESTION</b></th>
                <th field="FECHA_INGRESO" align="right"><b>FECHA INGRESO</b></th>
                <th field="FECHA_SALIDA" align="right"><b>FECHA SALIDA</b></th>
                <th field="SUELDO_BASICO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.SUELDO_BASICO,2);}"><b>SUELDO BASICO</b></th>
                <th field="FECHA_NACIMIENTO" align="right"><b>FECHA NACIMIENTO</b></th>
                <th field="DESC_TIPO_DOCUMENTO" align="right"><b>TIPO DOCUMENTO</b></th>
                <th field="NUMERO_DOCUMENTO" align="right"><b>NRO DOCUMENTO</b></th>
                <th field="DESC_EXPEDIDO" align="right"><b>EXPEDIDO</b></th>
                <th field="MATRICULA" align="right"><b>MATRICULA</b></th>
                <th field="DESCR_AFP" align="right"><b>AFP</b></th>
                <th field="DESC_TIPO_PLANILLA" align="right"><b>TIPO PLANILLA</b></th>
                <th field="DESC_TIPO_EMPLEADO" align="right"><b>TIPO EMPLEADO</b></th>
                <th field="CUENTA" align="right"><b>CUENTA</b></th>
                <th field="DESC_EXCEPCIONADO" align="right"><b>EXCEPCIONADO</b></th>
                <th field="DESC_PAGO_AGUINALDO" align="right"><b>PAGO_AGUINALDO</b></th>
                <th data-options="field:'ACCION'" formatter="BotonesAccion"><b>ACCION</b></th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
    	<?php if(isset($acc_registrar) && $acc_registrar == 'DP_I'):?>
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
        var accionQuery = 'window.location.href = \'<?= base_url() ?>datospersonal/consultar_form/'+row.COD_PERSONAL_PLANILLA+'\'';
        var accionEditar = 'window.location.href = \'<?= base_url() ?>datospersonal/actualizar_form/'+row.COD_PERSONAL_PLANILLA+'\'';
        var accionEliminar='eliminar(\''+row.COD_PERSONAL_PLANILLA+'\')';
        //var accionActivar='activar(\''+row.COD_IP+'\',\''+row.IP+'\')';

        //var btnVer='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+ accionVer +'"><span class="l-btn-text"></span><span class="l-btn-icon icono-magnifier">&nbsp;</span></span>';
        btnVer="";
        var btnEditar='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Editar"    onclick="'+accionEditar+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-pencil">&nbsp;</span></span>';
        var btnEliminar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" title="Eliminar"  onclick="'+accionEliminar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-remove">&nbsp;</span></span>';
        var btnQuery='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Consultar"    onclick="'+accionQuery+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-find">&nbsp;</span></span>';
        
        acc_editar = '<?= $acc_editar ?>';
        acc_eliminar = '<?= $acc_eliminar ?>';
        acc_consultar = '<?= $acc_consultar ?>';
        
        var menusRole = '';
        if(acc_editar != '0') {
			menusRole += btnEditar;
		}
		if(acc_eliminar != '0') {
			menusRole += btnEliminar;
		}
        if(acc_consultar != '0') {
			menusRole += btnQuery;
		}
//		return btnEditar + btnEliminar + btnActivar;
        return menusRole;
    }  
    
    function eliminar(id) {
        var r = confirm("Desea eliminar el registro\nId: "+id);
        if (r == true) {
            window.location.href = "<?= base_url() ?>datospersonal/eliminar/"+id;
        } 
    }
    
    function nuevo_registro() {
      var codPersonal;
      //console.log('valor seleccionado: ' + $('#cc').val());
      if ($('#cc').val() == '') {
	  	codPersonal = 'null';
	  }else{
	  	codPersonal = $('#cc').val();
	  }
       window.location.href = "<?= base_url() ?>datospersonal/insertar_form/" + codPersonal; 
    }
</script>