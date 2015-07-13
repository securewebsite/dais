<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend><?= $lang_text_password; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-3" for="password"><b class="required">*</b> <?= $lang_entry_password; ?></label>
					<div class="col-sm-6">
						<input type="password" name="password" value="<?= $password; ?>" class="form-control" placeholder="<?= $lang_entry_password; ?>"  autofocus id="password" required>
						<?php if ($error_password) { ?>
						<span class="help-block error"><?= $error_password; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="confirm"><b class="required">*</b> <?= $lang_entry_confirm; ?></label>
					<div class="col-sm-6">
						<input type="password" name="confirm" value="<?= $confirm; ?>" class="form-control" placeholder="<?= $lang_entry_confirm; ?>"  id="confirm" required>
						<?php if ($error_confirm) { ?>
						<span class="help-block error"><?= $error_confirm; ?></span>
						<?php } ?>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<div class="form-actions-inner text-right">
					<a href="<?= $cancel; ?>" class="btn btn-default pull-left"><?= $lang_button_cancel; ?></a>
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