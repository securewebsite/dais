<?php if ($checkout_method == 'iframe') { ?>
	<iframe name="hss_iframe" width="560px" height="540px" style="border:0px solid #DDDDDD; margin-left:210px;" scrolling="no" src="<?= $this->app['https.server'] . 'payment/pp_pro_iframe/create'; ?>"></iframe>
<?php } else { ?>
	<?php if (!$error_connection) { ?>
	<form action="<?= $url; ?>" method="post" name="ppform" id="ppform">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="<?= $code; ?>">
	</form>
	<script>
		document.getElementById('ppform').submit();
	</script>
	<?php } else { ?>
	<div class="alert alert-danger"><?= $error_connection ?></div>
	<?php } ?>
<?php } ?>
