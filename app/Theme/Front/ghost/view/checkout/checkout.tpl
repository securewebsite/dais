<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span=trim($column_left) ? 9 : 12; $span=trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<div id="checkout-container" class="panel-group">
			<div id="checkout" class="panel panel-default">
				<div class="panel-heading"><?= $lang_text_checkout_option; ?></div>
				<div id="checkout-collapse" class="panel-collapse collapse"></div>
			</div>
			<div id="payment-address" class="panel panel-default">
				<div class="panel-heading"><span><?= !$logged ? $lang_text_checkout_account : $lang_text_checkout_payment_address; ?></span></div>
				<div class="panel-collapse collapse"></div>
			</div>
			<?php if ($shipping_required) { ?>
			<div id="shipping-address" class="panel panel-default">
				<div class="panel-heading"><?= $lang_text_checkout_shipping_address; ?></div>
				<div class="panel-collapse collapse"></div>
			</div>
			<div id="shipping-method" class="panel panel-default">
				<div class="panel-heading"><?= $lang_text_checkout_shipping_method; ?></div>
				<div class="panel-collapse collapse"></div>
			</div>
			<?php } ?>
			<div id="payment-method" class="panel panel-default">
				<div class="panel-heading"><?= $lang_text_checkout_payment_method; ?></div>
				<div class="panel-collapse collapse"></div>
			</div>
			<div id="confirm" class="panel panel-default">
				<div class="panel-heading"><?= $lang_text_checkout_confirm; ?></div>
				<div class="panel-collapse collapse"></div>
			</div>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>