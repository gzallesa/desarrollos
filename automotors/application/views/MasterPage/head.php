<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bolivia Automotors</title>
    <link rel="icon" href="<?= base_url() ?>assets/img/icon.png" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/themes/gray/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/themes/color.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/themes/demo.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/estilos.css">
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/datagrid-export.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/datagrid-filter.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/locale/easyui-lang-es.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/datagrid-groupview.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/accounting.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/accounting.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/utils.js"></script>
    <script>
        jQuery(document).ready(function(){
            $('.menuprincipal .accordion-header').click(function() {
                $(this).next().toggle('fast');
                return false;
            }).next().hide();
        });
    </script>
    
</head>
<body style="background: #e2e2e2;" class="easyui-layout">

<div data-options="region:'west',title:'Menu',split:true" style="width:230px;">
    <div class="menuprincipal easyui-accordion">
        <?= $menu_html ?>
    </div>
</div>
<div data-options="region:'center',title:'Bolivia Automotors'" style="padding:5px;background:#eee;">
    <!-- menu superior -->
    <div style="background: #dcdee4;height: 30px;">

        <a id="btn" href="<?= base_url() ?>" class="easyui-linkbutton" data-options="iconCls:'icono-application_home'">Ir al Inicio</a>

        <a href="javascript:void(0)" id="mb" class="easyui-menubutton" 
            data-options="menu:'#mm',iconCls:'icono-user',plain:false" style="float:right;"><?= $this->session->nombre; ?></a>
        <div id="mm" >
            <div data-options="iconCls:'icono-doc_text_image',href:'<?= base_url() ?>usuarios/index/read/admin'">Información</div>
            <div data-options="iconCls:'icono-pencil',href:'<?= base_url() ?>usuarios/index/edit/admin'">Modificar datos</div>
            <div data-options="iconCls:'icono-ui_text_field_password',href:'<?= base_url() ?>usuarios/cambiarPass'">Cambiar password</div>
            <div class="menu-sep"></div>
            <div data-options="iconCls:'icono-lock',href:'<?= base_url() ?>auth/salir'">Cerrar Sesión</div>
        </div>
    </div>
    <!--/menu superior -->
    <!-- breadcrumb -->
    <?php if(isset($breadCrumb)): ?>
    <div>
    	<?= $breadCrumb ?>
        <!--<ul class="breadcrumb">
        	<li><a href="value">key</a> </li>
        	<li class="active">HOME</li>
        </ul>-->
    </div>
    <?php endif; ?>
    <!-- /breadcrumb -->