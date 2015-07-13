<?php if ($products) { ?>
<h3 class="text-muted"><?= $lang_heading_title; ?></h3>
<?php 
	$class_prefix 	= '';
	$btn_class 		= 'btn btn-warning';
	$btn_view 		= false;
	$wishlist 		= false;
	
	if (!empty($lang_button_wishlist) && !empty($lang_button_compare)):
		$wishlist = true;
	endif;
	
	if (!empty($image_width)):
		if ($image_width < 100):
			$image_width = 100;
		endif;
		
		if ($image_width < 140):
			$class_prefix = 'slim-';
			$btn_class .= ' btn-sm';
		endif;
			
		if ($image_width < 202):
			$wishlist = false;
		endif;
		
		$width = ' style="width:' . $image_width . 'px;"';
	else:
		$width = '';
	endif; ?>
	
	<div class="<?= $class_prefix; ?>row product-block">
		<?php foreach ($products as $product) { ?>
			<div class="thumbnail-grid <?= $class_prefix; ?>col-sm-2"<?= $width; ?>>
				<?php if ($product['thumb']) { ?>
					<a href="<?= $product['href']; ?>"><img class="img-thumbnail" src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>"></a>
				<?php } ?>
				<div class="name"><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a></div>
				<?php if (!$product['special']) { ?>
					<div class="price"><strong><?= $product['price']; ?></strong></div>
				<?php } else { ?>
					<div class="price"><s class="text-danger"><?= $product['price']; ?></s> <strong><?= $product['special']; ?></strong></div>
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
				<div class="cart">
				<?php if (!$wishlist): ?>
					<?php if ($product['event_id'] == 0): ?>
						<button type="button" 
							data-cart="<?= $product['product_id']; ?>" 
							data-toggle="tooltip" title="<?= $lang_button_cart; ?>" class="<?= $btn_class; ?>">
							<i class="fa fa-shopping-cart"></i>
						</button>
					<?php else: ?>
						<button type="button" 
							data-cart="<?= $product['product_id']; ?>" 
							data-event="<?= $product['event_id']; ?>" 
							data-toggle="tooltip" title="<?= $lang_button_view_event; ?>" class="<?= $btn_class; ?>">
							<i class="fa fa-users"></i>
						</button>
					<?php endif; ?>
				<?php else: ?>
					<?php if ($product['event_id'] == 0): ?>
						<button type="button" data-cart="<?= $product['product_id']; ?>" class="<?= $btn_class; ?>">
							<?= str_replace('Cart', '<i title="Cart" class="fa fa-shopping-cart"></i>', $lang_button_cart); ?>
						</button>
					<?php else: ?>
						<button type="button" data-cart="<?= $product['product_id']; ?>" data-event="<?= $product['event_id']; ?>" class="<?= $btn_class; ?>">
							<?= str_replace('Event', '<i title="View Event" class="fa fa-users"></i>', $lang_button_view_event); ?>
						</button>
					<?php endif; ?>
				<?php endif; ?>
					<a class="btn btn-danger" data-toggle="tooltip" title="<?= $lang_button_wishlist; ?>" onclick="addToWishList('<?= $product['product_id']; ?>');">
						<i class="fa fa-heart"></i>
					</a>
					<a class="btn btn-info" data-toggle="tooltip" title="<?= $lang_button_compare; ?>" onclick="addToCompare('<?= $product['product_id']; ?>');">
						<i class="fa fa-exchange"></i>
					</a>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>