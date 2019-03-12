<?php echo form_open('personalequipo',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:1000px;padding:30px 60px;">
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
            title="Personal Equipo" iconCls="icon-save"
            rownumbers="true" pagination="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
            	<th field="cod_personal_equipo" width="80"><b>CODIGO</b></th>
                <th field="desc_tipo_equipo" width="100"><b>TIPO EQUIPO</b></th>
                <th field="desc_marca" align="right"><b>MARCA</b></th>
                <th field="desc_equipo" align="right"><b>EQUIPO</b></th>
                <th field="serie_equipo" align="right"><b>SERIE</b></th>
                <th field="nombre_equipo" align="right"><b>NOMBRE EQUIPO</b></th>
                <th field="descripcion" align="right"><b>DESCRIPCION</b></th>
                <th field="fecha_creacion" align="right"><b>FECHA CREACION</b></th>
                <th data-options="field:'ACCION'" formatter="BotonesAccion"><b>ACCION</b></th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
    	<?php if(isset($acc_registrar) && $acc_registrar == 'PE_I'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="nuevo_registro()">Asignar/Desasignar</a>
        <?php endif;?>
    	<?php if(isset($acc_reporte) && $acc_reporte == 'PE_R'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-page_white_gear" plain="true" onclick="generar_formulario()">Generar Formulario</a>
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
    
    function generar_formulario(){
    	cod_personal = $('#cc').val();
    	if (cod_personal != '') {
			window.open("<?= base_url() ?>reportes/comprobanteAsignacion/" + cod_personal);	
		}
	}

    function BotonesAccion(value,row) {
        if(row.menu_padre=="")
            return;

        var accionQuery = 'window.location.href = \'<?= base_url() ?>personalequipo/query_form/'+row.cod_personal_equipo+'\'';

        btnVer="";
        var btnQuery='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;"    title="Consultar"    onclick="'+accionQuery+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-find">&nbsp;</span></span>';
        
        acc_consultar = '<?= $acc_consultar ?>';
        var menusRole = '';
        if(acc_consultar != '0') {
			menusRole += btnQuery;
		}

        return menusRole;
    }  
    
    function eliminar(id,nombre) {
        var r = confirm("Desea eliminar el registro\nId: "+id+"\nIP: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>ip/eliminar/"+id;
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
       window.location.href = "<?= base_url() ?>personalequipo/asignar_form/" + codPersonal; 
    }
</script>