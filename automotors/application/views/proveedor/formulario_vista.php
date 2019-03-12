<?php echo form_open('proveedor/guardar',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            <input class="easyui-textbox" label="Cod Proveedor:" labelPosition="top" style="width:100%;height:52px"  name="cod_proveedor" data-options="readonly:<?= isset($datos)?'true':'false'; ?>,required:true" value="<?php 
                if(isset($datos)){ echo  $datos["COD_PROVEEDOR"];}
             ?>">

            <input class="easyui-textbox" label="Razon Social:" labelPosition="top" style="width:100%;height:52px"  name="razon_social" data-options="required:true" value="<?php 
                if(isset($datos)){ echo  $datos["RAZON_SOCIAL"];}
             ?>">
             
            <input class="easyui-textbox" label="Contacto:" labelPosition="top" style="width:100%;height:52px"  name="contacto" data-options="" value="<?php 
                if(isset($datos)){ echo  $datos["CONTACTO"];}
             ?>">

	        <div style="margin-bottom:20px" id="cajaCombo">
	            <input id="cb" class="easyui-combobox" name="especialidad" labelPosition="top"
	    		data-options="valueField:'codigo',textField:'descripcion',data:datos,prompt:'Elija la especialidad',required:true" style="width:100%;height:52px"  label="Especialidad:"value="<?php 
                if(isset($datos)){ echo $datos["ESPECIALIDAD"];}
             	?>">
	        </div>

            <input class="easyui-textbox" label="Descripcion:" labelPosition="top" style="width:100%;height:52px"  name="descripcion" data-options="" value="<?php 
                if(isset($datos)){ echo  $datos["DESCRIPCION"];}
             ?>">
             
            <input class="easyui-textbox" label="Observacion:" labelPosition="top" style="width:100%;height:52px"  name="observacion" data-options="" value="<?php 
                if(isset($datos)){ echo  $datos["OBSERVACION"];}
             ?>">
             
            <input class="easyui-textbox" label="NIT:" labelPosition="top" style="width:100%;height:52px"  name="nit" data-options="required:true" value="<?php 
                if(isset($datos)){ echo  $datos["NIT"];}
             ?>">
             
            <input class="easyui-textbox" label="Direccion:" labelPosition="top" style="width:100%;height:52px"  name="direccion" data-options="required:true" value="<?php 
                if(isset($datos)){ echo  $datos["DIRECCION"];}
             ?>">
             
            <input class="easyui-textbox" label="Telefono Fijo:" labelPosition="top" style="width:100%;height:52px"  name="telefono_fijo" data-options="" value="<?php 
                if(isset($datos)){ echo  $datos["TELEFONO_FIJO"];}
             ?>">

            <input class="easyui-textbox" label="Telefono Celular:" labelPosition="top" style="width:100%;height:52px"  name="telefono_celular" data-options="" value="<?php 
                if(isset($datos)){ echo  $datos["TELEFONO_CELULAR"];}
             ?>">

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
        window.location.href =" <?= base_url() ?>proveedor";
    }
    var datos=<?= $especialidad ?>;

</script>