<?php echo form_open('planilladeposito',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
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
            <select id="seccion" class="easyui-combobox" name="seccion" style="width:300px;" data-options="
                    panelHeight:'auto',
                    label: 'Seccion:',
                    ">
                    <option value="" >Seleccionar...</option>
                    <option value="1" >Reporte Detallado</option>
                    <option value="2" >Reporte General</option>
            </select>
            <p>
            <?php if(isset($acc_generar) && $acc_generar == 'PD_G'):?>
	    		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-page_white_gear" style="height:25px" onclick="doGenerar('G')">Generar</a>
	    	<?php endif;?>
        </div>
    
    <?php if($seccion == '1') { ?>
	    <table id="tt" class="easyui-datagrid" width="100%"
	            title="Planillas Deposito Detallado" iconCls="icon-save"
	            rownumbers="true" pagination="false" showFooter="true" singleSelect="true" toolbar="#toolbar"
	            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
	        <thead>
	            <tr>
	            	<th field="gestion" width="80"><b>GESTION</b></th>
	                <th field="secuencia" align="right"><b>SECUENCIA</b></th>
	                <th field="tipo" align="right"><b>TIPO</b></th>
	                <th field="nombre" align="right"><b>NOMBRE</b></th>
	                <th field="cuenta" align="right"><b>CUENTA</b></th>
	                <th field="monto" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.monto,2);}"><b>MONTO</b></th>                
	            </tr>
	        </thead>
	    </table>
    <div id="toolbar">
    	<?php if(isset($acc_exportar) && $acc_exportar == 'PD_E'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-doc_excel_table" plain="true" onclick="toExcel()">Exportar a Excel</a>
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

	<?php } elseif($seccion == '2') {?>
	    <table id="tt" class="easyui-datagrid" width="100%"
	            title="Planillas Deposito General" iconCls="icon-save"
	            rownumbers="true" pagination="false" showFooter="true" singleSelect="true" toolbar="#toolbar"
	            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
	        <thead>
	            <tr>
	            	<th field="GESTION" width="80"><b>GESTION</b></th>
	                <th field="DIVISION_NEGOCIO" align="right"><b>DIVISION NEGOCIO</b></th>
	                <th field="CENTRO_GESTION" align="right"><b>CENTRO GESTION</b></th>
	                <th field="COD_PERSONAL" align="right"><b>COD PERSONAL</b></th>
	                <th field="NOMBRE_APELLIDO" align="right"><b>NOMBRE APELLIDO</b></th>
	                <th field="CARGO" align="right"><b>CARGO</b></th>
	                <th field="CUENTA" align="right"><b>CUENTA</b></th>
	                <th field="PFISCAL" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PFISCAL,2);}"><b>PFISCAL</b></th>
	                <th field="PREAL" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.PREAL,2);}"><b>PREAL</b></th>
	            </tr>
	        </thead>
	    </table>
    <div id="toolbar">
    	<?php if(isset($acc_exportar) && $acc_exportar == 'PD_E'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-doc_excel_table" plain="true" onclick="toExcel()">Exportar a Excel</a>
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

	<?php } ?>


</div>
<input type="hidden" name="elemento" id="elemento" >
<input type="hidden" name="operacion" id="operacion" value="G" >
</form>

<script>

    var data_grilla=<?= $data_grilla ?>;
    //console.log("grilla: " + JSON.stringify(data_grilla));

	$(document).ready(function() {
		$('#seccion').combobox('setValue', '<?php if(isset($seccion)){ echo $seccion;}else{ echo "";} ?>');
	});

	function toExcel(){
		var nom = ($('#seccion').val() == '1') ? 'Detalle' : 'General';
		$('#tt').datagrid('toExcel','PlanillaDeposito_<?= $periodo ?>_' + nom + '.xls');
	}


	function doGenerar(tipo){
		$('#operacion').val(tipo);
		submitForm();
	}
	
    function submitForm() {
        $('#ff').form('submit');
    }

</script>