<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="text-right hidden-xs"><?= $lang_text_order; ?></th>
					<th><?= $lang_text_size; ?></th>
					<th><?= $lang_text_name; ?></th>
					<th class="text-right hidden-xs"><?= $lang_text_date_added; ?></th>
					<th class="text-right"><?= $lang_text_remaining; ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($downloads as $download) { ?>
				<tr>
					<td class="text-right hidden-xs"><?= $download['order_id']; ?></td>
					<td><?= $download['size']; ?></td>
					<td><?= $download['name']; ?></td>
					<td class="text-right hidden-xs"><?= $download['date_added']; ?></td>
					<td class="text-right"><?= $download['remaining']; ?></td>
					<td class="text-right"><?php if ($download['remaining'] > 0) { ?>
						<a class="btn btn-default" href="<?= $download['href']; ?>"><i class="fa fa-download"></i><span class="hidden-xs"> <?= $lang_button_download; ?></span></a>
					<?php } ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
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