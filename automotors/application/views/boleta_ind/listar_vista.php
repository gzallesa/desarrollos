<?php echo form_open('boleta_ind',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:3000px;padding:30px 60px;">
        <div style="margin-bottom:20px;text-align:center;">
        
            <select id="cod_personal" class="easyui-combobox" name="cod_personal" style="width:300px;" data-options="
                    valueField:'cod_personal',
                    textField:'nombre_completo',
                    panelHeight:'auto',
                    label: 'Personal:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $data_combo ?>;
                </select>
            <p>        
            <select id="mes" class="easyui-combobox" name="mes" style="width:300px;" data-options="
                    valueField:'codigo',
                    textField:'descripcion',
                    panelHeight:'auto',
                    label: 'Mes:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $mes ?>;
                </select>
            <p>
            <select id="anio" class="easyui-combobox" name="anio" style="width:300px;" data-options="
                    valueField:'codigo',
                    textField:'descripcion',
                    panelHeight:'auto',
                    label: 'Anio:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $anio ?>;
                </select>
            <p>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" style="height:25px" onclick="doSearch()">Buscar</a>   
			
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
        if($('#anio').val()=="")
            return;    
        if($('#mes').val()=="")
            return;               
        var periodo = '' + $('#anio').val() +$('#mes').val();
        var accionQuery = 'window.open( \'<?= base_url() ?>reportes/comprobanteBoletaInd/'+$('#cod_personal').val() + '/' + periodo + '/' + row.TIPO_PLANILLA+'\')';

        btnVer="";

        var btnQuery='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Consultar"    onclick="'+accionQuery+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-find">&nbsp;</span></span>';
        
        acc_reporte = '<?= $acc_reporte ?>';
        
        var menusRole = '';
        if(acc_reporte != '0') {
			menusRole += btnQuery;
		}
//		return btnEditar + btnEliminar + btnActivar;
        return menusRole;
    }  
  
    

</script>