<?= $header; ?>
<?php if ($error_warning) { ?>
<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
<?php } ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
			<div class="alert alert-warning"><?= $lang_text_description; ?></div>
			<fieldset>
				<legend><?= $lang_text_order; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-3" for="firstname"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
					<div class="col-sm-6">
						<input type="text" name="firstname" value="<?= $firstname; ?>" class="form-control" placeholder="<?= $lang_entry_firstname; ?>"  autofocus id="firstname" required>
						<?php if ($error_firstname) { ?>
						<span class="help-block error"><?= $error_firstname; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="lastname"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
					<div class="col-sm-6">
						<input type="text" name="lastname" value="<?= $lastname; ?>" class="form-control" placeholder="<?= $lang_entry_lastname; ?>"  id="lastname" required>
						<?php if ($error_lastname) { ?>
						<span class="help-block error"><?= $error_lastname; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="email"><b class="required">*</b> <?= $lang_entry_email; ?></label>
					<div class="col-sm-6">
						<input type="text" name="email" value="<?= $email; ?>" class="form-control" placeholder="<?= $lang_entry_email; ?>"  id="email" required>
						<?php if ($error_email) { ?>
						<span class="help-block error"><?= $error_email; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="telephone"><b class="required">*</b> <?= $lang_entry_telephone; ?></label>
					<div class="col-sm-6">
						<input type="text" name="telephone" value="<?= $telephone; ?>" class="form-control" placeholder="<?= $lang_entry_telephone; ?>"  id="telephone" required>
						<?php if ($error_telephone) { ?>
						<span class="help-block error"><?= $error_telephone; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="order_id"><b class="required">*</b> <?= $lang_entry_order_id; ?></label>
					<div class="col-sm-6">
						<input type="text" name="order_id" value="<?= $order_id; ?>" class="form-control" placeholder="<?= $lang_entry_order_id; ?>"  id="order_id" required>
						<?php if ($error_order_id) { ?>
						<span class="help-block error"><?= $error_order_id; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="date_ordered"><?= $lang_entry_date_ordered; ?></label>
					<div class="col-sm-6">
						<label class="input-group">
							<input type="text" name="date_ordered" value="<?= $date_ordered; ?>" class="form-control date" id="date_ordered">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend><?= $lang_text_product; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-3" for="product"><b class="required">*</b> <?= $lang_entry_product; ?></label>
					<div class="col-sm-6">
						<input type="text" name="product" value="<?= $product; ?>" class="form-control" placeholder="<?= $lang_entry_product; ?>"  id="product" required>
						<?php if ($error_product) { ?>
						<span class="help-block error"><?= $error_product; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="model"><b class="required">*</b> <?= $lang_entry_model; ?></label>
					<div class="col-sm-6">
						<input type="text" name="model" value="<?= $model; ?>" class="form-control" placeholder="<?= $lang_entry_model; ?>"  id="model" required>
						<?php if ($error_model) { ?>
						<span class="help-block error"><?= $error_model; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="quantity"><?= $lang_entry_quantity; ?></label>
					<div class="col-sm-6">
						<input type="text" name="quantity" value="<?= $quantity; ?>" class="form-control" placeholder="<?= $lang_entry_quantity; ?>"  id="quantity">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3"><b class="required">*</b> <?= $lang_entry_reason; ?></label>
					<div class="col-sm-6">
						<?php foreach ($return_reasons as $return_reason) { ?>
							<div class="radio"><label>
							<?php if ($return_reason['return_reason_id'] == $return_reason_id) { ?>
								<input type="radio" name="return_reason_id" value="<?= $return_reason['return_reason_id']; ?>" checked="">
							<?php } else { ?>
								<input type="radio" name="return_reason_id" value="<?= $return_reason['return_reason_id']; ?>">
							<?php	} ?>
							<?= $return_reason['name']; ?></label></div>
						<?php	} ?>
						<?php if ($error_reason) { ?>
						<span class="help-block error"><?= $error_reason; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3"><?= $lang_entry_opened; ?></label>
					<div class="col-sm-6">
						<?php if ($opened) { ?>
							<div class="radio radio-inline"><label><input type="radio" name="opened" value="1" checked=""> <?= $lang_text_yes; ?></label></div>
						<?php } else { ?>
							<div class="radio radio-inline"><label><input type="radio" name="opened" value="1"> <?= $lang_text_yes; ?></label></div>
						<?php } ?>
						<?php if (!$opened) { ?>
							<div class="radio radio-inline"><label><input type="radio" name="opened" value="0" checked=""> <?= $lang_text_no; ?></label></div>
						<?php } else { ?>
							<div class="radio radio-inline"><label><input type="radio" name="opened" value="0"> <?= $lang_text_no; ?></label></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="comment"><?= $lang_entry_fault_detail; ?></label>
					<div class="col-sm-6">
						<textarea name="comment" rows="4" class="form-control" placeholder="<?= $lang_entry_fault_detail; ?>"  id="comment"><?= $comment; ?></textarea>
					</div>
				</div>
				<?php if ($text_agree): ?>
				<div class="form-group">
					<label class="control-label col-sm-3"></label>
					<div class="col-sm-8">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="agree" value="1"<?= $agree ? ' checked' : ''; ?> required><?= $text_agree; ?>
							</label>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<hr>
				<div class="form-group">
					<label class="control-label col-sm-3"><?= $lang_entry_captcha; ?></label>
					<div class="col-sm-6">
						<input type="text" name="captcha" value="<?= $captcha; ?>" class="form-control">
						<div class="help-block">
						<img src="tool/captcha" alt=""></div>
						<?php if ($error_captcha) { ?>
						<span class="help-block error"><?= $error_captcha; ?></span>
						<?php } ?>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<div class="form-actions-inner text-right">
					<?php if($back): ?>
					<a href="<?= $back; ?>" class="btn btn-default pull-left"><?= $lang_button_back; ?></a>
					<?php endif; ?>
					<button type="submit" class="btn btn-primary"><?= $lang_button_continue; ?></button>
				</div>
			</div>
		</form>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>