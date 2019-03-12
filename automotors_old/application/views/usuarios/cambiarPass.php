<meta charset="UTF-8">
<link type="text/css" rel="stylesheet" href="<?= base_url()?>assets/grocery_crud/css/ui/simple/jquery-ui-1.10.1.custom.min.css" />
<link type="text/css" rel="stylesheet" href="<?= base_url()?>assets/grocery_crud/css/jquery_plugins/chosen/chosen.css" />
<link type="text/css" rel="stylesheet" href="<?= base_url()?>assets/grocery_crud/themes/flexigrid/css/flexigrid.css" />
<script src="<?= base_url()?>assets/grocery_crud/js/jquery-1.11.1.min.js"></script>
<script src="<?= base_url()?>assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?= base_url()?>assets/grocery_crud/js/jquery_plugins/ui/i18n/datepicker/jquery.ui.datepicker-es.js"></script>
<script src="<?= base_url()?>assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"></script>
<script src="<?= base_url()?>assets/grocery_crud/js/jquery_plugins/config/jquery.chosen.config.js"></script>
<script src="<?= base_url()?>assets/grocery_crud/themes/flexigrid/js/jquery.form.js"></script>
<script src="<?= base_url()?>assets/grocery_crud/js/jquery_plugins/jquery.form.min.js"></script>
<script src="<?= base_url()?>assets/grocery_crud/js/jquery_plugins/jquery.noty.js"></script>
<script src="<?= base_url()?>assets/grocery_crud/js/jquery_plugins/config/jquery.noty.config.js"></script>
<script src="<?= base_url()?>assets/grocery_crud/themes/flexigrid/js/flexigrid-edit.js"></script>
<div class="flexigrid crud-form" style='width: 100%;' data-unique-hash="dbe4c3db6f5b2b4d69104fa7d2bd3d60">
	<div class="mDiv">
		<div class="ftitle">
			<div class='ftitle-left'>Cambiar Contraseña</div>
			<div class="clear"></div>
		</div>
		<div title="Minimizar/Maximizar" class="ptogtitle">
			<span></span>
		</div>
	</div>
	<div id='main-table-box'>
		<form action="<?= base_url()?>usuarios/cambiarPass" method="post" id="crudForm"  enctype="multipart/form-data" accept-charset="utf-8">
			<div class='form-div'>
				<div class='form-field-box odd' id="USUARIO_field_box">
					<div class='form-display-as-box' id="USUARIO_display_as_box">
						Usuario :
					</div>
					<div class='form-input-box' id="USUARIO_input_box">
						<input id="usuario" class='form-control' name="usuario" readonly="readonly" type='text' value="<?= $usuario ?>" maxlength="45" />
					</div>
					<div class='clear'>
					</div>
				</div>
				<div class='form-field-box even' id="old_pass_field_box">
					<div class='form-display-as-box' id="old_pass_display_as_box">
						Contraseña anterior
						<span class='required'>*</span>  :
					</div>
					<div class='form-input-box' id="old_pass_input_box">
						<input id="old_pass" class="form-control" name="old_pass" type="password" value="" maxlength='255' autocomplete="off"/>
					</div>
					<div class='clear'>
					</div>
				</div>
				<div class='form-field-box odd' id="new_pass_field_box">
					<div class='form-display-as-box' id="new_pass_display_as_box">
						Contraseña nueva
						<span class='required'>*</span>  :
					</div>
					<div class='form-input-box' id="new_pass_input_box">
						<input id="new_pass" class="form-control" name="new_pass" type="password" value="" maxlength="255" autocomplete="off"/>
					</div>
					<div class='clear'>
					</div>
				</div>
				<!-- Start of hidden inputs -->
				<!-- End of hidden inputs -->
				<?php if(isset($error)): ?>
					<div id="report-error" class="report-div error" style="display: block;"><p><?= $error ?></p></div>
				<?php endif; ?>
			</div>
			<div class="pDiv">
				<div class='form-button-box'>
					<input id="form-button-save" type='submit' name="boton" value="Modificar" class="btn btn-large"/>
				</div>
				<div class='form-button-box'>
					<input type="submit" name="boton" value="Cancelar" class="btn btn-large" id="cancel-button" />
				</div>
				<div class='clear'>
				</div>
			</div>
		</form>
	</div>
</div>
