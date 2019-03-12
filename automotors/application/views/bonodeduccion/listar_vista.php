<?php echo form_open('bonodeduccion',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
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
            title="Bonos - Deduccicon" iconCls="icon-save"
            rownumbers="true" pagination="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
            	<th field="cod_bono_deduccion" width="80"><b>CODIGO</b></th>
                <th field="desc_tipo_planilla" align="right"><b>PLANILLA</b></th>
                <th field="desc_tipo" align="right"><b>TIPO</b></th>
                <th field="desc_nivel" align="right"><b>NIVEL</b></th>
                <th field="descripcion" align="right"><b>DESCRIPCION</b></th>
                <th field="periodo_inicio" align="right"><b>PERIODO INICIO</b></th>
                <th field="periodo_final" align="right"><b>PERIODO FINAL</b></th>
                <th field="monto" align="right" data-options="formatter:function(value, row){ return accounting.formatNumber(row.monto,2);}"><b>MONTO</b></th>
                <th data-options="field:'ACCION'" formatter="BotonesAccion"><b>ACCION</b></th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
    	<?php if(isset($acc_registrar) && $acc_registrar == 'BD_I'):?>
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
        var accionQuery = 'window.location.href = \'<?= base_url() ?>bonodeduccion/consultar_form/'+row.cod_bono_deduccion+'\'';
        var accionEditar = 'window.location.href = \'<?= base_url() ?>bonodeduccion/actualizar_form/'+row.cod_bono_deduccion+'\'';
        var accionEliminar='eliminar(\''+row.cod_bono_deduccion+'\')';
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
            window.location.href = "<?= base_url() ?>bonodeduccion/eliminar/"+id;
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
       window.location.href = "<?= base_url() ?>bonodeduccion/insertar_form/" + codPersonal; 
    }
</script>