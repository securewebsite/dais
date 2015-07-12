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
			<fieldset>
				<legend><?= $lang_text_your_email; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-3" for="email"><?= $lang_entry_email; ?></label>
					<div class="col-sm-6">
						<input type="text" name="email" value="" class="form-control" placeholder="<?= $lang_entry_email; ?>"  autofocus id="email">
						<p class="help-block"><?= $lang_text_email; ?></p>
					</div>
				</div>
				<div class="form-actions">
					<div class="form-actions-inner text-right">
						<a href="<?= $back; ?>" class="btn btn-default pull-left"><?= $lang_button_back; ?></a>
						<button type="submit" class="btn btn-primary"><?= $lang_button_continue; ?></button>
					</div>
				</div>
			</fieldset>
		</form>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>