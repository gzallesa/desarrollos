<?php echo form_open('bonodeduccion/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <?php  
                echo "<p>Personal: ". $cod_personal ."</p>";
				if (isset($datos)) { ?>
				<input class="easyui-textbox" label="Codigo:" labelPosition="top" style="width:100%;height:52px"  name="cod_bono_deduccion" data-options="readonly:true" value="<?php 
                	if(isset($datos)){ echo  $datos["cod_bono_deduccion"];}
             	?>">
			<?php } ?>
	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="tipo_planilla" class="easyui-combobox" name="tipo_planilla" labelPosition="top"
	    			   data-options="valueField:'tipo_planilla',textField:'desc_tipo_planilla',data:tipo_planilla,prompt:'Elija tipo planilla',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>"  
					   style="width:100%;height:52px"  label="Tipo Planilla:">
	        </div>

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="tipo" class="easyui-combobox" name="tipo" labelPosition="top"
	    			   data-options="valueField:'codigo',textField:'descripcion',data:tipo,prompt:'Elija tipo',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>,
	    					onSelect: function(rec){
	    											$('#nivel').combobox('setValue', '');
										            var url = '<?= base_url() ?>bonodeduccion/getComboDinamico/'+rec.codigo;
										            $('#nivel').combobox('reload', url);
										           }"  
					   style="width:100%;height:52px"  label="Tipo:">
	        </div>

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="nivel" class="easyui-combobox" name="nivel" labelPosition="top"
	    			   data-options="valueField:'codigo',textField:'descripcion',data:nivel,prompt:'Elija nivel',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>,"
        			   style="width:100%;height:52px"  label="Nivel:">
	        </div> 
			
             <input class="easyui-textbox" label="Descripcion:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese descripcion',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>" name="descripcion" value="<?php 
                if(isset($datos)){ echo $datos["descripcion"];}
             ?>">
			
            <input class="easyui-datebox" label="Periodo inicio:" labelPosition="top" style="width:100%;height:52px"  name="periodo_inicio" data-options="prompt:'Ingrese periodo inicio',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>," value="<?php 
                if(isset($datos)){ echo  $datos["periodo_inicio"];}
             ?>">
             
            <input class="easyui-datebox" label="Periodo final:" labelPosition="top" style="width:100%;height:52px"  name="periodo_final" data-options="prompt:'Ingrese periodo final',readonly:<?= $operacion=='C'?'true':'false'; ?>," value="<?php 
                if(isset($datos)){ echo  $datos["periodo_final"];}
             ?>">

            <input class="easyui-textbox" label="Monto:" labelPosition="top" style="width:100%;height:52px"  name="monto" data-options="prompt:'Ingrese monto',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>," value="<?php 
                if(isset($datos)){ echo  $datos["monto"];}
             ?>">

        </div>
		<?php if ($operacion <> 'C') {?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>	
		<?php } ?>
        
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
    <input type="hidden" value=<?=  $cod_personal ?> name="cod_personal" >
    <input type="hidden" value=<?=  $operacion ?> name="operacion">
    <input type="hidden" value=<?=  $codBonoDeduccion ?> name="codBonoDeduccion">

    
</form>

<script>

    var tipo_planilla=<?= $tipo_planilla ?>;
	var tipo=<?= $tipo ?>;
	var nivel=<?= $nivel ?>;
	
	
	$(document).ready(function() {
		var operacion = '<?= $operacion ?>';
		if ((operacion == "U")||(operacion == "C")){

			$('#tipo_planilla').combobox('setValue', '<?php if(isset($datos)){ echo $datos["tipo_planilla"];}else{ echo "";} ?>');
			$('#tipo').combobox('setValue', '<?php if(isset($datos)){ echo $datos["tipo"];}else{ echo "";} ?>');
			$('#nivel').combobox('setValue', '<?php if(isset($datos)){ echo $datos["nivel"];}else{ echo "";} ?>');	
		}
	});


    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>bonodeduccion";
    }

	$.fn.datebox.defaults.formatter = function(date) {
		var y = date.getFullYear();
		var m = date.getMonth() + 1;
		var d = date.getDate();
		return (d < 10 ? '0' + d : d) + '/' + (m < 10 ? '0' + m : m) + '/' + y;
	};

	$.fn.datebox.defaults.parser = function(s) {
		if (s) {
			var a = s.split('/');
			var d = new Number(a[0]);
			var m = new Number(a[1]);
			var y = new Number(a[2]);
			var dd = new Date(y, m-1, d);
			return dd;
		} else {
			return new Date();
		}
	};

</script>