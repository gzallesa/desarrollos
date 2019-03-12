<?php echo form_open('datospersonal/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <?php  
                echo "<p>Personal: ". $cod_personal ."</p>";
			?>
            
	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="division_negocio" class="easyui-combobox" name="division_negocio" labelPosition="top"
	    			   data-options="valueField:'codigo',textField:'descripcion',data:division_negocio,prompt:'Elija division negocio',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>,
	    					onSelect: function(rec){
	    											$('#centro_gestion').combobox('setValue', '');
										            var url = '<?= base_url() ?>datospersonal/getComboDinamico/'+rec.codigo;
										            $('#centro_gestion').combobox('reload', url);
										           }"  
					   style="width:100%;height:52px"  label="Division Negocio:">
	        </div>
			
	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="centro_gestion" class="easyui-combobox" name="centro_gestion" labelPosition="top"
	    			   data-options="valueField:'codigo',textField:'descripcion',data:centro_gestion,prompt:'Elija centro gestion',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>,"
        			   style="width:100%;height:52px"  label="Centro Gestion:">
	        </div> 
			
            <input class="easyui-datebox" label="Fecha Ingreso:" labelPosition="top" style="width:100%;height:52px"  name="fecha_ingreso" data-options="readonly:<?= $operacion=='C'?'true':'false'; ?>," value="<?php 
                if(isset($datos)){ echo  $datos["FECHA_INGRESO"];}
             ?>">
             
             <?php if ($operacion != 'I') { ?>
             
	            <input class="easyui-datebox" label="Fecha Salida:" labelPosition="top" style="width:100%;height:52px"  name="fecha_salida" data-options="readonly:<?= $operacion=='C'?'true':'false'; ?>" value="<?php 
	                if(isset($datos)){ echo  $datos["FECHA_SALIDA"];}
	             ?>">

             <?php } ?>
             
             <input class="easyui-textbox" label="Sueldo Basico:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese Sueldo',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>" name="sueldo_basico" value="<?php 
                if(isset($datos)){ echo $datos["SUELDO_BASICO"];}
             ?>">
			 
            <input class="easyui-datebox" label="Fecha Nacimiento:" labelPosition="top" style="width:100%;height:52px"  name="fecha_nacimiento" data-options="readonly:<?= $operacion=='C'?'true':'false'; ?>" value="<?php 
                if(isset($datos)){ echo  $datos["FECHA_NACIMIENTO"];}
             ?>">
			 
	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="tipo_documento" class="easyui-combobox" name="tipo_documento" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:tipo_documento,prompt:'Elija tipo documento',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>" style="width:100%;height:52px"  label="Tipo Documento:">
	        </div>
	        
             <input class="easyui-textbox" label="Numero Documento:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese Numero Documento',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>" name="numero_documento" value="<?php 
                if(isset($datos)){ echo $datos["NUMERO_DOCUMENTO"];}
             ?>">

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="expedido" class="easyui-combobox" name="expedido" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:expedido,prompt:'Elija expedido',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>" style="width:100%;height:52px"  label="Expedido:">
	        </div>

             <input class="easyui-textbox" label="Matricula:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese matricula',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>" name="matricula" value="<?php 
                if(isset($datos)){ echo $datos["MATRICULA"];}
             ?>">
             
	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="afp" class="easyui-combobox" name="afp" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:afp,prompt:'Elija Si o No',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>,
	    					onSelect: function(rec){
	    											$('#desc_afp').combobox('setValue', '');
										            $('#desc_afp').combobox(rec.codigo=='S'?'enable':'disable');
										            var valor = rec.codigo=='S'?true:false;
										            $('#desc_afp').combobox('options').required = valor;
										            $('#desc_afp').combobox('textbox').validatebox('options').required = valor;
										           }" style="width:100%;height:52px"  label="Aplica AFP?:">
	        </div>	
             
	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="desc_afp" class="easyui-combobox" name="desc_afp" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:desc_afp,prompt:'Elija AFP',required:false, readonly:<?= $operacion=='C'?'true':'false'; ?>" style="width:100%;height:52px"  label="AFP:">
	        </div>			

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="tipo_planilla" class="easyui-combobox" name="tipo_planilla" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:tipo_planilla,prompt:'Elija tipo planilla',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>" style="width:100%;height:52px"  label="Tipo Planilla:">
	        </div>	

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="tipo_empleado" class="easyui-combobox" name="tipo_empleado" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:tipo_empleado,prompt:'Elija tipo empleado',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>" style="width:100%;height:52px"  label="Tipo Empleado:">
	        </div>	

             <input class="easyui-textbox" label="Cuenta:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese cuenta',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>" name="cuenta" value="<?php 
                if(isset($datos)){ echo $datos["CUENTA"];}
             ?>">

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="excepcionado" class="easyui-combobox" name="excepcionado" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:excepcionado,prompt:'Elija Si o No',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>"
	    					style="width:100%;height:52px"  label="Excepcionado:">
	        </div>	
	        
	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="pago_aguinaldo" class="easyui-combobox" name="pago_aguinaldo" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:pago_aguinaldo,prompt:'Elija Si o No',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>"
	    					style="width:100%;height:52px"  label="Pago Aguinaldo:">
	        </div>	

        </div>
		<?php if ($operacion <> 'C') {?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>	
		<?php } ?>
        
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  
    <input type="hidden" value=<?=  $cod_personal ?> name="cod_personal" >
    <input type="hidden" value=<?=  $operacion ?> name="operacion">
    <input type="hidden" value=<?=  $codDatosPersonal ?> name="codDatosPersonal">

    
</form>

<script>

    var division_negocio=<?= $division_negocio ?>;
    var centro_gestion=<?= $centro_gestion ?>;
    var tipo_documento=<?= $tipo_documento ?>;
    var expedido=<?= $expedido ?>;
    var afp=<?= $afp ?>;
    var desc_afp=<?= $desc_afp ?>;
	var tipo_planilla=<?= $tipo_planilla ?>;
	var tipo_empleado=<?= $tipo_empleado ?>;
	var excepcionado=<?= $excepcionado ?>;
	var pago_aguinaldo=<?= $pago_aguinaldo ?>;
	
	
	$(document).ready(function() {
		var operacion = '<?= $operacion ?>';
		if ((operacion == "U")||(operacion == "C")){
			$('#division_negocio').combobox('setValue', '<?php if(isset($datos)){ echo $datos["DIVISION_NEGOCIO"];}else{ echo "";} ?>');
			$('#centro_gestion').combobox('setValue', '<?php if(isset($datos)){ echo $datos["CENTRO_GESTION"];}else{ echo "";} ?>');
			$('#tipo_documento').combobox('setValue', '<?php if(isset($datos)){ echo $datos["TIPO_DOCUMENTO"];}else{ echo "";} ?>');
			$('#expedido').combobox('setValue', '<?php if(isset($datos)){ echo $datos["EXPEDIDO"];}else{ echo "";} ?>');
			$('#afp').combobox('setValue', '<?php if(isset($datos)){ echo $datos["AFP"];}else{ echo "";} ?>');
			$('#desc_afp').combobox('setValue', '<?php if(isset($datos)){ echo $datos["DESC_AFP"];}else{ echo "";} ?>');
			$('#tipo_planilla').combobox('setValue', '<?php if(isset($datos)){ echo $datos["TIPO_PLANILLA"];}else{ echo "";} ?>');
			$('#tipo_empleado').combobox('setValue', '<?php if(isset($datos)){ echo $datos["TIPO_EMPLEADO"];}else{ echo "";} ?>');
			$('#excepcionado').combobox('setValue', '<?php if(isset($datos)){ echo $datos["EXCEPCIONADO"];}else{ echo "";} ?>');
			$('#pago_aguinaldo').combobox('setValue', '<?php if(isset($datos)){ echo $datos["PAGO_AGUINALDO"];}else{ echo "";} ?>');			
		}
	});


    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>datospersonal";
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