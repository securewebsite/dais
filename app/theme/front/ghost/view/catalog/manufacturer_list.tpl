<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<?php if ($categories) { ?>
			<p><?= $lang_text_index; ?>
			<?php foreach ($categories as $category) { ?>
				<a class="btn btn-primary btn-xs" href="catalog/manufacturer#<?= $category['name']; ?>"><strong><?= $category['name']; ?></strong></a>
			<?php } ?></p>
			<?php foreach ($categories as $category) { ?>
				<hr>
				<div class="row" id="<?= $category['name']; ?>">
					<div class="col-sm-1"><b><?= $category['name']; ?></b></div>
					<div class="col-sm-11">
						<?php if ($category['manufacturer']) { ?>
							<div class="row">
							<?php foreach ($category['manufacturer'] as $manufacturer) { ?>
								<div class="col-sm-2"><a href="<?= $manufacturer['href']; ?>"><?= $manufacturer['name']; ?></a></div>
							<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="alert alert-warning"><?= $lang_text_empty; ?></div>
			<div class="form-actions">
				<div class="form-actions-inner text-right">
					<a href="<?= $continue; ?>" class="btn btn-primary"><?= $lang_button_continue; ?></a>
				</div>
			</div>
		<?php } ?>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>