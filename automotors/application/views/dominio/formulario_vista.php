<?php echo form_open('dominio/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
			<input class="easyui-textbox" label="Dominio:" labelPosition="top" style="width:100%;height:52px"  name="dominio" data-options="prompt:'Ingrese dominio',required:true, readonly:<?= isset($dominio)?'true':'false'; ?>" value="<?php 
                if(isset($dominio)){ echo  $dominio;}
             ?>">
             <input class="easyui-textbox" label="Codigo:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese codigo',required:true, readonly:<?= isset($datos)?'true':'false'; ?>" name="codigo" value="<?php 
                if(isset($datos)){ echo $datos["CODIGO"];}
             ?>">
             
             <input class="easyui-textbox" label="Descripcion:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese descripcion'" name="descripcion" value="<?php 
                if(isset($datos)){ echo $datos["DESCRIPCION"];}
             ?>">
			 
        </div>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
<!--    <input type="hidden" value=<?=  $dominio ?> name="dominio" >-->
    <input type="hidden" value=<?=  $operacion ?> name="operacion">

    
</form>

<script>
	
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>dominio";
    }

</script>