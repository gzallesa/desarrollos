<?php echo form_open('planilla',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:100%;padding:40px 10px;">
        <div style="margin-bottom:20px;text-align:center;">
            <select id="cc" class="easyui-combobox" name="tipo_planilla" style="width:350px;" data-options="
                    valueField:'codigo',
                    textField:'descripcion',
                    panelHeight:'auto',
                    label: 'Tipo Planilla:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $tipo_planilla ?>;
                </select>
                <br>
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
            <?php if(isset($acc_generar) && $acc_generar == 'PM_G'):?>
	    		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-page_white_gear" style="height:25px" onclick="doGenerar('G')">Generar</a>
	    	<?php endif;?>	
        </div>
    
    
    <table id="tt" class="easyui-datagrid" width="100%"
            title="Planillas Mensuales" iconCls="icon-save"
            rownumbers="true" pagination="false" showFooter="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
            	<th field="GESTION" width="80"><b>GESTION</b></th>
                <th field="TIPO_PLANILLA" width="100"><b>TIPO PLANILLA</b></th>
                <th field="DIVISION_NEGOCIO" align="right"><b>DIVISION NEGOCIO</b></th>
                <th field="CENTRO_GESTION" align="right"><b>CENTRO GESTION</b></th>
                <th field="MATRICULA" align="right"><b>MATRICULA</b></th>
                <th field="NUMERO_DOCUMENTO" align="right"><b>NUMERO DOCUMENTO</b></th>
                <th field="COD_PERSONAL" align="right"><b>COD_PERSONAL</b></th>
                <th field="NOMBRE_APELLIDO" align="right"><b>NOMBRE APELLIDO</b></th>
                <th field="CARGO" align="right"><b>CARGO</b></th>
                <th field="FECHA_INGRESO" align="right"><b>FECHA INGRESO</b></th>
                <th field="FECHA_SALIDA" align="right"><b>FECHA SALIDA</b></th>
                <th field="DIAS_TRABAJADOS" align="right"><b>DIAS TRABAJADOS</b></th>
                <th field="SUELDO_BASICO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.SUELDO_BASICO,2);}"><b>SUELDO BASICO</b></th>
                <th field="TOTAL_SUELDO_BASICO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.TOTAL_SUELDO_BASICO,2);}"><b>TOTAL SUELDO BASICO</b></th>
                <th field="BONO_ANTIGUEDAD" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.BONO_ANTIGUEDAD,2);}"><b>BONO ANTIGUEDAD</b></th>
                <th field="BONOS" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.BONOS,2);}"><b>BONOS</b></th>
                <th field="TOTAL_GANADO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.TOTAL_GANADO,2);}"><b>TOTAL GANADO</b></th>
                <th field="DESCUENTOS_PRESTAMO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.DESCUENTOS_PRESTAMO,2);}"><b>DESCUENTOS PRESTAMO</b></th>
                <th field="DESCUENTOS_ANTERIORRES" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.DESCUENTOS_ANTERIORRES,2);}"><b>DESCUENTOS ANTERIORES</b></th>
                <th field="DESCUENTOS_AFP" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.DESCUENTOS_AFP,2);}"><b>DESCUENTOS AFP</b></th>
                <th field="FONDO_SOLIDIARIO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.FONDO_SOLIDIARIO,2);}"><b>FONDO SOLIDIARIO</b></th>
                <th field="RCIVA" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.RCIVA,2);}"><b>RCIVA</b></th>
                <th field="TOTAL_DESCUENTOS" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.TOTAL_DESCUENTOS,2);}"><b>TOTAL_DESCUENTOS</b></th>
                <th field="LIQUIDO_PAGABLE" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.LIQUIDO_PAGABLE,2);}"><b>LIQUIDO_PAGABLE</b></th>
            </tr>
        </thead>
<!--        <tfoot>
        	<tr>
        		<td colspan="12" align="right"><b>TOTAL:</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        		<td align="right"><b>1234</b></td>
        	</tr>
        </tfoot>-->
    </table>

    <div id="toolbar">
    	<?php if(isset($acc_exportar) && $acc_exportar == 'PM_E'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-doc_excel_table" plain="true" onclick="toExcel()">Exportar a Excel</a>
        <?php endif;?>
        <?php if(isset($acc_asiento) && $acc_asiento == 'PM_A'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-book_open" plain="true" onclick="doGenerar('A')">Asiento Contable</a>
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
<input type="hidden" name="operacion" id="operacion" value="G" >
</form>

<script>

    var data_grilla=<?= $data_grilla ?>;
    //console.log("grilla: " + JSON.stringify(data_grilla));

	function toExcel(){
		$('#tt').datagrid('toExcel','Planilla_<?= $periodo ?>.xls');
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