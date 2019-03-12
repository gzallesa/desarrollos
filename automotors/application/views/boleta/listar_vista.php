<?php echo form_open('planillacmo',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
	<div class="easyui-panel" style="width:100%;max-width:100%;padding:40px 10px;">
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
        
            <?php if(isset($acc_reporte) && $acc_reporte == 'BO_R'):?>
	    		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-page_white_gear" style="height:25px" onclick="doGenerar()">Imprimir</a>
	    	<?php endif;?>
        </div>

	</div>

</form>

<script>

	function doGenerar(){
		//console.log('Entre a generar: ' + $('#mes').val() + ' - ' + $('#anio').val() + ' - ' + $('#cod_personal').val());
		if (($('#mes').val() != null) && ($('#anio').val() != null) && ($('#cod_personal').val() != null)) {
			//console.log('Pase al if');
			var cod_personal = $('#cod_personal').val();
			var gestion = "" + $('#anio').val() + $('#mes').val();
			//console.log('gestion: ' + gestion);
			window.open("<?= base_url() ?>reportes/comprobanteBoleta/" + cod_personal + "/" + gestion);	
		}
		
	}
	
    function submitForm() {
        $('#ff').form('submit');
    }

</script>