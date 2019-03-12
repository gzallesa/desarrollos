<?php echo form_open('comprobanteegreso',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:100%;padding:10px 10px;">
   
    <table id="tt" class="easyui-datagrid" width="100%"
            title="Comprobante Egresos" iconCls="icon-save"
            rownumbers="true" pagination="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
            	<th field="NUMERO_COMPROBANTE" widthU><b>NRO COMPROBANTE</b></th>
                <th field="ORDEN_DE" width="100"><b>ORDEN_DE</b></th>
                <th field="NIT_CI" align="right"><b>NIT/CI</b></th>
                <th field="CONCEPTO" align="right"><b>CONCEPTO</b></th>
                <th field="DESCRIPCION_BANCO" align="right"><b>BANCO</b></th>
                <th field="MONTO_PAGAR" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.MONTO_PAGAR,2);}"><b>MONTO</b></th>
                <th field="FECHA_REGISTRO" align="right"><b>FECHA REGISTRO</b></th>
                <th data-options="field:'ACCION'" formatter="BotonesAccion"><b>ACCION</b></th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
    	<?php if(isset($acc_registrar) && $acc_registrar == 'CE_I'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo_registro()">Nuevo Registro</a>
        <?php endif;?>

    	<?php if(isset($acc_excel) && $acc_excel == 'CE_E'):?>
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

</div>

</form>

<script>
    data_grilla=<?= $data_grilla ?>;

	function toExcel(){
		$('#tt').datagrid('toExcel','ComprobanteEgreso.xls');
	}

	function doSearch(){
		submitForm();
	}
	
    function submitForm() {
        $('#ff').form('submit');
    }

    function BotonesAccion(value,row) {
        if(row.menu_padre=="")
            return;

        var accionEditar = 'window.location.href = \'<?= base_url() ?>comprobanteegreso/actualizar_form/'+row.NUMERO_COMPROBANTE+'\'';
        var accionQuery = 'window.location.href = \'<?= base_url() ?>comprobanteegreso/consultar_form/'+row.NUMERO_COMPROBANTE+'\'';
        var accionEliminar='eliminar(\''+row.NUMERO_COMPROBANTE+'\',\''+row.ORDEN_DE+'\')';
        var accionImprimir = 'window.open(\'<?= base_url() ?>reportes/comprobanteCheque/' + row.NUMERO_COMPROBANTE + '\'' + ')';

        btnVer="";
        var btnEditar='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Editar"    onclick="'+accionEditar+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-pencil">&nbsp;</span></span>';
        var btnEliminar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" title="Eliminar"  onclick="'+accionEliminar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-remove">&nbsp;</span></span>';
        var btnImprimir=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"  title="Imprimir"   onclick="'+accionImprimir+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-doc_pdf">&nbsp;</span></span>';
        var btnQuery='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Consultar"    onclick="'+accionQuery+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-find">&nbsp;</span></span>';
        
        acc_editar = '<?= $acc_editar ?>';
        acc_eliminar = '<?= $acc_eliminar ?>';
        acc_imprimir = '<?= $acc_imprimir ?>';
        acc_consultar = '<?= $acc_consultar ?>';
        
        
        var menusRole = '';
        if(acc_editar != '0') {
			menusRole += btnEditar;
		}
		if(acc_eliminar != '0') {
			menusRole += btnEliminar;
		}	
		if(acc_imprimir != '0') {
			menusRole += btnImprimir;
		}
        if(acc_consultar != '0') {
			menusRole += btnQuery;
		}		

        return menusRole;
    }  
    
    function eliminar(id,nombre) {
        var r = confirm("Desea eliminar el registro\nId: "+id+"\nNombre: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>comprobanteegreso/eliminar/"+id;
        } 
    }
    
    function nuevo_registro() {
       window.location.href = "<?= base_url() ?>comprobanteegreso/insertar_form/";
    }


</script>