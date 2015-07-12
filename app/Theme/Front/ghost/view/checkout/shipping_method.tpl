<div class="panel-body">
	<form class="">
		<?php if ($error_warning) { ?>
		<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
		<?php } ?>
		<?php if ($shipping_methods) { ?>
		<h4><?= $lang_text_shipping_method; ?></h4>
		<table class="table table-striped form-inline">
			<?php foreach ($shipping_methods as $shipping_method) { ?>
				<?php if (!$shipping_method['error']) { ?>
					<?php $i = 0; ?>
					<?php foreach ($shipping_method['quote'] as $quote) { ?>
						<tr>
							<?php if (!$i) { ?>
							<td rowspan="<?= count($shipping_method['quote']); ?>"><?= $shipping_method['title']; ?></td>
							<?php } ?>
							<td>
								<div class="radio radio-inline">
								<label for="<?= $quote['code']; ?>">
							<?php if ($quote['code'] == $code || !$code) { ?>
								<?php $code = $quote['code']; ?>
								<input type="radio" name="shipping_method" value="<?= $quote['code']; ?>" id="<?= $quote['code']; ?>" checked="">
							<?php } else { ?>
								<input type="radio" name="shipping_method" value="<?= $quote['code']; ?>" id="<?= $quote['code']; ?>">
							<?php } ?>
							<?= $quote['title']; ?></label>
								</div>
							</td>
							<td class="text-right">
								<label for="<?= $quote['code']; ?>"><?= $quote['text']; ?></label>
							</td>
						</tr>
						<?php $i++; ?>
					<?php } ?>
				<?php } else { ?>
					<tr>
						<td><?= $shipping_method['title']; ?></td>
						<td colspan="2"><span class="text-error"><?= $shipping_method['error']; ?></span></td>
					</tr>
				<?php } ?>
			<?php } ?>
		</table>
		<hr>
		<?php } ?>
		<h5><?= $lang_text_comments; ?></h5>
		<textarea name="comment" rows="4" class="form-control" placeholder="<?= $lang_text_comments; ?>" ><?= $comment; ?></textarea>
	</form>
</div>
<div class="panel-footer text-right">
	<button type="button" id="button-shipping-method" class="btn btn-primary load-left"><?= $lang_button_continue; ?></button>
</div>
