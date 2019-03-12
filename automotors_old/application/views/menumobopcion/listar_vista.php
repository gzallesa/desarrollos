<?php echo form_open('menumobopcion',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:1000px;padding:30px 60px;">
        <div style="margin-bottom:20px;text-align:center;">
            <select id="cc" class="easyui-combobox" name="idSeleccionCombo" style="width:300px;" data-options="
                    
                    valueField:'menu',
                    textField:'nombre_menu',
                    panelHeight:'auto',
                    label: 'Menu mobile:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $data_combo ?>; 
                </select>
        </div>
    
    <table id="tt" class="easyui-datagrid"  
            title="Opciones asignadas" iconCls="icon-save"
            rownumbers="true" pagination="true" singleSelect="true" toolbar="#toolbar"
            data-options="onBeforeSelect:function(){return false;},data:data_grilla" >
        <thead>
            <tr>
                <th field="menu_mob_opcion" width="80">ID menu mobile opcion</th>
                <th field="menu" >Menu</th>
                <th field="nombre_opcion"  align="right">Nombre de opcion</th>
                <th field="descripcion" align="right">Descripción</th>
                <th field="estado" align="right">Estado</th>
                <th field="desc_estado" align="right">Desc. estado</th>
                <th field="fecha_creacion" align="right">Fecha de creacion</th>
                <th data-options="field:'ACCION'" formatter="BotonesAccion">Accion</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
    	<?php if(isset($acc_registrar) && $acc_registrar == 'MMO_I'):?>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo_registro()">Nuevo Registro</a>
        <?php endif;?>
    </div>

</div>
<input type="hidden" name="elemento" id="elemento" >
</form>

<script>
    data_grilla=<?= $data_grilla ?>;
     $('#cc').combobox({
        onChange: function(seleccion,anterior){
            submitForm();
        }
    });

    function submitForm(){
        $('#ff').form('submit');
    }

    function BotonesAccion(value,row){
        if(row.menu_padre=="")
            return;

        //var accionVer = 'window.location.href = \'<?= base_url() ?>menumobopcion/detalle_form/'+row.menu_mob_opcion+'\'';
        var accionEditar = 'window.location.href = \'<?= base_url() ?>menumobopcion/actualizar_form/'+row.menu+ '/'+ row.menu_mob_opcion+'\'';
        var accionEliminar='eliminar(\''+row.menu_mob_opcion+'\',\''+row.nombre_opcion+'\')';
        var accionActivar='activar(\''+row.menu_web_opcion+'\',\''+row.nombre_opcion+'\')';

        //var btnVer='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+ accionVer +'"><span class="l-btn-text"></span><span class="l-btn-icon icono-magnifier">&nbsp;</span></span>';
        btnVer="";
        var btnEditar='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+accionEditar+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-pencil">&nbsp;</span></span>';
        var btnEliminar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+accionEliminar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-remove">&nbsp;</span></span>';
        var btnActivar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+accionActivar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-ok">&nbsp;</span></span>';
        
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
        
        return menusRole;
         
    }  
    function eliminar(id,nombre) {
        var r = confirm("Desea eliminar el registro\nId: "+id+"\nNombre: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>menumobopcion/eliminar/"+id;
        } 
    }
    
    function activar(id, nombre) {
        var r = confirm("Desea activar el registro\nId: " + id + "\nNombre: " + nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>menumobopcion/activar/"+id;
        } 
    }

    function nuevo_registro() {
       window.location.href = "<?= base_url() ?>menumobopcion/insertar_form/"+ $('#cc').val(); 
    }
</script>