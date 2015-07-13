<?= $header; ?>
<?php if ($success) { ?>
<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $success; ?></div>
<?php } ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<?php if ($products) { ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="text-center"><?= $lang_column_image; ?></th>
						<th><?= $lang_column_name; ?></th>
						<th class="hidden-xs"><?= $lang_column_model; ?></th>
						<th class="text-right hidden-xs"><?= $lang_column_stock; ?></th>
						<th class="text-right"><?= $lang_column_price; ?></th>
						<th class="text-right"><?= $lang_column_action; ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($products as $product) { ?>
						<tr id="wishlist-row<?= $product['product_id']; ?>">
							<td class="text-center"><?php if ($product['thumb']) { ?>
								<a href="<?= $product['href']; ?>"><img class="img-thumbnail" src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>" title="<?= $product['name']; ?>"></a>
							<?php } ?></td>
							<td><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a></td>
							<td class="hidden-xs"><?= $product['model']; ?></td>
							<td class="text-right hidden-xs"><?= $product['stock']; ?></td>
							<td class="text-right"><?php if ($product['price']) { ?>
								<?php if (!$product['special']) { ?>
									<strong><?= $product['price']; ?></strong>
								<?php } else { ?>
									<s class="text-danger"><?= $product['price']; ?></s> <strong><?= $product['special']; ?></strong>
								<?php } ?>
							<?php } ?></td>
							<td class="text-right">
								<?php if ($product['event_id'] == 0): ?>
								<button type="button" 
									data-cart="<?= $product['product_id']; ?>" 
									class="btn btn-primary load-left">
									<?= str_replace('Cart', '<i title="Cart" class="fa fa-shopping-cart"></i>', $lang_button_cart); ?>
								</button>
								<?php else: ?>
								<button type="button" 
									data-cart="<?= $product['product_id']; ?>" 
									data-event="<?= $product['event_id']; ?>" 
									class="btn btn-primary load-left">
									<?= str_replace('Event', '<i title="View Event" class="fa fa-shopping-users"></i>', $lang_button_view_event); ?>
								</button>
								<?php endif; ?>
								<a class="btn btn-danger" href="<?= $product['remove']; ?>" data-toggle="tooltip" title="<?= $lang_button_remove; ?>"><i class="fa fa-trash-o"></i></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
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