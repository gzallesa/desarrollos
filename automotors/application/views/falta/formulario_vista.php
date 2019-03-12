<?php echo form_open('falta/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <?php  if(!isset($datos)) { 
                echo "<p>Cod Personal: ". $cod_personal ."</p>";
            }else{  ?>
            <input class="easyui-textbox" label="Cod Falta:" labelPosition="top" style="width:100%;height:52px"  name="cod_dia_falta" data-options="readonly:<?= isset($datos)?'true':'false'; ?>" value="<?php 
                if(isset($datos)){ echo  $datos["cod_dia_falta"];}
             ?>">
             <?php } ?>            

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="tipo_planilla" labelPosition="top"
	    		data-options="valueField:'tipo_planilla',textField:'desc_tipo_planilla',data:tipo_planilla,prompt:'Elija tipo planilla',required:true" style="width:100%;height:52px"  label="Tipo Planilla:"value="<?php 
                if(isset($datos)){ echo $datos["tipo_planilla"];}
             	?>">
	        </div>

             <input class="easyui-textbox" label="Descripcion:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese descripcion',required:true" name="descripcion" value="<?php 
                if(isset($datos)){ echo $datos["descripcion"];}
             ?>">

            <input class="easyui-datebox" label="Periodo:" labelPosition="top" style="width:100%;height:52px"  name="periodo" id="periodo" data-options="prompt:'Ingrese periodo',required:true" 
				   value="<?php 
                if(isset($datos)){ echo  $datos["periodo"];}
             ?>">
             
             <input class="easyui-textbox" label="Valor:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese valor',required:true" name="valor" value="<?php 
                if(isset($datos)){ echo $datos["valor"];}
             ?>">

        </div>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
    <input type="hidden" value=<?=  $cod_dia_falta ?> name="cod_dia_falta" >
    <input type="hidden" value=<?=  $cod_personal ?> name="cod_personal" >
    <input type="hidden" value=<?=  $operacion ?> name="operacion" >

    
</form>

<script>
	tipo_planilla = <?= $tipo_planilla ?>;
	//console.log('Tipo planilla : ' + JSON.stringify(tipo_planilla));
	
	$('#periodo').keypress(function(e) {
	  e.preventDefault();
	  return false;
	});
	
	$("#periodo").keydown(false);
	
	$("#periodo").on("keydown keypress keyup", false);
	
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>ip";
    }
    
</script>