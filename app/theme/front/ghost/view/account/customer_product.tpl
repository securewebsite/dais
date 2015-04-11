<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<?php foreach ($products as $product) { ?>
			<div class="media">
				<?php if ($product['thumb']) { ?>
					<img class="pull-left media-object img-thumbnail" src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>">
				<?php } ?>
				<div class="pull-right hidden-xs">
					<?php if (!$product['special']) { ?>
						<p class="lead media-heading text-right"><strong><?= $product['price']; ?></strong></p>
					<?php } else { ?>
						<p class="lead media-heading text-right">
							<s class="text-danger"><?= $product['price']; ?></s> <strong><?= $product['special']; ?></strong></p>
					<?php } ?>
					<div class="cart">
						<button type="button" data-customer-product="<?= $product['product_id']; ?>" class="btn btn-warning load-left pull-right">
							<?= str_replace('Cart', '<i title="Cart" class="fa fa-shopping-cart"></i>', $lang_button_cart); ?>
						</button>
					</div>
				</div>
				<div class="media-body">
					<div class="lead media-heading"><?= $product['name']; ?></div>
					<?php if (strlen($product['description']) > 2) { ?>
						<p class="description"><?= $product['description']; ?></p>
					<?php } ?>
					<?php if ($product['rating']) { ?>
						<div class="reviews" title="<?= $product['reviews']; ?>">
						<?php for ($i = 1; $i <= 5; $i++) {
							if ($product['rating'] < $i) {
								echo '<i class="fa fa-star-o"></i>';
							} else {
								echo '<i class="fa fa-star"></i>';
							}
						} ?></div>
					<?php } ?>
				</div>
			</div>
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