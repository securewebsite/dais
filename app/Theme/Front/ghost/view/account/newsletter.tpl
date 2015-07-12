<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="control-label col-sm-3"><?= $lang_entry_newsletter; ?></label>
				<div class="col-sm-6">
					<?php if ($newsletter) { ?>
						<div class="radio radio-inline">
						<label><input type="radio" name="newsletter" value="1" checked=""><?= $lang_text_yes; ?></label>	</div>
						<div class="radio radio-inline">
						<label><input type="radio" name="newsletter" value="0"><?= $lang_text_no; ?></label>	</div>
					<?php } else { ?>
						<div class="radio radio-inline">
						<label><input type="radio" name="newsletter" value="1"><?= $lang_text_yes; ?></label>	</div>
						<div class="radio radio-inline">
						<label><input type="radio" name="newsletter" value="0" checked=""><?= $lang_text_no; ?></label>	</div>
					<?php } ?>
				</div>
			</div>
			<div class="form-actions">
				<div class="form-actions-inner text-right">
					<a href="<?= $back; ?>" class="btn btn-default pull-left"><?= $lang_button_back; ?></a>
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