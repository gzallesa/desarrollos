<?php echo form_open('equipo',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:600px;padding:30px 60px;"> 
        <div style="margin-bottom:20px">
            
            <input class="easyui-textbox" label="Codigo:" labelPosition="top" style="width:100%;height:52px"  name="cod_personal_equipo" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["cod_personal_equipo"];}
             ?>">

            <input class="easyui-textbox" label="Personal:" labelPosition="top" style="width:100%;height:52px"  name="nombre_completo" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["nombre_completo"];}
             ?>">

            <input class="easyui-textbox" label="Tipo Equipo:" labelPosition="top" style="width:100%;height:52px"  name="desc_tipo_equipo" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["desc_tipo_equipo"];}
             ?>">

            <input class="easyui-textbox" label="Marca:" labelPosition="top" style="width:100%;height:52px"  name="desc_marca" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["desc_marca"];}
             ?>">

            <input class="easyui-textbox" label="Equipo:" labelPosition="top" style="width:100%;height:52px"  name="desc_equipo" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["desc_equipo"];}
             ?>">

            <input class="easyui-textbox" label="Serie:" labelPosition="top" style="width:100%;height:52px"  name="serie_equipo" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["serie_equipo"];}
             ?>">

            <input class="easyui-textbox" label="Serie:" labelPosition="top" style="width:100%;height:52px"  name="serie_equipo" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["serie_equipo"];}
             ?>">

            <input class="easyui-textbox" label="Nombre Equipo:" labelPosition="top" style="width:100%;height:52px"  name="nombre_equipo" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["nombre_equipo"];}
             ?>">
             
            <input class="easyui-textbox" label="Descripcion:" labelPosition="top" style="width:100%;height:52px"  name="descripcion" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["descripcion"];}
             ?>">

            <input class="easyui-textbox" label="Fecha Creacion:" labelPosition="top" style="width:100%;height:52px"  name="fecha_creacion" data-options="readonly:true" value="<?php 
                if(isset($datos)){ echo  $datos["fecha_creacion"];}
             ?>">

        </div>

        <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>-->
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icono-arrow_undo" data-options="iconAlign:'right'"  style="height:32px" onclick="cancelar()">Cancelar / Volver</a>

    </div>
   <!-- <input type="hidden" value=<?=  $operacion ?> name="operacion" >-->

    
</form>

<script>
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href =" <?= base_url() ?>personalequipo";
    }
	
	
</script>
