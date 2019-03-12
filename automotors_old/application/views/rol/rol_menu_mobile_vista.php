<?php echo form_open('rol/rol_menu_mobile',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
<div class="easyui-panel" style="width:100%;max-width:700px;padding:30px 60px;">
        <div style="margin-bottom:20px;text-align:center;">
            <select id="cc" class="easyui-combobox" name="idRol" style="width:300px;" data-options="
                    
                    valueField:'rol',
                    textField:'nombre_rol',
                    panelHeight:'auto',
                    label: 'Rol:',
                    ">
                    <option value="" >Seleccionar...</option>
                     <?= $datosRolesTotal ?>; 
                </select>
        </div>
    

<!-- grupos de asignacion -->
    <div class="easyui-panel" title="Asignar Menus Mobile" style="width:600px;height:300px;" data-options="border:false">
            <div class="easyui-layout" data-options="fit:true">
                <div data-options="region:'west'" style="width:250px">
                    <ul class="easyui-datalist" title="Menus mobile disponibles" lines="true" style="width:245px;height:260px" id="listaAsignar" >
        <?= $datosMenuMobileAAsignar;  ?>
        </ul>
                </div>
                <div data-options="region:'east'" style="width:250px">
                    <ul id="listaAsignados"  class="easyui-datalist" title="Menus mobile asignados" lines="true" style="width:240px;height:260px"  >
        <?= $datosMenuMobileAsignados;  ?>
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

     $('#cc').combobox({
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