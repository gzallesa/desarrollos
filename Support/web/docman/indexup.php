<?php
require_once 'lib/db.php';
require_once 'lib/folder.php';
require_once 'lib/user.php';
session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Plupload - Custom example</title>

<!-- production -->
<script type="text/javascript" src="uploader/js/plupload.full.min.js"></script>


<!-- debug 
<script type="text/javascript" src="../js/moxie.js"></script>
<script type="text/javascript" src="../js/plupload.dev.js"></script>
-->

</head>
<body style="font: 13px Verdana; background: #eee; color: #333">
<input name="path" type="hidden" value="<?php echo folder::getPathByIDFolder($_SESSION['currentpath']); ?>">
<input name="idf" type="hidden" value="<?php echo $_SESSION['currentpath']; ?>">
<input name="idu" type="hidden" value="<?php echo ($_SESSION['user']->getIDU()); ?>">
<h1>Carga de archivos</h1>
    <button id="pickfiles">[Seleccione archivo]</button>
    <button id="uploadfiles">[Cargar archivo]</button>
<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
<br />

<div id="container">

</div>

<br />
<pre id="console"></pre>


<script type="text/javascript">
// Custom example logic

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('container'), // ... or DOM Element itself
	url : 'uploader/up/upload.php?path=<?php echo folder::getPathByIDFolder($_SESSION['currentpath']); ?>&idf=<?php echo $_SESSION['currentpath']; ?>&idu=<?php echo $_SESSION['user']->getIDU(); ?>',
	flash_swf_url : 'uploader/js/Moxie.swf',
	silverlight_xap_url : 'uploader/js/Moxie.xap',
	chunk_size: '500kb',
	filters : {
		max_file_size : '300mb',
		mime_types: [
			{title : "Docs", extensions : "*"},
			{title : "Zip files", extensions : "zip,rar,7zip,tar,gz"}
		]
	},

	init: {
		PostInit: function() {
			document.getElementById('filelist').innerHTML = '';

			document.getElementById('uploadfiles').onclick = function() {
				uploader.start();
				return false;
			};
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
				document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
		},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

uploader.init();

</script>
</body>
</html>
