<?php echo form_open('equipo/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <input class="easyui-textbox" label="Cod Equipo:" labelPosition="top" style="width:100%;height:52px"  name="cod_equipo" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["cod_equipo"];}
             ?>">

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="tipo_equipo" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:tipo_equipo,prompt:'Elija el tipo equipo',required:true" style="width:100%;height:52px"  label="Tipo Equipo:"value="<?php 
                if(isset($datos)){ echo $datos["tipo_equipo"];}
             	?>">
	        </div>

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="marca" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:marca,prompt:'Elija la marca',required:true" style="width:100%;height:52px"  label="Marca:"value="<?php 
                if(isset($datos)){ echo $datos["marca"];}
             	?>">
	        </div>

            <input class="easyui-textbox" label="Descripcion:" labelPosition="top" style="width:100%;height:52px"  name="descripcion" data-options="" value="<?php 
                if(isset($datos)){ echo  $datos["descripcion"];}
             ?>">

            <input class="easyui-textbox" label="Observacion:" labelPosition="top" style="width:100%;height:52px"  name="observacion" data-options="" value="<?php 
                if(isset($datos)){ echo  $datos["observacion"];}
             ?>">

            <input class="easyui-textbox" label="Serie:" labelPosition="top" style="width:100%;height:52px"  name="serie" data-options="required:true" value="<?php 
                if(isset($datos)){ echo  $datos["serie"];}
             ?>">

            <input class="easyui-datebox" label="Fecha Registro:" labelPosition="top" style="width:100%;height:52px"  name="fecha_registro" data-options="" value="<?php 
                if(isset($datos)){ echo  $datos["fecha_registro"];}
             ?>">

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="moneda" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:moneda,prompt:'Elija moneda',required:true" style="width:100%;height:52px"  label="Moneda:"value="<?php 
                if(isset($datos)){ echo $datos["moneda"];}
             	?>">
	        </div>
             
            <input class="easyui-textbox" label="Valor:" labelPosition="top" style="width:100%;height:52px"  name="valor" data-options="required:true" value="<?php 
                if(isset($datos)){ echo  $datos["valor"];}
             ?>">

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="tipo" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:tipo,prompt:'Elija tipo',required:true" style="width:100%;height:52px"  label="Tipo:"value="<?php 
                if(isset($datos)){ echo $datos["tipo"];}
             	?>">
	        </div>
	        
	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="proveedor" labelPosition="top"
	    		data-options="valueField:'cod_proveedor',textField:'razon_social',data:proveedor,prompt:'Elija proveedor',required:true" style="width:100%;height:52px"  label="Proveedor:"value="<?php 
                if(isset($datos)){ echo $datos["cod_proveedor"];}
             	?>">
	        </div>

        </div>

        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

    </div>
    <input type="hidden" value=<?=  $operacion ?> name="operacion" >

    
</form>

<script>
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>equipo";
    }
    var tipo_equipo=<?= $tipo_equipo ?>;
    var marca=<?= $marca ?>;
    var moneda=<?= $moneda ?>;
    var tipo=<?= $tipo ?>;
	var proveedor=<?= $proveedor ?>;
	
/*	$.fn.datebox.defaults.formatter = function(date) {
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
	
	$('#fecha_registro').datetimebox({showSeconds:$(this).is(false)})
	$('#fecha_registro').datetimebox({showMinutes:$(this).is('false')})
	$('#fecha_registro').datetimebox({showHours:$(this).is('false')})*/
	
	
</script>
