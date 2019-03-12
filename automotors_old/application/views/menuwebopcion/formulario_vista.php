<?php echo form_open('menuwebopcion/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:500px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <?php  if(!isset($datos)) { 
                echo "<p>ID Menu: ". $idMenu."</p>";
            }else{  ?>
            <input class="easyui-textbox" label="Id Menu:" labelPosition="top" style="width:100%;height:52px"  name="menu" data-options="readonly:<?= isset($datos)?'true':'false'; ?>" value="<?php 
                if(isset($datos)){ echo  $datos["menu"];}
             ?>">
             <?php } ?>            

            <input class="easyui-textbox" label="Id Menu Web Opcion:" labelPosition="top" style="width:100%;height:52px"  name="menu_web_opcion" data-options="readonly:<?= isset($datos)?'true':'false'; ?>" value="<?php 
                if(isset($datos)){ echo  $datos["menu_web_opcion"];}
             ?>">

             <input class="easyui-textbox" label="Nombre de la opcion:" labelPosition="top" style="width:100%;height:52px"  name="nombre_opcion" value="<?php 
                if(isset($datos)){ echo $datos["nombre_opcion"];}
             ?>">
             <input class="easyui-textbox" label="Descripción:" labelPosition="top" style="width:100%;height:52px"  name="descripcion" value="<?php 
                if(isset($datos)){ echo $datos["descripcion"];}
             ?>">
        </div>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
    <input type="hidden" value=<?=  $id ?> name="id" >
    <input type="hidden" value=<?=  $idMenu ?> name="idMenu" >
    <input type="hidden" value=<?=  $operacion ?> name="operacion" >

    
</form>

<script>
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>menuwebopcion";
    }

</script>