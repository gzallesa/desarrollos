<?php echo form_open('menumobile/guardar_menu_mobile',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
    <div class="easyui-panel" title="<?= $titulo ?>" style="width:100%;max-width:400px;padding:30px 60px;"> 
        <?php if($operacion=="i"){ ?>
        <div style="margin-bottom:20px">
            Es menu Padre? 
            <input id='chk' class="easyui-switchbutton" data-options="onText:'SI',offText:'NO'"  >
        </div>
        <div style="margin-bottom:20px" id="cajaCombo">
            <input id="cb" class="easyui-combobox" name="MENU_PADRE"
    data-options="valueField:'MENU',textField:'NOMBRE_MENU',data:datos,prompt:'Elija el menu padre',required:true" style="width:100%;height:32px"  label="Menu Padre:" >
        </div>
        <?php }else if($operacion=="u"){ ?>
        <div style="margin-bottom:20px" id="cajaCombo">
            Menu Padre: <?php if(isset($menu)){ echo $menu["menu_padre"];} ?>
        </div>
        <input type="hidden" value=<?=  $menu['menu'] ?> name="MENU" >
        <input type="hidden" value=<?=  $menu['menu_padre'] ?> name="MENU_PADRE" >
        <?php } ?>
        <div style="margin-bottom:20px">
            <input class="easyui-textbox" label="ID de Menu:" labelPosition="top" style="width:100%;height:52px" data-options="prompt:'Ingrese el nombre del menu',required:true, disabled:<?= isset($menu)?'true':'false'; ?>" name="MENU" value="<?php 
                if(isset($menu)){ echo $menu["menu"];}
             ?>">
        </div>
        <div style="margin-bottom:20px">
            <input class="easyui-textbox" label="Nombre de Menu:" labelPosition="top" style="width:100%;height:52px" data-options="prompt:'Ingrese el nombre del menu',required:true" name="NOMBRE_MENU" value="<?php 
                if(isset($menu)){ echo $menu["nombre_menu"];}
             ?>">
        </div>

        <div style="margin-bottom:20px">
            <input class="easyui-textbox" label="Descripción:" labelPosition="top" style="width:100%;height:52px" data-options="prompt:'Ingrese la descripción del menu'" name="DESCRIPCION" value="<?php 
                if(isset($menu)){ echo $menu["descripcion"];}
             ?>">
        </div>
        
        <div>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" style="height:32px" onclick="submitForm()">Guardar</a>

            <a href="javascript:void(0)" class="easyui-linkbutton"  style="height:32px" onclick="cancelar()">Cancelar</a>
        </div>
        <input type="hidden" value=<?=  $operacion ?> name="operacion" >
        
</form>
<!-- mensaje de exito -->
<?php if(isset($mensaje)):
        if($mensaje["@estado"]=="0"){
 ?>
    <div  class="report-div success" style="display: block;"><p>Sus datos han sido guardados correctamente.  <a href="<?= base_url()  ?>menumobile">Volver a la lista</a></div>
<?php } else{ ?>
    <div class="report-div error" style="display: block;"><p><?= $mensaje["@error"]  ?> </div>
<?php } endif ?>
<!--/ mensaje de exito -->


<script>
    function submitForm(){
        $('#ff').form('submit');
    }
    function cancelar(){
        window.location.href ="<?= base_url() ?>menumobile";
    }
    var datos=<?= $json ?>;

     $('#chk').switchbutton({
            onChange: function(checked){
                $('#cb').combobox('options').required = !checked;
                $('#cb').combobox('textbox').validatebox('options').required = !checked;
                $('#cb').combobox('validate');
                if(checked)
                {
                    $('#cajaCombo').css("display","none");                    
                }else{
                    $('#cajaCombo').css("display","inherit");
                }

                
            }
        })
</script>