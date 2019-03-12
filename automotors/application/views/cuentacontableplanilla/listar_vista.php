<?php echo form_open('cuentacontableplanilla',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:100%;padding:40px 10px;">
        <div style="margin-bottom:20px; text-align:center;">

            <select id="mes" class="easyui-combobox" name="mes" style="width:300px;" data-options="
                    valueField:'codigo',
                    textField:'descripcion',
                    panelHeight:'auto',
                    label: 'Mes:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $mes ?>
                </select>
                <br>
            <select id="anio" class="easyui-combobox" name="anio" style="width:300px;" data-options="
                    valueField:'codigo',
                    textField:'descripcion',
                    panelHeight:'auto',
                    label: 'Anio:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $anio ?>
                </select>
            <p>
	    	
	    	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" style="height:25px" onclick="submitForm()">Buscar</a>

        </div>
    
    <table id="tt" class="easyui-datagrid" width="70%"
            title="Cuenta Contable Planilla" iconCls="icon-save"
            rownumbers="true" pagination="false" showFooter="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla, fitColumns:true" >
        <thead>
            <tr>
            	<th field="gestion" ><b>GESTION</b></th>
                <th field="tipo_planilla" align="right"><b>TIPO PLANILLA</b></th>
                <th field="desc_tipo_planilla" align="right"><b>DESC TIPO PLANILLA</b></th>
                <th field="monto" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.monto,2);}"><b>MONTO</b></th>                
                <th data-options="field:'ACCION'" formatter="BotonesAccion"><b>ACCION</b></th>
            </tr>
        </thead>
    </table>

	<p>
	
    <table id="tt_det" class="easyui-datagrid" width="80%"
            title="Detalle" iconCls="icon-save"
            rownumbers="true" pagination="false" showFooter="true" singleSelect="true" toolbar="#toolbar_det"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla_det, fitColumns:true" >
        <thead>
            <tr>
            	<th field="VACIO" ><b>VACIO</b></th>
                <th field="EMPRESA" align="right"><b>EMPRESA</b></th>
                <th field="FECHA" align="right"><b>FECHA</b></th>
                <th field="CUENTA_CONTABLE" align="right" ><b>CUENTA CONTABLE</b></th>
                <th field="CUENTA_PERSONAL" align="right" ><b>CUENTA PERSONAL</b></th>
                <th field="DIARIO" align="right" ><b>DIARIO</b></th>
                <th field="DEBITO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.DEBITO,2);}"><b>DEBITO</b></th>
                <th field="CREDITO" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.CREDITO,2);}"><b>CREDITO</b></th>
                <th field="DESCRIPCION" align="right" ><b>DESCRIPCION</b></th>
                <th field="MONEDA" align="right" ><b>MONEDA</b></th>
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
    
    <div id="toolbar_det">
    	<?php if(isset($acc_exportar) && $acc_exportar == 'CC_E'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-doc_excel_table" plain="true" onclick="toExcel()">Exportar a Excel</a>
        <?php endif;?>
    	<?php if(isset($acc_exportar_txt) && $acc_exportar_txt == 'CC_T'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-doc_text_image" plain="true" onclick="toTxt()">Exportar a Texto</a>
        <?php endif;?>
    </div>


</div>
<input type="hidden" name="gestion" id="gestion" value="<?= $gestion ?>" >
<input type="hidden" name="planilla" id="planilla" value="<?= $planilla ?>" >

</form>

<script>

    var data_grilla=<?= $data_grilla ?>;
    var data_grilla_det=<?= $data_grilla_det ?>;
    //console.log("grilla: " + JSON.stringify(data_grilla));

	function toExcel(){		
		$('#tt_det').datagrid('toExcel','CtaContablePlanilla_' + $('#gestion').val() + '_' + $('#planilla').val() + '.xls');
	}

	function toTxt(){
		window.location.href = "<?= base_url() ?>cuentacontableplanilla/exportar/" + $('#gestion').val() + "/" + $('#planilla').val();
	}

	function BotonesAccion(value,row) {
        if(row.menu_padre=="")
            return;

        var accionDetalle = 'generarDetalle('+ "'" + row.tipo_planilla + "'" + ','+ "'" + row.gestion + "'" + ')';
        console.log('detalle: ' + accionDetalle);
    
        btnVer="";
        var btnDetalle='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Consultar"    onclick="'+accionDetalle+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-find">&nbsp;</span></span>';
        
        acc_detalle = '<?= $acc_detalle ?>';
        
        var menusRole = '';
        if(acc_detalle != '0') {
			menusRole += btnDetalle;
		}
//		return btnEditar + btnEliminar + btnActivar;
        return menusRole;
    }  
	
	function generarDetalle(planilla, gestion){
		$('#planilla').val(planilla);
		$('#gestion').val(gestion);
		$('#ff').form('submit');
	}
	
    function submitForm() {
    	$('#planilla').val('');
		$('#gestion').val('');
        $('#ff').form('submit');
    }

</script>