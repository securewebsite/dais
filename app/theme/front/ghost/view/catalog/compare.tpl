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
			<h4><?= $lang_text_product; ?></h4>
			<table class="table table-striped">
				<tbody>
					<tr>
						<td><?= $lang_text_image; ?></td>
						<?php foreach ($products as $product) { ?>
							<td><?php if ($products[$product['product_id']]['thumb']) { ?>
							<img class="img-thumbnail" src="<?= $products[$product['product_id']]['thumb']; ?>" alt="<?= $products[$product['product_id']]['name']; ?>">
							<?php } ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_name; ?></td>
						<?php foreach ($products as $product) { ?>
						<td class="name"><a href="<?= $products[$product['product_id']]['href']; ?>"><?= $products[$product['product_id']]['name']; ?></a></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_price; ?></td>
						<?php foreach ($products as $product) { ?>
						<td><?php if ($products[$product['product_id']]['price']) { ?>
							<?php if (!$products[$product['product_id']]['special']) { ?>
								<?= $products[$product['product_id']]['price']; ?>
							<?php } else { ?>
								<s class="text-danger"><?= $products[$product['product_id']]['price']; ?></s> <?= $products[$product['product_id']]['special']; ?>
							<?php } ?>
							<?php } ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_model; ?></td>
						<?php foreach ($products as $product) { ?>
						<td><?= $products[$product['product_id']]['model']; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_manufacturer; ?></td>
						<?php foreach ($products as $product) { ?>
						<td><?= $products[$product['product_id']]['manufacturer']; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_availability; ?></td>
						<?php foreach ($products as $product) { ?>
						<td><?= $products[$product['product_id']]['availability']; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_rating; ?></td>
						<?php foreach ($products as $product) { ?>
						<td><i class="stars-<?= $products[$product['product_id']]['rating']; ?>" title="<?= $products[$product['product_id']]['reviews']; ?>"></i>
							<?php if ($products[$product['product_id']]['rating']) { ?>
							&nbsp;<span class="help"><?= $products[$product['product_id']]['reviews']; ?></span>
							<?php } ?>
							</td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_summary; ?></td>
						<?php foreach ($products as $product) { ?>
						<td><?= $products[$product['product_id']]['description']; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_weight; ?></td>
						<?php foreach ($products as $product) { ?>
						<td><?= $products[$product['product_id']]['weight']; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td><?= $lang_text_dimension; ?></td>
						<?php foreach ($products as $product) { ?>
						<td><?= $products[$product['product_id']]['length']; ?> x <?= $products[$product['product_id']]['width']; ?> x <?= $products[$product['product_id']]['height']; ?></td>
						<?php } ?>
					</tr>
					<?php foreach ($attribute_groups as $attribute_group) { ?>
						<tr>
							<th colspan="<?= count($products) + 1; ?>"><?= $attribute_group['name']; ?></th>
						</tr>
						<?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
							<tr>
								<td><?= $attribute['name']; ?></td>
								<?php foreach ($products as $product) { ?>
								<?php if (isset($products[$product['product_id']]['attribute'][$key])) { ?>
								<td><?= $products[$product['product_id']]['attribute'][$key]; ?></td>
								<?php } else { ?>
								<td></td>
								<?php } ?>
								<?php } ?>
							</tr>
						<?php } ?>
					<?php } ?>
					<tr>
						<td></td>
						<?php foreach ($products as $product) { ?>
							<td class="text-center">
								<a class="btn btn-danger" href="<?= $product['remove']; ?>"><i class="fa fa-trash-o"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a>
								<?php if ($product['event_id'] == 0): ?>
								<button type="button" 
									data-cart="<?= $product['product_id']; ?>" 
									class="btn btn-primary"><?= str_replace('Cart', '<i title="Cart" class="fa fa-shopping-cart"></i>', $lang_button_cart); ?>
								</button>
								<?php else: ?>
								<button type="button" 
									data-cart="<?= $product['product_id']; ?>" 
									data-event="<?= $product['event_id']; ?>" 
									class="btn btn-primary"><?= str_replace('Event', '<i title="View Event" class="fa fa-users"></i>', $lang_button_view_event); ?>
								<?php endif; ?>
							</td>
						<?php } ?>
					</tr>
				</tbody>
			</table>
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