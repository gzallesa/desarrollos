<script type="text/javascript">
    var datos=<?= $json; ?>;

    function BotonesAccion(value,row){
        if(row.menu_padre=="")
            return;

        var accionVer = 'window.location.href = \'<?= base_url() ?>rol/detalle_form/'+row.menu+'\'';
        var accionEditar = 'window.location.href = \'<?= base_url() ?>menumobile/editar_menu_mobile/'+row.menu+'\'';
        var accionEliminar='eliminar(\''+row.menu+'\',\''+row.nombre_menu+'\')';
        var accionActivar='activar(\''+row.menu+'\',\''+row.nombre_menu+'\')';

        var btnVer='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+ accionVer +'"><span class="l-btn-text"></span><span class="l-btn-icon icono-magnifier">&nbsp;</span></span>';
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
//        return btnVer + btnEditar + btnEliminar + btnActivar;
    }    
</script>

<!-- mensaje de exito -->
<?php if(isset($mensaje)):
        if($mensaje["@estado"]=="0"){
 ?>
    <div  class="report-div success" style="display: block;"><p><?= $mensaje["@error"]  ?> </p></div>
<?php } else{ ?>
    <div class="report-div error" style="display: block;"><p><?= $mensaje["@error"]  ?> </div>
<?php } endif ?>
<!--/ mensaje de exito -->

    <div id="tb">
    <?php if(isset($acc_registrar) && $acc_registrar == 'MM_I'):?>
    	<a href="<?= base_url() ?>menumobile/agregar_menu_mobile" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true">Nuevo Menu</a>
    <?php endif;?>
    </div>
<table class="easyui-datagrid" title="Lista de menus" 
            data-options="
                singleSelect:true,
                fitColumns:true,
                data:datos,
                toolbar:tb,
                onBeforeSelect:function(){return false;},
                striped:true
            ">
        <thead>
            <tr>
                <th data-options="field:'menu'">Menu</th>
                <th data-options="field:'menu_padre'">Menu padre</th>
                <th data-options="field:'nombre_menu'">Nombre de menu</th>
                <th data-options="field:'descripcion',align:'left'">Descripción</th>
                <th data-options="field:'estado',align:'left'">Estado</th>
                <th data-options="field:'desc_estado'">Desc. estado</th>
                <th data-options="field:'fecha_creacion',align:'center'">Fecha de creacíon</th>
                <th data-options="field:'ACCION'" formatter="BotonesAccion">Accion</th>
            </tr>
        </thead>
    </table>
<script type="text/javascript">
    $('#dg').datagrid({
        toolbar: '#tb'
    });
    function eliminar(id,nombre)
    {
        var r = confirm("Desea eliminar el registro\nId: "+id+"\nNombre: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>menumobile/eliminar_menu_mobile/"+id;
        } 
    }
    
    function activar(id,nombre)
    {
        var r = confirm("Desea activar el registro\nId: "+id+"\nNombre: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>menumobile/activar_menu_mobile/"+id;
        } 
    }
</script>