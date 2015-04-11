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
		<div class="alert alert-warning"><?= $lang_text_description; ?></div>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="control-label col-sm-3" for="to_name"><b class="required">*</b> <?= $lang_entry_to_name; ?></label>
				<div class="col-sm-6">
					<input type="text" name="to_name" value="<?= $to_name; ?>" class="form-control" placeholder="<?= $lang_entry_to_name; ?>"  id="to_name" autofocus required>
					<?php if ($error_to_name) { ?>
						<span class="help-block error"><?= $error_to_name; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="to_email"><b class="required">*</b> <?= $lang_entry_to_email; ?></label>
				<div class="col-sm-6">
					<input type="text" name="to_email" value="<?= $to_email; ?>" class="form-control" placeholder="<?= $lang_entry_to_email; ?>"  id="to_email" required>
					<?php if ($error_to_email) { ?>
						<span class="help-block error"><?= $error_to_email; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="from_name"><b class="required">*</b> <?= $lang_entry_from_name; ?></label>
				<div class="col-sm-6">
					<input type="text" name="from_name" value="<?= $from_name; ?>" class="form-control" placeholder="<?= $lang_entry_from_name; ?>"  id="from_name" required>
					<?php if ($error_from_name) { ?>
						<span class="help-block error"><?= $error_from_name; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="from_email"><b class="required">*</b> <?= $lang_entry_from_email; ?></label>
				<div class="col-sm-6">
					<input type="text" name="from_email" value="<?= $from_email; ?>" class="form-control" placeholder="<?= $lang_entry_from_email; ?>"  id="from_email" required>
					<?php if ($error_from_email) { ?>
						<span class="help-block error"><?= $error_from_email; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3"><b class="required">*</b> <?= $lang_entry_theme; ?></label>
				<div class="col-sm-6">
					<?php foreach ($giftcard_themes as $giftcard_theme) { ?>
						<div class="radio"><label for="giftcard-<?= $giftcard_theme['giftcard_theme_id']; ?>">
						<?php if ($giftcard_theme['giftcard_theme_id'] == $giftcard_theme_id) { ?>
							<input type="radio" name="giftcard_theme_id" value="<?= $giftcard_theme['giftcard_theme_id']; ?>" id="giftcard-<?= $giftcard_theme['giftcard_theme_id']; ?>" checked="">
						<?php } else { ?>
							<input type="radio" name="giftcard_theme_id" value="<?= $giftcard_theme['giftcard_theme_id']; ?>" id="giftcard-<?= $giftcard_theme['giftcard_theme_id']; ?>">
						<?php } ?>
						<?= $giftcard_theme['name']; ?></label></div>
					<?php } ?>
					<?php if ($error_theme) { ?>
						<span class="help-block error"><?= $error_theme; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="message"><?= $lang_entry_message; ?></label>
				<div class="col-sm-6">
					<textarea name="message" class="form-control" placeholder="<?= $lang_text_p_message; ?>"  rows="4" id="message"><?= $message; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="amount"><b class="required">*</b> <?= $entry_amount; ?></label>
				<div class="col-sm-6">
					<input type="text" name="amount" value="<?= $amount; ?>" class="form-control" placeholder="<?= $lang_text_p_amount; ?>"  id="amount" required>
					<?php if ($error_amount) { ?>
						<span class="help-block error"><?= $error_amount; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="checkbox"><label>
						<input type="checkbox" name="agree" value="1"<?= $agree ? ' checked' : ''; ?>><?= $lang_text_agree; ?>
					</label></div>
				</div>
			</div>
			<div class="form-actions">
				<div class="form-actions-inner text-right">
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