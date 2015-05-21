<html>
<head>
<link rel="stylesheet" href="<?= $this->app['https.server'] . $stylesheet; ?>">
</head>
<body>
<?php if (!$error_connection) { ?>
	<form action="<?= $url; ?>" method="post" name="ppform" id="ppform">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="<?= $code; ?>">
		<span class="alert alert-warning"><?= $lang_text_secure_connection ?></span>
		<img src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" alt="" border="0">
	</form>
	<script>
		document.getElementById('ppform').submit();
	</script>
<?php } else { ?>
	<div class="alert alert-danger"><?= $error_connection ?></div>
<?php } ?>
</body>
</html>