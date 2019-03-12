<?php echo form_open('dominio',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:1000px;padding:30px 60px;">
        <div style="margin-bottom:20px;text-align:center;">
            <select id="cc" class="easyui-combobox" name="dominio" style="width:300px;" data-options="
                    valueField:'dominio',
                    textField:'dominio',
                    panelHeight:'auto',
                    label: 'Dominio:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $data_combo ?>;
                </select>
	    	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" style="height:25px" onclick="doSearch()">Buscar</a>
	    	<?php if(isset($acc_registrarC) && $acc_registrarC == 'DO_IC'):?>
	    		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" style="height:25px" onclick="nuevo_registro('C')">Nuevo Dominio</a>
	    	<?php endif;?>
        </div>
    
    <table id="tt" class="easyui-datagrid" width="100%"
            title="Detalle Dominio" iconCls="icon-save"
            rownumbers="true" pagination="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
            	<th field="CODIGO" width="80"><b>CODIGO</b></th>
                <th field="DOMINIO" width="150"><b>DOMINIO</b></th>
                <th field="DESCRIPCION" align="right"><b>DESCRIPCION</b></th>
                <th field="FECHA_INACTIVACION"  align="right"><b>FECHA INACTIVACION</b></th>
                <th data-options="field:'ACCION'" formatter="BotonesAccion"><b>ACCION</b></th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
    	<?php if(isset($acc_registrarD) && $acc_registrarD == 'DO_ID'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo_registro('D')">Nuevo Registro</a>
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
        var accionEditar = 'window.location.href = \'<?= base_url() ?>dominio/actualizar_form/'+row.DOMINIO+'/' + row.CODIGO+'\'';
        //var accionEditar = 'editar(\''+row.DOMINIO+'\',\''+row.CODIGO+'\')';
        var accionEliminar = 'eliminar(\''+row.DOMINIO+'\',\''+row.CODIGO+'\')';
        var accionActivar = 'activar(\''+row.DOMINIO+'\',\''+row.CODIGO+'\')';

        //var btnVer='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+ accionVer +'"><span class="l-btn-text"></span><span class="l-btn-icon icono-magnifier">&nbsp;</span></span>';
        btnVer="";
        var btnEditar='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Editar"    onclick="'+accionEditar+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-pencil">&nbsp;</span></span>';
        var btnEliminar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" title="Eliminar"  onclick="'+accionEliminar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-remove">&nbsp;</span></span>';
        var btnActivar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"  title="Activar"   onclick="'+accionActivar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-ok">&nbsp;</span></span>';
        
        acc_editar = '<?= $acc_editar ?>';
        acc_eliminar = '<?= $acc_eliminar ?>';
        acc_activar = '<?= $acc_activar ?>';
        var menusRole = '';
        if(acc_editar != '0') {
			menusRole += btnEditar;
		}
		if(acc_eliminar != '0') {
			menusRole += btnEliminar;
		}
		if(acc_activar != '0') {
			menusRole += btnActivar;
		}
//		return btnEditar + btnEliminar + btnActivar;
        return menusRole;
    }  

    /*function editar(dominio,codigo) {
		var url = "<?= base_url() ?>dominio/Actualizar_form";
		//console.log('Estoy en doConfirmar: ' + tipo + ' '+ id + ' ' + observacion + ' ' + url);
	    event.preventDefault();
	    $.ajax({
	            type:"post",
	            url: url,
	            data:{ dominio: dominio, codigo: codigo},
	            success:function(response)
	            {
					window.location.href = "<?= base_url() ?>dominio/Actualizar_form";
	            }
	        });
    }*/
    
    function eliminar(dominio,codigo) {
        var r = confirm("Desea eliminar el registro\nId: "+dominio+"\nCodigo: "+codigo);
        if (r == true) {
			var url = "<?= base_url() ?>dominio/eliminar";
			//console.log('Estoy en doConfirmar: ' + tipo + ' '+ id + ' ' + observacion + ' ' + url);
	        event.preventDefault();
	        $.ajax({
	                type:"post",
	                url: url,
	                data:{ dominio: dominio, codigo: codigo},
	                success:function(response)
	                {
						window.location.href = "<?= base_url() ?>dominio";
	                }
	            });
        } 
    }
    
    function activar(dominio,codigo) {
        var r = confirm("Desea activar el registro\nId: "+dominio+"\nCodigo: "+codigo);
        if (r == true) {
			var url = "<?= base_url() ?>dominio/activar";
			//console.log('Estoy en doConfirmar: ' + tipo + ' '+ id + ' ' + observacion + ' ' + url);
	        event.preventDefault();
	        $.ajax({
	                type:"post",
	                url: url,
	                data:{ dominio: dominio, codigo: codigo},
	                success:function(response)
	                {
						window.location.href = "<?= base_url() ?>dominio";
	                }
	            });
        } 
    }
    
    function nuevo_registro(tipo) {
      var codDominio;
      //console.log('valor seleccionado: ' + $('#cc').val());
      if ($('#cc').val() != '') {
	  	codDominio = $('#cc').val();
	  }
	  /*if (tipo == 'C'){
	  	 codDominio = '';
	  }*/
	  //console.log('Dominio: ' + codDominio + '  tipo: ' + tipo);
	  if (codDominio == null) {
	  	window.location.href = "<?= base_url() ?>dominio/insertar_form/" + tipo ; 
	  }else{
	  	window.location.href = "<?= base_url() ?>dominio/insertar_form/" + tipo + "/" + codDominio ; 
	  }
      
    }
</script>