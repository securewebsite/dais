<div class="panel-body">
	<form class="">
		<?php if ($error_warning){ ?>
		<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
		<?php } ?>
		<?php if ($payment_methods) { ?>
		<h4><?= $lang_text_payment_method; ?></h4>
		<?php foreach ($payment_methods as $payment_method) { ?>
			<div class="radio"><label><?php if ($payment_method['code'] == $code || !$code) { ?>
				<?php $code = $payment_method['code']; ?>
				<input type="radio" name="payment_method" value="<?= $payment_method['code']; ?>" checked="">
				<?php } else { ?>
				<input type="radio" name="payment_method" value="<?= $payment_method['code']; ?>">
				<?php } ?>
				<?= $payment_method['title']; ?></label></div>
			<?php } ?>
		<hr>
		<?php } ?>
		<div class="form-group">
			<h5><?= $lang_text_comments; ?></h5>
			<textarea name="comment" rows="4" class="form-control" placeholder="<?= $lang_text_comments; ?>" ><?= $comment; ?></textarea>
		</div>
		<?php if ($text_agree) { ?>
		<div class="alert alert-warning">
			<div class="checkbox checkbox-inline" style="max-height: 20px;">
				<label>
					<input type="checkbox" name="agree" value="1"<?= $agree ? ' checked=""' : ''; ?>><?= $text_agree; ?>
				</label>
			</div>
		</div>
		<?php } ?>
	</form>
</div>
<div class="panel-footer text-right">
	<button type="button" id="button-payment-method" class="btn btn-primary load-left"><?= $lang_button_continue; ?></button>
</div>
