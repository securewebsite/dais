<?php if (count($currencies) > 1) { ?>
<div class="btn-group">
	<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="currency">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?= $lang_text_currency; ?> <span class="caret"></span></button>
		<ul class="dropdown-menu">
		<?php foreach ($currencies as $currency) { ?>
			<?php if ($currency['code'] == $currency_code) { ?>
				<li><a href="<?= $currency['code']; ?>"><b>(<?= $currency['symbol_left'] ? $currency['symbol_left'] : $currency['symbol_right']; ?>) <?= $currency['title']; ?></b></a></li>
			<?php } else { ?>
				<li><a href="<?= $currency['code']; ?>">(<?= $currency['symbol_left'] ? $currency['symbol_left'] : $currency['symbol_right']; ?>) <?= $currency['title']; ?></a></li>
			<?php } ?>
		<?php } ?>
		</ul>
		<input type="hidden" name="currency_code" value="">
		<input type="hidden" name="redirect" value="<?= $redirect; ?>">
	</form>
</div>
<?php } ?>
