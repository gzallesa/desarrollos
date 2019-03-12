<?php echo form_open('comprobanteegreso/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
			<?php if (isset($datos)) { ?>
	             <input class="easyui-textbox" label="Nro Comprobante:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese Numero Comprobante',required:true,readonly:'true'" name="numero_comprobante" value="<?php 
	                if(isset($datos)){ echo $datos["NUMERO_COMPROBANTE"];}
	             ?>">
			<?php } else {?>
	             <input class="easyui-textbox" label="Nro Comprobante:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese Numero Comprobante',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>" name="numero_comprobante" value="<?php 
	                if(isset($datos)){ echo $datos["NUMERO_COMPROBANTE"];}
	             ?>">
			<?php }?>
             <input class="easyui-textbox" label="Orden de:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese a orden de',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>" name="orden_de" value="<?php 
                if(isset($datos)){ echo $datos["ORDEN_DE"];}
             ?>">

             <input class="easyui-textbox" label="NIT/CI:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese Nit / CI',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>" name="nit_ci" value="<?php 
                if(isset($datos)){ echo $datos["NIT_CI"];}
             ?>">

             <input class="easyui-textbox" label="Concepto:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese Concepto',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>" name="concepto" value="<?php 
                if(isset($datos)){ echo $datos["CONCEPTO"];}
             ?>">

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="banco" class="easyui-combobox" name="banco" labelPosition="top"
	    			   data-options="valueField:'codigo',textField:'descripcion',data:banco,prompt:'Elija Banco',required:true, readonly:<?= $operacion=='C'?'true':'false'; ?>"  
					   style="width:100%;height:52px"  label="Banco:">
	        </div>
			
             <input class="easyui-textbox" label="Monto:" labelPosition="top" style="width:100%;height:52px"  data-options="prompt:'Ingrese monto a pagar',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>" name="monto_pagar" value="<?php 
                if(isset($datos)){ echo $datos["MONTO_PAGAR"];}
             ?>">
			
            <input class="easyui-datebox" label="Fecha Registro:" labelPosition="top" style="width:100%;height:52px"  name="fecha_registro" data-options="prompt:'Ingrese fecha registro',required:true,readonly:<?= $operacion=='C'?'true':'false'; ?>," value="<?php 
                if(isset($datos)){ echo  $datos["FECHA_REGISTRO"];}
             ?>">

        </div>
		<?php if ($operacion <> 'C') {?>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>	
		<?php } ?>
        
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

        

    </div>  

    <input type="hidden" value=<?=  $operacion ?> name="operacion">

    
</form>

<script>

	var banco=<?= $banco ?>;
	
	
	$(document).ready(function() {
		var operacion = '<?= $operacion ?>';
		if ((operacion == "U")||(operacion == "C")){

			$('#banco').combobox('setValue', '<?php if(isset($datos)){ echo $datos["BANCO"];}else{ echo "";} ?>');
		}
	});


    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>comprobanteegreso";
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