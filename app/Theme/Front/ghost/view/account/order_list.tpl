<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<?php if ($orders) { ?>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th class="text-right hidden-xs"><?= $lang_text_order_id; ?></th>
						<th><?= $lang_text_status; ?></th>
						<th><?= $lang_text_date_added; ?></th>
						<th class="text-right hidden-xs"><?= $lang_text_products; ?></th>
						<th class="hidden-xs"><?= $lang_text_customer; ?></th>
						<th class="text-right"><?= $lang_text_total; ?></th>
						<th class="text-right"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($orders as $order) { ?>
						<tr>
							<td class="text-right hidden-xs">#<?= $order['order_id']; ?></td>
							<td><?= $order['status']; ?></td>
							<td><?= $order['date_added']; ?></td>
							<td class="text-right hidden-xs"><?= $order['products']; ?></td>
							<td class="hidden-xs"><?= $order['name']; ?></td>
							<td class="text-right"><?= $order['total']; ?></td>
							<td class="text-right">
								<a class="btn btn-default" href="<?= $order['href']; ?>"><i class="fa fa-search-plus"></i><span class="hidden-xs"> <?= $lang_button_view; ?></span></a>&nbsp;
								<a class="btn btn-default hidden-xs" href="<?= $order['reorder']; ?>"><i class="fa fa-repeat"></i> <?= $lang_button_reorder; ?></a>
							</td>
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