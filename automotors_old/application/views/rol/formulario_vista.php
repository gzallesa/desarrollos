<?php echo form_open('rol/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:500px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <input class="easyui-textbox" label="Rol:" labelPosition="top" style="width:100%;height:52px"  name="rol" data-options="disabled:<?= isset($datos)?'true':'false'; ?>" value="<?php 
                if(isset($datos)){ echo  $datos["rol"];}
             ?>">
             <input class="easyui-textbox" label="Nombre del Rol:" labelPosition="top" style="width:100%;height:52px"  name="nombre_rol" value="<?php 
                if(isset($datos)){ echo $datos["nombre_rol"];}
             ?>">
        </div>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
    <input type="hidden" value=<?=  $id ?> name="id" >
    <input type="hidden" value=<?=  $operacion ?> name="operacion" >

    
</form>

<script>
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>rol";
    }

</script>