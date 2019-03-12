<style>
	.inputGeo {
		height: 20px;
		padding: 5px 5px 5px 5px;
		border-radius: 4px;
		border: 1px solid #ccc;
		font-size: 13px;
		margin: 0;
		color: #444;
	}
</style>
<link type="text/css" rel="stylesheet" href="<?= base_url()?>assets/grocery_crud/themes/flexigrid/css/flexigrid.css" />
<?php echo $map['js']; ?>
<form name="form1" action="<?= base_url() ?>personal/georeferenciar/<?= $COD_PERSONAL ?>" method="post">
<div align="center">
	<strong>LATITUD : </strong><input id="lat" name="latitud" type="text" maxlength="255" class="form-control inputGeo" value="<?= $latitud ?>" readonly="true"/>
	<strong>LONGITUD: </strong><input id="lng" name="longitud" type="text" maxlength="255" class="form-control inputGeo" value="<?= $longitud ?>" readonly="true"/>
	<input name="boton" value="Guardar" type="submit" class="btn btn-large"/>
</div>
<br/>
<!--<div align="center" style="width: 300px;">-->
<?php echo $map['html']; ?>
</form>
<script>
	function setGeoreferencia(latitud, longitud) {
		document.getElementById("lat").value = latitud;
    	document.getElementById("lng").value = longitud;
	}
</script>
<!--</div>-->