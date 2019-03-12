<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bolivia Automotors</title>
    <link rel="icon" href="<?= base_url() ?>assets/img/icon.png" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/themes/gray/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/themes/icon.css">
    <link rel="st							ylesheet" type="text/css" href="<?= base_url() ?>assets/themes/color.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/themes/demo.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/estilos.css">
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/locale/easyui-lang-es.js"></script>
</head>
<body style="background: #e2e2e2;">

<div style="margin:0 auto; width:400px;padding-top: 100px;">
    <div class="easyui-panel" title="Ingreso de usuario al sistema" style="width:400px;max-width:400px;padding:30px 60px;">
        <img src="<?= base_url() ?>assets/img/logo.png" style="width: 280px;" />
        <?php echo form_open('auth/login',array( 'id' => 'ff','data-options'=>'ajax:false')); ?> 
            
            <div style="margin:20px 0;"></div>
                <div style="margin-bottom:10px">
                    <input class="easyui-textbox" style="width:100%;height:40px;padding:12px" name="usuario" data-options="prompt:'Usuario',iconCls:'icon-man',iconWidth:38,required:true">
                </div>
                <div style="margin-bottom:20px">
                    <input class="easyui-textbox" type="password" style="width:100%;height:40px;padding:12px" name="password" data-options="prompt:'Contraseña',iconCls:'icon-lock',iconWidth:38,required:true">
                </div>
                <div style="margin-bottom:20px">
                    <input type="checkbox" checked="checked">
                    <span>Recordarme</span>
                </div>
                <?php if(isset($error)) :?>
                	<div id="report-error" class="report-div error" style="display: block;">
						<p><?= $error ?></p>
					</div>
                <?php endif; ?>
                <div>
                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icono-key'" style="padding:5px 0px;width:100%;" onclick="submitForm()">
                        <span style="font-size:14px;">Ingresar</span>
                    </a>
                </div>
        </form>
    </div>
</div>
<script>
    function submitForm(){
        $('#ff').form('submit');
    }
</script>

</body>
</html>