<?php echo form_open('ip/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <?php  if(!isset($datos)) { 
                echo "<p>Cod Personal: ". $cod_personal ."</p>";
            }else{  ?>
            <input class="easyui-textbox" label="Cod IP:" labelPosition="top" style="width:100%;height:52px"  name="cod_ip" data-options="readonly:<?= isset($datos)?'true':'false'; ?>" value="<?php 
                if(isset($datos)){ echo  $datos["COD_IP"];}
             ?>">
             <?php } ?>            

             <input class="easyui-textbox" label="Ip:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese el Ip',required:true" name="ip" value="<?php 
                if(isset($datos)){ echo $datos["IP"];}
             ?>">

        </div>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
    <input type="hidden" value=<?=  $cod_ip ?> name="cod_ip" >
    <input type="hidden" value=<?=  $cod_personal ?> name="cod_personal" >
    <input type="hidden" value=<?=  $operacion ?> name="operacion" >

    
</form>

<script>
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>ip";
    }

</script>