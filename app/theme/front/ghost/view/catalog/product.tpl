<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="row">
			<?php $image_span = 0; if ($thumb || $images) { 
				if ($config_image_thumb_width > 450 && ($span < 10)) { $image_span = 6;
				} elseif ($config_image_thumb_width > 350) { $image_span = 5;
				} elseif ($config_image_thumb_width > 250) { $image_span = 3;
				} elseif ($config_image_thumb_width > 150) { $image_span = 2;
				} else { $image_span = 1; } ?>
				<div id="gallery" class="col-sm-<?= $image_span; ?>" data-toggle="modal-gallery" data-target="#modal-gallery">
					<div class="slim-row spacer" id="links">
						<?php if ($thumb) { ?>
							<div class="slim-col-sm-12"><a class="thumbnail" href="<?= $popup; ?>" title="<?= $heading_title; ?>" data-gallery><img src="<?= $thumb; ?>" title="<?= $heading_title; ?>" alt="<?= $heading_title; ?>" itemprop="image" id="image"></a></div>
						<?php } ?>
						<?php foreach ($images as $image) { ?>
							<div class="slim-col-xs-4 slim-col-sm-3"><a class="thumbnail" href="<?= $image['popup']; ?>" title="<?= $heading_title; ?>" data-gallery><img src="<?= $image['thumb']; ?>" title="<?= $heading_title; ?>" alt="<?= $heading_title; ?>"></a></div>
						<?php } ?>
					</div>
					<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-slide-error-class="icon icon-ban" data-close-class="blueimp-close">
						<div class="slides"></div>
						<a class="prev" href="#">&lsaquo;</a>
						<a class="next" href="#">&rsaquo;</a>
						<a class="blueimp-close" href="#">&times;</a>
					</div>
				</div>
			<?php } ?>
			<div class="col-sm-<?= 12 - $image_span; ?>">
			<h1 itemprop="name"><?= $heading_title; ?></h1>
			<form id="product-info">
				<?php if ($price) { ?>
				<p class="price" title="<?= $lang_text_price; ?>">
					<?php if (!$special) { ?>
						<span class="lead text-info"><?= $price; ?></span>
					<?php } else { ?>
						<s class="text-danger"><?= $price; ?></s> <span class="lead"><?= $special; ?></span>
					<?php } ?>
					<?php if ($points) { ?>
						<i class="muted"><?= $lang_text_points; ?> <?= $points; ?></i>
					<?php } ?>
				</p>
				<?php if ($tax && $tax != $price && $tax != $special) { ?>
					<p class="help"><?= $lang_text_tax; ?> <?= $tax; ?></p>
				<?php } ?>
				<?php if ($discounts) { ?>
					<ul>
					<?php foreach ($discounts as $discount) { ?>
						<li><?= sprintf($lang_text_discount, $discount['quantity'], $discount['price']); ?></li>
					<?php } ?>
					</ul>
				<?php } ?>
				<br>
				<?php } ?>
				<?php foreach ($options as $option) { ?>
				<div class="form-group" id="option-<?= $option['product_option_id']; ?>">
					<label for="opt<?= $option['product_option_id']; ?>"><?= $option['required'] ? '<b class="required">*</b> ' : ''; echo $option['name']; ?>:</label>
					<?php if ($option['type'] == 'select') { ?>
						<select name="option[<?= $option['product_option_id']; ?>]" class="form-control" id="opt<?= $option['product_option_id']; ?>">
							<option value=""><?= $lang_text_select; ?></option>
							<?php foreach ($option['option_value'] as $option_value) { ?>
								<option value="<?= $option_value['product_option_value_id']; ?>"><?= $option_value['name']; echo ($option_value['price']) ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''; ?></option>
							<?php } ?>
						</select>
					<?php } elseif ($option['type'] == 'radio') { ?>
						<div class="list-group">
						<?php foreach ($option['option_value'] as $option_value) { ?>
							<div class="radio">
							<label style="display:block;">
								<input type="radio" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option_value['product_option_value_id']; ?>" id="option-value-<?= $option_value['product_option_value_id']; ?>"> <?= $option_value['name']; echo $option_value['price'] ? '<b class="pull-right badge badge-info">' . $option_value['price_prefix'] . $option_value['price'] . '</b>' : ''; ?>
								
							</label>
							</div>
						<?php } ?>
						</div>
					<?php } elseif ($option['type'] == 'checkbox') { ?>
						<div class="list-group">
						<?php foreach ($option['option_value'] as $option_value) { ?>
							<div class="checkbox">
							<label style="display:block;">
							<input type="checkbox" name="option[<?= $option['product_option_id']; ?>][]" value="<?= $option_value['product_option_value_id']; ?>" id="option-value-<?= $option_value['product_option_value_id']; ?>"> <?= $option_value['name']; echo $option_value['price'] ? '<b class="pull-right badge badge-info">' . $option_value['price_prefix'] . $option_value['price'] . '</b>' : ''; ?></label>
							</div>
						<?php } ?>
						</div>
					<?php } elseif ($option['type'] == 'image') { ?>
						<?php foreach ($option['option_value'] as $option_value) { ?>
							<label>
								<img class="img-polaroid" src="<?= $option_value['image']; ?>" alt="<?= $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>">
								<div class="radio">
									<input type="radio" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option_value['product_option_value_id']; ?>">
									<?= $option_value['name']; echo $option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''; ?>
								</div>
							</label>
						<?php } ?>
					<?php } elseif ($option['type'] == 'text') { ?>
						<input type="text" class="form-control" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['option_value']; ?>" id="opt<?= $option['product_option_id']; ?>">
					<?php } elseif ($option['type'] == 'textarea') { ?>
						<textarea name="option[<?= $option['product_option_id']; ?>]" class="form-control" id="opt<?= $option['product_option_id']; ?>" rows="4"><?= $option['option_value']; ?></textarea>
					<?php } elseif ($option['type'] == 'file') { ?>
						<input type="button" class="btn btn-default" value="<?= $lang_button_upload; ?>" id="button-option-<?= $option['product_option_id']; ?>" class="btn btn-default"><input type="hidden" name="option[<?= $option['product_option_id']; ?>]" value="">
					<?php } elseif ($option['type'] == 'date') { ?>
						<label class="input-group">
							<input type="text" class="form-control date" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['option_value']; ?>" id="opt<?= $option['product_option_id']; ?>" data-date-weekstart="1" data-start-view="2" data-date-today-btn="1" data-min-view="2" data-date-format="yyyy-mm-dd" autocomplete="off">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</label>
					<?php } elseif ($option['type'] == 'datetime') { ?>
						<label class="input-group">
							<input type="text" class="form-control date" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['option_value']; ?>" id="opt<?= $option['product_option_id']; ?>" data-show-meridian="1" data-date-today-btn="1" data-min-view="0" data-date-format="yyyy-mm-dd hh:mm" autocomplete="off">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</label>
					<?php } elseif ($option['type'] == 'time') { ?>
						<label class="input-group time">
							<input type="text" class="form-control date" name="option[<?= $option['product_option_id']; ?>]" value="<?= $option['option_value']; ?>" id="opt<?= $option['product_option_id']; ?>" data-max-view="1" data-start-view="1" data-show-meridian="1" data-min-view="0" data-date-format="hh:ii" autocomplete="off">
							<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
						</label>
					<?php } ?>
				</div>
				<?php } ?>
				<?php if ($recurrings) { ?>
				<div class="form-group">
					<label for="recurring_id"><span class="required">*</span> <?= $lang_text_payment_recurring ?></label><br>
					<select name="recurring_id" class="form-control">
						<option value=""><?= $lang_text_select; ?></option>
						<?php foreach ($recurrings as $recurring) { ?>
						<option value="<?= $recurring['recurring_id'] ?>"><?= $recurring['name'] ?></option>
						<?php } ?>
					</select>
				<div class="help-block" id="recurring-description"></div>
				</div>
				<?php } ?>
				<input type="hidden" name="product_id" value="<?= $product_id; ?>">
				<?php if (!isset($available) || ($available > 0 && !$unavailable && !$registered)): ?>
				<div class="well well-lg">
					<?php if ($minimum > 1) { ?>
						<p class="help"><?= $text_minimum; ?></p>
					<?php } ?>
					<div class="form-inline">
						<label for="quantity"><?= $lang_text_qty; ?></label>
						<input type="number" name="quantity" id="quantity" class="form-control" value="<?= $minimum; ?>" min="1" autocomplete="off">
						<button type="button" id="button-cart" class="btn btn-warning btn-lg"><?= $lang_button_cart; ?> <i class="fa fa-shopping-cart"></i></button>
					</div>
					<div class="wishlist">
						<a class="btn btn-danger" 
							data-toggle="tooltip" 
							title="<?= $lang_button_wishlist; ?>" 
							onclick="addToWishList('<?= $product_id; ?>');">
							<i class="fa fa-heart"></i>
						</a>
						<a class="btn btn-info" 
							data-toggle="tooltip" 
							title="<?= $lang_button_compare; ?>" 
							onclick="addToCompare('<?= $product_id; ?>');">
							<i class="fa fa-exchange"></i>
						</a>
					</div>
				</div>
				<?php else: ?>
				<?php if ($registered): ?>
				<div class="alert alert-info"><?= $lang_text_already_registered; ?></div>
				<?php else: ?>
				<?php if (!$unavailable): ?>
				<?php if ($lang_button_waitlist): ?>
				<div id="wait-response">
				<?= $text_unavailable_info; ?>
					<button type="button" value="" id="button-waitlist" class="btn btn-warning btn-lg">
						<i class="fa fa-sign-in"></i> <?= $lang_button_waitlist; ?></button>
				</div>
				<?php elseif ($text_already_on): ?>
				<div class="alert alert-info"><?= $lang_text_already_on; ?></div>
				<?php endif; ?>
				<?php else: ?>
				<div class="alert alert-danger"><?= $lang_text_account_needed; ?></div>
				<?php endif; ?>
				<?php endif; ?>
				<?php endif; ?>
				<?php if ($tags) { ?>
					<p><span class="fa fa-tags"></span> <?= $lang_text_tags; ?> 
					<?php foreach($tags as $tag): ?>
						<a href="<?= $tag['href']; ?>" class="label label-info"><?= $tag['name']; ?></a> 
					<?php endforeach; ?>
					</p>
				<?php } ?>
			</form>
			<hr>
			<ul class="list-inline btn-social clearfix">
				<li class="pull-left share-bar">
					<a href="http://www.facebook.com/sharer.php?u=<?= $social_href; ?>" 
						class="social-share facebook" 
						data-width="550" 
						data-height="275"><?= $lang_share_facebook; ?></a>
					<a href="http://twitter.com/share?url=<?= $social_href; ?>&text=<?= $social_desc; ?>" 
						class="social-share twitter" 
						data-width="550" 
						data-height="275"><?= $lang_share_twitter; ?></a>
					<a href="https://plus.google.com/share?url=<?= $social_href; ?>" 
						class="social-share google" 
						data-width="550" 
						data-height="275"><?= $lang_share_google; ?></a>
					<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?= $social_href; ?>" 
						class="social-share linkedin" 
						data-width="550" 
						data-height="502"><?= $lang_share_linkedin; ?></a>
					<a href="http://pinterest.com/pin/create/button/?url=<?= $social_href; ?>&media=<?= urlencode($popup); ?>&description=<?= $social_desc; ?>" 
						
							class="social-share pinterest" 
							data-width="725" 
							data-height="300"><?= $lang_share_pinterest; ?></a>
					<a href="http://www.tumblr.com/share/link?url=<?= $social_href; ?>&name=<?= $heading_title; ?>" 
						class="social-share tumblr" 
						data-width="550" 
						data-height="275"><?= $lang_share_tumblr; ?></a>
					<!--<a href="http://reddit.com/submit?url=<?= $social_href; ?>&title=<?= $heading_title; ?>" 
						class="social-share reddit" 
						data-width="850" 
						data-height="425"><?= $lang_share_reddit; ?></a>-->
					<a href="http://www.digg.com/submit?url=<?= $social_href; ?>" 
						class="social-share digg" 
						data-width="760" 
						data-height="315"><?= $lang_share_digg; ?></a>
					<a href="http://www.stumbleupon.com/submit?url=<?= $social_href; ?>&title=<?= $heading_title; ?>" 
						class="social-share stumble" 
						data-width="845" 
						data-height="550"><?= $lang_share_stumble; ?></a>
					<a href="https://delicious.com/save?v=5&provider=<?= $social_site; ?>&noui&jump=close&url=<?= $social_href; ?>&title=<?= $heading_title; ?>" 
						class="social-share delicious" 
						data-width="550" 
						data-height="550"><?= $lang_share_delicious; ?></a>
					<!--<a href="https://flattr.com/submit/auto?user_id=vince.kronlein&url=<?= $social_href; ?>&title=<?= $heading_title; ?>" 
						class="social-share flattr" 
						data-width="960" 
						data-height="425"><?= $lang_share_flattr; ?></a>-->
				</li>
			</ul>
			<?php if ($review_status) { ?>
				<?php 
					$href = urlencode($config_url . 'catalog/product&product_id=' . $product_id);
					$desc = urlencode($heading_title . "\n" . substr(str_replace("\t", "", strip_tags($description)), 0, 500)."...");
				?>
				<hr>
				<div class="spacer">
					<?php if ($rating) { ?>
					<i class="stars-<?= $rating; ?>" title="<?= $reviews; ?>"></i>&nbsp;&nbsp;
					<?php } ?>
					<a onclick="$('a[href=\'#tab-review\']').click();$('html,body').animate({scrollTop:$('#write-review').offset().top - 100},'slow');"><?= $reviews; ?></a>
					&nbsp;&nbsp;&bull;&nbsp;&nbsp;
					<a onclick="$('a[href=\'#tab-review\']').click();$('html,body').animate({scrollTop:$('#write-review').offset().top - 100},'slow');"><?= $lang_text_write; ?></a>
				</div>
			<?php } ?>
			</div>
		</div>
		<ul class="nav nav-tabs">
			<?php if (isset($event_name)): ?>
				<?php if ($tab_presenter): ?>
					<li class="active"><a href="#tab-event" data-toggle="tab"><?= $lang_tab_event; ?></a></li>
					<li><a href="#tab-presenter" data-toggle="tab"><?= $lang_tab_presenter; ?></a></li>
					<li><a href="#tab-description" data-toggle="tab"><?= $lang_tab_description; ?></a></li>
				<?php else: ?>
					<li class="active"><a href="#tab-event" data-toggle="tab"><?= $lang_tab_event; ?></a></li>
					<li><a href="#tab-description" data-toggle="tab"><?= $lang_tab_description; ?></a></li>
				<?php endif; ?>
			<?php else: ?>
				<li class="active"><a href="#tab-description" data-toggle="tab"><?= $lang_tab_description; ?></a></li>
			<?php endif; ?>
			<li><a href="#tab-attribute" data-toggle="tab"><?= $lang_tab_attribute; ?></a></li>
			<?php if ($review_status): ?>
				<li><a href="#tab-review" data-toggle="tab"><?= $tab_review; ?></a></li>
			<?php endif; ?>
		</ul>
		<div class="tab-content">
			<?php if (isset($event_name)): ?>
				<div id="tab-event" class="tab-pane active">
					<table class="table table-striped">
						<thead>
							<tr>
								<th colspan="2"><?= $event_name; ?></th>
							</tr>
						</thead>
						<tbody>
						<?php if ($telephone): ?>
							<tr>
								<td><?= $lang_text_telephone; ?></td>
								<td><?= $telephone; ?></td>
							</tr>
						<?php endif; ?>
						<tr>
							<td class="col-sm-3"><?= $lang_text_event_date; ?></td>
							<td><?= $event_date; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_event_time; ?></td>
							<td><?= $event_time; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_event_days; ?></td>
							<td>
								<?php foreach ($event_days as $event_day): ?>
									<?= $event_day; ?><br />
								<?php endforeach; ?>
							</td>
						</tr>
						<tr>
							<td><?= $lang_text_event_length; ?></td>
							<td><?= $event_length; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_location; ?></td>
							<td><?= $location; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_seats; ?></td>
							<td><?= $seats; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_available; ?></td>
							<td><?= $available; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_refundable; ?></td>
							<td><?= $refundable; ?></td>
						</tr>
						</tbody>
					</table>
				</div>
				<?php if ($tab_presenter): ?>
					<div id="tab-presenter" class="tab-pane">
						<table class="table table-striped">
							<thead>
								<tr>
									<th colspan="2"><?= $text_presenter_info; ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="col-sm-2"><?= $text_presenter; ?></td>
									<td><?= $presenter; ?></td>
								</tr>
								<tr>
									<td><?= $text_presenter_bio; ?></td>
									<td><?= $presenter_bio; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
				<div id="tab-description" class="tab-pane" itemprop="description">
					<?= $description; ?>
				</div>
			<?php else: ?>
			<div id="tab-description" class="tab-pane active" itemprop="description">
				<?= $description; ?>
			</div>
			<?php endif; ?>
			<div id="tab-attribute" class="tab-pane">
				<table class="table table-striped">
					<thead>
						<tr>
							<th colspan="2"><?= $lang_tab_attribute; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($manufacturer) { ?>
							<tr>
								<td><?= $lang_text_manufacturer; ?></td>
								<td><a href="<?= $manufacturers; ?>"><?= $manufacturer; ?></a></td>
							</tr>
						<?php } ?>
						<tr>
							<td class="col-sm-3"><?= $lang_text_model; ?></td>
							<td><?= $model; ?></td>
						</tr>
						<?php if ($reward) { ?>
							<tr>
								<td><?= $lang_text_reward; ?></td>
								<td><?= $reward; ?></td>
							</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_stock; ?></td>
							<td><?= $stock; ?></td>
						</tr>
					</tbody>
					<?php foreach ($attribute_groups as $attribute_group) { ?>
					<thead>
						<tr>
							<th colspan="2"><?= $attribute_group['name']; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
						<tr>
							<td><?= $attribute['name']; ?></td>
							<td><?= $attribute['text']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
					<?php } ?>
				</table>
			</div>
			<?php if ($review_status) { ?>
				<div id="tab-review" class="tab-pane">
					<div id="review" class="clearfix"></div>
					<fieldset id="write-review">
						<legend><?= $lang_text_write; ?></legend>
						<?php if ($review_allowed): ?>
						<form id="review-form" class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-3"><?= $lang_entry_rating; ?></label>
								<div class="col-sm-6">
									<label style="margin-right:15px;" class="label label-danger"><?= $lang_entry_bad; ?></label>
									<?php for ($i = 1; $i < 6; $i++){ ?>
										<div class="radio radio-inline">
											<label><input type="radio" name="rating" value="<?= $i; ?>"></label>
										</div>
									<?php } ?>
									<label class="label label-success"><?= $lang_entry_good; ?></label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="name"><?= $lang_entry_name; ?></label>
								<div class="col-sm-6">
									<input type="text" name="name" value="" class="form-control" placeholder="<?= $lang_entry_name; ?>"  id="name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="text"><?= $lang_entry_review; ?></label>
								<div class="col-sm-6">
									<textarea name="text" class="form-control" placeholder="<?= $lang_entry_review; ?>"  rows="4" id="text" spellcheck="false"></textarea>
									<div class="help-block"><?= $lang_text_note; ?></div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3"><?= $lang_entry_captcha; ?></label>
								<div class="col-sm-6">
									<input type="text" name="captcha" value="" class="form-control">
									<p class="help-block"><img src="tool/captcha" alt="" id="captcha"></p>
								</div>
							</div>
							<div class="form-actions">
								<div class="form-actions-inner text-right">
									<button type="button" id="button-review" onclick="addReview(<?= $product_id; ?>,this);" class="btn btn-primary"><?= $lang_button_continue; ?></button>
								</div>
							</div>
						</form>
						<?php else: ?>
						<div class="alert alert-danger"><?= $lang_text_please_login; ?></div>
						<?php endif; ?>
					</fieldset>
				</div>
			<?php } ?>
		</div>
		<?php if ($products) { ?>
			<hr>
			<h4 class="text-muted"><?= $lang_tab_related; ?></h4>
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
							<?php for ($i = 1; $i <= 5; $i++):
								  if ($product['rating'] < $i): ?>
									<i class="fa fa-star-o"></i>
							<?php else: ?>
									'<i class="fa fa-star"></i>
							<?php endif; 
								  endfor; 
							?>
							</div>
						<?php } ?>
						<div class="cart">
						<?php if (!$wishlist): ?>
							<button type="button" 
								data-cart="<?= $product['product_id']; ?>" 
								data-toggle="tooltip" title="<?= $lang_button_cart; ?>" class="<?= $btn_class; ?>">
								<i class="fa fa-shopping-cart"></i>
							</button>
						<?php else: ?>
							<button type="button" data-cart="<?= $product['product_id']; ?>" class="<?= $btn_class; ?>">
								<?= str_replace('Cart', '<i title="Cart" class="fa fa-shopping-cart"></i>', $lang_button_cart); ?>
							</button>
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
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>