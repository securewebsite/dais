<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<?php if ($products) { ?>
			<div class="btn-toolbar">
				<a href="<?= $compare; ?>" class="btn btn-default hidden-xs" id="compare-total"><?= $text_compare; ?></a>
				<div class="btn-group pull-right">
					<button type="button" class="btn btn-default" data-toggle="dropdown"><?= $lang_text_limit; ?></button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
					<ul class="dropdown-menu" id="limit">
						<?php foreach ($limits as $limits) { ?>
							<?php if ($limits['value'] == $limit) { ?>
								<li class="active"><a href="<?= $limits['href']; ?>"><?= $limits['text']; ?></a></li>
							<?php } else { ?>
								<li><a href="<?= $limits['href']; ?>"><?= $limits['text']; ?></a></li>
							<?php } ?>
						<?php } ?>
					</ul>
				</div>
				<div class="btn-group pull-right">
					<button type="button" class="btn btn-default" data-toggle="dropdown"><?= $lang_text_sort; ?></button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" id="sort">
						<?php foreach ($sorts as $sorts) { ?>
							<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
								<li class="active"><a href="<?= $sorts['href']; ?>"><?= $sorts['text']; ?></a></li>
							<?php } else { ?>
								<li><a href="<?= $sorts['href']; ?>"><?= $sorts['text']; ?></a></li>
							<?php } ?>
						<?php } ?>
					</ul>
				</div>
				<div class="btn-group pull-right hidden-xs" data-toggle="buttons">
					<label class="btn btn-default" id="display-list" title="<?= $lang_text_list; ?>"><input type="radio" name="display" value="list"><i class="fa fa-list"></i></label>
					<label class="btn btn-default" id="display-grid" title="<?= $lang_text_grid; ?>"><input type="radio" name="display" value="grid"><i class="fa fa-th"></i></label>
				</div>
			</div>
			<hr>
			<?php if ($display == 'grid'):
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
			<?php else: ?>
				<?php foreach ($products as $product) { ?>
					<div class="media">
						<?php if ($product['thumb']) { ?>
							<a class="pull-left" href="<?= $product['href']; ?>"><img class="media-object img-thumbnail" src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>"></a>
						<?php } ?>
						<div class="pull-right hidden-xs">
							<?php if (!$product['special']) { ?>
								<p class="lead media-heading text-right"><strong><?= $product['price']; ?></strong></p>
							<?php } else { ?>
								<p class="lead media-heading text-right">
									<s class="text-danger"><?= $product['price']; ?></s> <strong><?= $product['special']; ?></strong></p>
							<?php } ?>
							<div class="cart">
								<?php if ($product['event_id'] == 0): ?>
									<button type="button" data-cart="<?= $product['product_id']; ?>" class="btn btn-warning load-left pull-right">
										<?= str_replace('Cart', '<i title="Cart" class="fa fa-shopping-cart"></i>', $lang_button_cart); ?>
									</button>
								<?php else: ?>
									<button type="button" data-cart="<?= $product['product_id']; ?>" data-event="<?= $product['event_id']; ?>" class="btn btn-warning load-left pull-right">
										<?= str_replace('Event', '<i title="View Event" class="fa fa-users"></i>', $lang_button_view_event); ?>
									</button>
								<?php endif; ?>
							</div>
							<div class="pull-right" style="margin-top:5px;">
								<a class="btn btn-danger" data-toggle="tooltip" title="<?= $lang_button_wishlist; ?>" onclick="addToWishList('<?= $product['product_id']; ?>');">
									<i class="fa fa-heart"></i>
								</a>
								<a class="btn btn-info" data-toggle="tooltip" title="<?= $lang_button_compare; ?>" onclick="addToCompare('<?= $product['product_id']; ?>');">
									<i class="fa fa-exchange"></i>
								</a>
							</div>
						</div>
						<div class="media-body">
							<div class="lead media-heading"><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a></div>
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
			<?php endif; ?>
			<div class="pagination"><?= str_replace('....','',$pagination); ?></div>
		<?php } else { ?>
			<div class="alert alert-warning"><?= $lang_text_empty; ?></div>
		<?php }?>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>