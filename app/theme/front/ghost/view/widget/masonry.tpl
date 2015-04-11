<h3 class="text-muted"><?= $heading_title; ?></h3>
<?php if ($products) { ?>
<div class="<?= $class_row; ?> product-<?= $class_1; ?>">
<?php foreach ($products as $product) { ?>
	<div class="brick <?= $class_col; ?>">
		<div class="<?= $class_2; ?>">
			<?php if ($product['thumb']) { ?>
				<a class="<?= $class_3; ?>" href="<?= $product['href']; ?>"><img src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>"></a>
			<?php } ?>
			<div class="caption">
				<div class="name"><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a></div>
				<?php if ($product['description']) { ?>
					<div class="description"><?= $product['description']; ?></div>
				<?php } ?>
				<?php if (!$product['special']) { ?>
					<div class="price"><strong class="label label-info"><?= $product['price']; ?></strong></div>
				<?php } else { ?>
					<div class="price"><small><s class="text-danger"><?= $product['price']; ?></s></small> <strong class="label label-info"><?= $product['special']; ?></strong></div>
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
				<?php if ($button) { ?>
					<div class="cart">
						<?php if ($product['event_id'] == 0): ?>
							<button type="button" 
								data-cart="<?= $product['product_id']; ?>" 
								data-toggle="tooltip" 
								title="<?= $lang_text_cart_add; ?>" 
								class="btn btn-warning"><?= $lang_button_add_cart; ?>
							</button>
						<?php else: ?>
							<button type="button" 
								data-cart="<?= $product['product_id']; ?>" 
								data-event="<?= $product['event_id']; ?>" 
								data-toggle="tooltip" 
								title="<?= $lang_text_view_event; ?>" 
								class="btn btn-warning"><?= $lang_button_view_event; ?>
							</button>
						<?php endif; ?>
						<?php if ($span > 1) { ?>
						<a class="btn btn-danger" 
							data-toggle="tooltip" 
							title="<?= $lang_button_wishlist; ?>" 
							onclick="addToWishList('<?= $product['product_id']; ?>');"><i class="fa fa-heart"></i>
						</a>
						<a class="btn btn-info" 
							data-toggle="tooltip" 
							title="<?= $lang_button_compare; ?>" 
							onclick="addToCompare('<?= $product['product_id']; ?>');"><i class="fa fa-exchange"></i>
						</a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>
<?php } else { ?>
	<div class="alert alert-warning"><?= $text_empty; ?></div>
<?php } ?>
