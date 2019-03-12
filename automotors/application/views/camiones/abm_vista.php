<script>
	function confirmActivar(delUrl, valor) {
 		if (confirm("Activar Camion " + valor + " ?")) {
  			document.location = delUrl + "/" +valor;
 		}
	}
</script>
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php echo $output; ?>