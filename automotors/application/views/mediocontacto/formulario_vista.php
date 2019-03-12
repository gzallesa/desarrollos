<?php echo form_open('medioscontacto/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <?php  if(!isset($datos)) { 
                echo "<p>Cod Personal: ". $cod_personal ."</p>";
            }else{  ?>
            <input class="easyui-textbox" label="Id Medio Contacto:" labelPosition="top" style="width:100%;height:52px"  name="id_medio_contacto" data-options="readonly:<?= isset($datos)?'true':'false'; ?>" value="<?php 
                if(isset($datos)){ echo  $datos["id_medio_contacto"];}
             ?>">
             <?php } ?>            

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="medio_contacto" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:datos,prompt:'Elija el medio de contacto',required:true" style="width:100%;height:52px"  label="Medio contacto:"value="<?php 
                if(isset($datos)){ echo $datos["medio_contacto"];}
             	?>">
	        </div>

             <input class="easyui-textbox" label="Valor:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese el valor',required:true" name="valor" value="<?php 
                if(isset($datos)){ echo $datos["valor"];}
             ?>">
        </div>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
    <input type="hidden" value=<?=  $id_medio_contacto ?> name="id_medio_contacto" >
    <input type="hidden" value=<?=  $cod_personal ?> name="cod_personal" >
    <input type="hidden" value=<?=  $operacion ?> name="operacion" >

    
</form>

<script>
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>medioscontacto";
    }
    var datos=<?= $json ?>;

</script>