<?php echo form_open('menuwebopcion/rmw_opcion',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:700px;padding:30px 60px;">
        <div style="margin-bottom:20px;text-align:center;">
			<select id="cc" class="easyui-combogrid" name="idRolMenuWeb" style="width:80%" data-options="
                    panelWidth: 500,
                    idField: 'llave',
                    textField: 'rol_menu_web',
                    value: '<?= $valueSelected ?>',
                    url: '<?= base_url() ?>menuWebOpcion/cargarCombo',
                    columns: [[
                        {field:'llave',title:'Llave',width:80, visible:false},
                        {field:'nombre_rol',title:'Rol',width:120},
                        {field:'nombre_menu',title:'Menu',width:80}
                    ]],
                    fitColumns: true,
                    label: 'Rol Menu Web:',
                    labelWidth: '100px'
                ">
            </select>
        </div>
<!-- grupos de asignacion -->
    <div class="easyui-panel" title="Asignar Opciones" style="width:600px;height:300px;" data-options="border:false">
            <div class="easyui-layout" data-options="fit:true">
                <div data-options="region:'west'" style="width:250px">
                    <ul class="easyui-datalist" title="Opciones disponibles" lines="true" style="width:245px;height:260px" id="listaAsignar" >
        <?= $datosOpcionesAAsignar;  ?>
        </ul>
                </div>
                <div data-options="region:'east'" style="width:250px">
                    <ul id="listaAsignados"  class="easyui-datalist" title="Opciones asignadas" lines="true" style="width:240px;height:260px"  >
        <?= $datosOpcionesAsignados;  ?>
                </div>
                <div data-options="region:'center'" style="width:100px">
                <a id="btn" href="#" class="easyui-linkbutton" data-options="iconCls:'icono-arrow_right',iconAlign:'right'" style="padding:8px;margin:5px;width:90px" onclick="Asignar();">Asignar</a>
                <a id="btn" href="#" class="easyui-linkbutton" data-options="iconCls:'icono-arrow_left'" style="padding:8px;margin:5px;width:90px" onclick="Quitar();">Quitar</a>

                    
                </div>
            </div>
        </div>

    <div>
    </div>
    <!--/ grupos de asignacion -->
</div>
<input type="hidden" name="operacion" id="operacion" >
<input type="hidden" name="elemento" id="elemento" >
</form>

<script>

     $('#cc').combogrid({
        onChange: function(seleccion,anterior){
            submitForm();
        }
    });

    function submitForm(){
        $('#ff').form('submit');
    }
    function Asignar()
    {
        try{
            $("#elemento").val($('#listaAsignar').datalist('getSelected').value);
            $("#operacion").val('I');
            submitForm();
        }catch(err){};
    }
    function Quitar()
    {
        try{
            $("#elemento").val($('#listaAsignados').datalist('getSelected').value);
            $("#operacion").val('D');
            submitForm();
        }catch(err){};
    }
</script>