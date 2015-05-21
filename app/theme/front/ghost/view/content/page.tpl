<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $heading_title; ?></h1></div>
		<div class="row">
			<div class="col-sm-12">
				<?= $description; ?>
			</div>
		</div>
		<hr>
		<div class="row">
			<?php if ($tags): ?>
			<div class="col-sm-6">
				<span class="fa fa-tags"></span> <?= $lang_text_tags; ?> 
			<?php foreach($tags as $tag): ?>
				<a href="<?= $tag['href']; ?>" class="label label-info"><?= $tag['name']; ?></a> 
			<?php endforeach; ?>
			</div>
			<div class="col-sm-6">
			<?= $share_bar; ?>
			</div>
			<?php else: ?>
			<div class="col-sm-12">
			<?= $share_bar; ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="form-actions">
			<div class="form-actions-inner text-right">
				<a href="<?= $continue; ?>" class="btn btn-primary"><?= $lang_button_continue; ?></a>
			</div>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>