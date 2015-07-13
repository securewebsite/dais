<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<?php if ($returns) { ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="text-right hidden-xs"><?= $lang_text_return_id; ?></th>
						<th><?= $lang_text_status; ?></th>
						<th class="hidden-xs"><?= $lang_text_date_added; ?></th>
						<th class="text-right"><?= $lang_text_order_id; ?></th>
						<th><?= $lang_text_customer; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($returns as $return) { ?>
					<tr>
						<td class="text-right hidden-xs">#<?= $return['return_id']; ?></td>
						<td><?= $return['status']; ?></td>
						<td class="hidden-xs"><?= $return['date_added']; ?></td>
						<td class="text-right"><?= $return['order_id']; ?></td>
						<td><?= $return['name']; ?></td>
						<td class="text-right"><a class="btn btn-default" href="<?= $return['href']; ?>"><i class="fa fa-search-plus"></i><span class="hidden-xs"> <?= $lang_button_view; ?></span></a></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
		<?php } else { ?>
			<div class="alert alert-warning"><?= $lang_text_empty; ?></div>
		<?php } ?>
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