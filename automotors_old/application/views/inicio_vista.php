<h1>Su ingreso ha sido satisfactorio</h1>
<?php
	$acceso = $this->session->flashdata('acceso');
    if ($acceso) {
    ?>
		<div id="report-error" class="report-div error" style="display: block;">
			<h2><p><?= $acceso ?></p></h2>
		</div>
    <?php
    }
    $success = $this->session->flashdata('success');
    if ($success) {
    ?>
		<div id="report-success" class="report-div success" style="display: block;">
			<h2><p><?= $success ?></p></h2>
		</div>
    <?php
    }
?>
<!--<h3>Asignar las siguientes pantallas esta disponibles para asignar al menu:</h3>
<p><a href="<?= base_url() ?>menuwebopcion/listar">menuwebopcion/listar_XXX</a></p><p>
<a href="<?= base_url() ?>menumobopcion/listar">menumobopcion/listar</a></p><p>
<a href="<?= base_url() ?>menuweb">menuweb_XXX</a></p><p>
<a href="<?= base_url() ?>menumobile">menumobile_XXX</a></p><p>
<a href="<?= base_url() ?>usuarios">usuarios_XXX</a></p><p>
<a href="<?= base_url() ?>rol">rol_XXX</a></p><p>
<a href="<?= base_url() ?>rol/rol_menu_web">rol/rol_menu_web_XXX</a></p><p>
<a href="<?= base_url() ?>rol/rol_menu_mobile">rol/rol_menu_mobile_XXX</a></p>-->
<pre>
<!--<?= print_r($this->session->get_userdata())?>-->
<!--<?= print_r($this->session->get_userdata()['menu_padre'])?>-->
</pre>