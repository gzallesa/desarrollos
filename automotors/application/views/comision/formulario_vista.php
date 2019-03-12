<?php echo form_open('comision/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <?php  if(!isset($datos)) { 
                echo "<p>Cod Personal: ". $cod_personal ."</p>";
            }else{  ?>
            <input class="easyui-textbox" label="Cod Comision:" labelPosition="top" style="width:100%;height:52px"  name="cod_comision_variable" data-options="readonly:<?= isset($datos)?'true':'false'; ?>" value="<?php 
                if(isset($datos)){ echo  $datos["cod_comision_variable"];}
             ?>">
             <?php } ?>            

             <input class="easyui-textbox" label="Gestion:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese la gestion',required:true" name="gestion" value="<?php 
                if(isset($datos)){ echo $datos["gestion"];}
             ?>">

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="tipo_planilla" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:tipo_planilla,prompt:'Elija tipo planilla',required:true" style="width:100%;height:52px"  label="Tipo Planilla:"value="<?php 
                if(isset($datos)){ echo $datos["tipo_planilla"];}
             	?>">
	        </div>

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="comision_variable" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:comision_variable,prompt:'Elija tipo comision',required:true" style="width:100%;height:52px"  label="Comision:"value="<?php 
                if(isset($datos)){ echo $datos["comision_variable"];}
             	?>">
	        </div>

             <input class="easyui-textbox" label="Descripcion:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese descripcion',required:false" name="descripcion" value="<?php 
                if(isset($datos)){ echo $datos["descripcion"];}
             ?>">

             <input class="easyui-textbox" label="Monto:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese el Monto',required:true" name="monto" value="<?php 
                if(isset($datos)){ echo $datos["monto"];}
             ?>">

        </div>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
    <input type="hidden" value=<?=  $cod_comision_variable ?> name="cod_comision_variable" >
    <input type="hidden" value=<?=  $cod_personal ?> name="cod_personal" >
    <input type="hidden" value=<?=  $operacion ?> name="operacion" >

    
</form>

<script>

	var tipo_planilla=<?= $tipo_planilla ?>;
	var comision_variable=<?= $comision_variable ?>;
	

    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>ip";
    }

</script>