<div class="btn-group" title="<?= $lang_heading_title; ?>">
	<a class="btn btn-info" href="<?= $cart; ?>"><i class="fa fa-shopping-cart fa-fw"></i> <span id="cart-total" class="hidden-xs"><?= $text_items; ?></span></a>
	<a class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
	<ul id="cart" class="dropdown-menu dropdown-menu-right">
		<?php if ($giftcards || $products) { ?>
			<?php foreach ($products as $product) { ?>
				<li class="media-cart">
				<div class="media">
					<?php if ($product['thumb']) { ?>
						<a class="pull-left" href="<?= $product['href']; ?>">
							<img class="img-thumbnail media-object" src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>" title="<?= $product['name']; ?>">
						</a>
					<?php } ?>
					<div class="media-body">
						<a href="<?= $product['href']; ?>"><?= $product['name']; ?></a>
						<a href="#" 
							class="pull-right close" 
							data-remove="<?= $product['key']; ?>" 
							data-toggle="tooltip" 
							title="Remove from Cart">
								<span class="fa fa-times"></span>
						</a>
						<?php foreach ($product['option'] as $option) { ?>
							<div class="help"><?= $option['name']; ?> <?= $option['value']; ?></div>
						<?php } ?>
						<br><div class="help"><?= $product['quantity']; ?>&nbsp;x&nbsp;<?= $product['total']; ?></div>
					</div>
				</div>
				</li>
			<?php } ?>
			<?php if ($giftcards) { ?>
				<li class="divider"></li>
				<?php foreach ($giftcards as $giftcard) { ?>
					<li class="media-cart"><?= $giftcard['description']; ?>
						<br><div class="help">1&nbsp;x&nbsp;<?= $giftcard['amount']; ?></div>
					</li>
				<?php } ?>
			<?php } ?>
			<li class="divider"></li>
			<?php foreach ($totals as $total) { ?>
				<li class="media-cart"><b class="pull-right"><?= $total['text']; ?></b><?= $total['title']; ?>:</li>
			<?php } ?>
			<li class="divider"></li>
			<li class="media-cart">
				<div class="btn-group btn-group-justified">
					<div class="btn-group">
						<button type="button" onclick="location='<?= $cart; ?>'" class="btn btn-default"><i class="fa fa-shopping-cart"></i> <?= $lang_text_cart; ?></button>
					</div>
					<div class="btn-group">
						<button type="button" onclick="location='<?= $checkout; ?>'" class="btn btn-default"><?= $lang_text_checkout; ?></button>
					</div>
				</div>
			</li>
		<?php } else { ?>
			<li class="media-cart"><span class="text-muted"><?= $lang_text_empty; ?></span></li>
		<?php } ?>
	</ul>
</div>
