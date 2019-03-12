<?php echo form_open('planillacmo',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:100%;padding:40px 10px;">
        <div style="margin-bottom:20px;text-align:center;">

            <select id="mes" class="easyui-combobox" name="mes" style="width:300px;" data-options="
                    valueField:'codigo',
                    textField:'descripcion',
                    panelHeight:'auto',
                    label: 'Mes:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $mes ?>;
                </select>
                <br>
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
            <?php if(isset($acc_generar) && $acc_generar == 'PC_G'):?>
	    		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-page_white_gear" style="height:25px" onclick="doGenerar('G')">Generar</a>
	    	<?php endif;?>
        </div>
    
    
    <table id="tt" class="easyui-datagrid" width="100%"
            title="Planillas CMO" iconCls="icon-save"
            rownumbers="true" pagination="false" showFooter="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
            	<th field="GESTION" width="80"><b>GESTION</b></th>
                <th field="DIVISION_NEGOCIO" align="right"><b>DIVISION NEGOCIO</b></th>
                <th field="CENTRO_GESTION" align="right"><b>CENTRO GESTION</b></th>
                <th field="COD_PERSONAL" align="right"><b>COD_PERSONAL</b></th>
                <th field="NOMBRE_APELLIDO" align="right"><b>NOMBRE APELLIDO</b></th>
                <th field="CARGO" align="right"><b>CARGO</b></th>
                <th field="PLANILLA_CAJA_AFP" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PLANILLA_CAJA_AFP,2);}"><b>PLANILLA CAJA AFP</b></th>
                <th field="PLANILLA_SOLO_AFP" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PLANILLA_SOLO_AFP,2);}"><b>PLANILLA SOLO AFP</b></th>
                <th field="PLANILLA_SIN_DESCUENTOS" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PLANILLA_SIN_DESCUENTOS,2);}"><b>PLANILLA SIN DESCUENTOS</b></th>
                <th field="TOTAL_GANADO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.TOTAL_GANADO,2);}"><b>TOTAL GANADO</b></th>
                <th field="OTROS_BONOS_LABORALES" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.OTROS_BONOS_LABORALES,2);}"><b>OTROS BONOS LABORALES</b></th>
                <th field="APORTE_AFP_PATRONAL" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.APORTE_AFP_PATRONAL,2);}"><b>APORTE AFP PATRONAL</b></th>
                <th field="APORTE_CAJA" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.APORTE_CAJA,2);}"><b>APORTE CAJA</b></th>
                <!--<th field="PREVISION_INDEMINIZACION" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PREVISION_INDEMINIZACION,2);}"><b>PREVISION INDEMINIZACION</b></th>
                <th field="PREVISION_AGUINALDO_1" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PREVISION_AGUINALDO_1,2);}"><b>PREVISION AGUINALDO</b></th>
                <th field="PREVISION_AGUINALDO_2" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PREVISION_AGUINALDO_2,2);}"><b>PREVISION AGUINALDO 2</b></th>
                <th field="CMO_UN_AGUINALDO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.CMO_UN_AGUINALDO,2);}"><b>CMO UN AGUINALDO</b></th>
                <th field="CMO_DOS_AGUINALDOS" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.CMO_DOS_AGUINALDOS,2);}"><b>CMO DOS AGUINALDOS</b></th>-->
                <th field="MONTO_VARIABLE" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.MONTO_VARIABLE,2);}"><b>MONTO VARIABLE</b></th>
                <th field="MONTO_COMISION" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.MONTO_COMISION,2);}"><b>MONTO COMISION</b></th>
                <th field="PREVISION_INDEMINIZACION_VARIABLE_COMISION" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PREVISION_INDEMINIZACION_VARIABLE_COMISION,2);}"><b>PREVISION INDEMINIZACION VARIABLE COMISION</b></th>
                <th field="PREVISION_AGUINALDO_VARIABLE_COMISION_1" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PREVISION_AGUINALDO_VARIABLE_COMISION_1,2);}"><b>PREVISION AGUINALDO VARIABLE COMISION 1</b></th>
                <th field="PREVISION_AGUINALDO_VARIABLE_COMISION_2" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PREVISION_AGUINALDO_VARIABLE_COMISION_2,2);}"><b>PREVISION AGUINALDO VARIABLE COMISION 2</b></th>
                <th field="CMO_VARIABLE_COMISION_UN_AGUINALDO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.CMO_VARIABLE_COMISION_UN_AGUINALDO,2);}"><b>CMO VARIABLE COMISION UN AGUINALDO</b></th>
                <th field="CMO_VARIABLE_COMISION_DOS_AGUINALDOS" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.CMO_VARIABLE_COMISION_DOS_AGUINALDOS,2);}"><b>CMO VARIABLE COMISION DOS AGUINALDOS</b></th>
                

            </tr>
        </thead>
    </table>

    <div id="toolbar">
    	<?php if(isset($acc_exportar) && $acc_exportar == 'PC_E'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-doc_excel_table" plain="true" onclick="toExcel()">Exportar a Excel</a>
        <?php endif;?>
<!--        <div style="float:right;">
			<input class="easyui-searchbox" id="busc" name="busc" data-options="
			  prompt:'Ingrese texto a buscar', 
			  label: 'Buscar: ',
			  searcher:doBuscar" style="width:300px;"></input>
		</div>-->
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
<input type="hidden" name="operacion" id="operacion" value="G" >
</form>

<script>

    var data_grilla=<?= $data_grilla ?>;
    //console.log("grilla: " + JSON.stringify(data_grilla));
    
/*    function doBuscar(value){
    	console.log('entre: ' + value);
        $('#tt').datagrid('load',{
            COD_PERSONAL: value
        });
        //$('#tt').datagrid('reload');
    }*/
       
	function toExcel(){
		$('#tt').datagrid('toExcel','PlanillaCMO_<?= $periodo ?>.xls');
	}


	function doGenerar(tipo){
		$('#operacion').val(tipo);
		submitForm();
	}
	
    function submitForm() {
        $('#ff').form('submit');
    }

	$(document).ready(function() {
		var dg = $('#tt');
		dg.datagrid('enableFilter');    // enable filter
	});

</script>