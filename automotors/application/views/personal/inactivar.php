<?php echo form_open('personal/eliminar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <?php echo "<p>Cod Personal: ". $cod_personal ."</p>";?>
	        <div style="margin-bottom:10px">
	            <input class="easyui-datebox" style="width:100%;height:24px"  name="fecha_salida" id="fecha_salida" data-options="prompt: 'Ingresar fecha salida'" value=""  required="required">
	        </div>      

        </div>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
    <input type="hidden" value=<?=  $cod_personal ?> name="cod_personal" >

    
</form>

<script>
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>personal";
    }

</script>