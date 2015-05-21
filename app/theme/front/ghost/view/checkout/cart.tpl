<?= $header; ?>
<?php if ($attention){ ?>
<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $attention; ?></div>
<?php } ?>
<?php if ($success){ ?>
<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $success; ?></div>
<?php } ?>
<?php if ($error_warning){ ?>
<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
<?php } ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; echo ($weight) ? '&nbsp;<small>(' . $weight . ')</small>' : ''; ?></h1></div>
		<form class="form-inline" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="hidden-xs text-center"><?= $lang_column_image; ?></th>
						<th><?= $lang_column_name; ?></th>
						<th class="hidden-xs"><?= $lang_column_model; ?></th>
						<th class="text-right"><?= $lang_column_quantity; ?></th>
						<th class="text-right hidden-xs"><?= $lang_column_price; ?></th>
						<th class="text-right col-sm-2"><?= $lang_column_total; ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($products as $product){ ?>
					<tr>
						<td class="hidden-xs text-center"><?php if ($product['thumb']){ ?>
							<a href="<?= $product['href']; ?>"><img class="img-thumbnail" src="<?= $product['thumb']; ?>" alt="<?= $product['name']; ?>" title="<?= $product['name']; ?>"></a>
						<?php } ?></td>
						<td><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a>
							<?php if (!$product['stock']){ ?>
								<b class="required">***</b>
							<?php } ?>
							<?php foreach ($product['option'] as $option){ ?>
								<br><div class="help">- <?= $option['name']; ?>: <?= $option['value']; ?></div>
							<?php } ?>
							<?php if ($product['recurring']) { ?>
								<br>
								<div class="help">- <?= $lang_text_recurring_item; ?>: <?= $product['recurring']; ?></div>
							<?php } ?>
							<?php if ($product['reward']){ ?>
								<div class="help"><?= $product['reward']; ?></div>
							<?php } ?></td>
						<td class="hidden-xs"><?= $product['model']; ?></td>
						<td class="text-right">
							<input type="number" name="quantity[<?= $product['key']; ?>]" value="<?= $product['quantity']; ?>" class="form-control" min="1" autocomplete="off">
							<div class="btn-group">
								<a class="btn btn-info" onclick="$('#form').submit();"><i class="fa fa-refresh" data-toggle="tooltip" title="<?= $lang_button_update; ?>"></i></a>
								<a class="btn btn-danger" href="<?= $product['remove']; ?>"><i class="fa fa-times" data-toggle="tooltip" title="<?= $lang_button_remove; ?>"></i></a>
							</div>
						</td>
						<td class="text-right hidden-xs"><?= $product['price']; ?></td>
						<td class="text-right"><?= $product['total']; ?></td>
					</tr>
					<?php } ?>
					<?php foreach ($gift_cards as $gift_cards){ ?>
					<tr>
						<td class="hidden-xs text-center"><i class="fa fa-gift fa-2x"></i></td>
						<td><?= $gift_cards['description']; ?></td>
						<td class="hidden-xs"></td>
						<td class="text-right"><a class="btn btn-danger" href="<?= $gift_cards['remove']; ?>"><i class="fa fa-times" data-toggle="tooltip" title="<?= $lang_button_remove; ?>"></i></a></td>
						<td class="text-right hidden-xs"><?= $gift_cards['amount']; ?></td>
						<td class="text-right"><?= $gift_cards['amount']; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
		<?php if ($coupon_status || $gift_card_status || $reward_status || $shipping_status){ ?>
			<fieldset>
			<legend><?= $lang_text_next; ?></legend>
			<p><?= $lang_text_next_choice; ?></p>
			<div class="panel-group" id="next-container">
				<?php if ($coupon_status){ ?>
					<div class="panel panel-default">
						<div class="panel-heading panel-heading-collapse"><a data-toggle="collapse" data-parent="#next-container" href="#coupon"><?= $lang_text_use_coupon; ?></a></div>
						<div id="coupon" class="panel-collapse collapse<?= ($next == 'coupon' ? ' in' : ''); ?>">
							<div class="panel-body">
								<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
									<label for="next_coupon"><?= $lang_entry_coupon; ?></label>
									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" name="coupon" value="<?= $coupon; ?>" class="form-control" placeholder="<?= $lang_entry_coupon; ?>"  id="next_coupon">
										</div>
									</div>
									<input type="submit" value="<?= $lang_button_coupon; ?>" class="btn btn-primary">
									<input type="hidden" name="next" value="coupon">
								</form>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if ($gift_card_status){ ?>
					<div class="panel panel-default">
						<div class="panel-heading panel-heading-collapse"><a data-toggle="collapse" data-parent="#next-container" href="#gift_card"><?= $lang_text_use_gift_card; ?></a></div>
						<div id="gift_card" class="panel-collapse collapse<?= ($next == 'gift_card' ? ' in' : ''); ?>">
							<div class="panel-body">
								<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
									<label for="next_gift_card"><?= $lang_entry_gift_card; ?></label>
									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" name="gift_card" value="<?= $gift_card; ?>" class="form-control" placeholder="<?= $lang_entry_gift_card; ?>"  id="next_gift_card">
										</div>
									</div>
									<input type="hidden" name="next" value="gift_card">
									<input type="submit" value="<?= $lang_button_gift_card; ?>" class="btn btn-primary">
								</form>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if ($reward_status){ ?>
					<div class="panel panel-default">
						<div class="panel-heading panel-heading-collapse"><a data-toggle="collapse" data-parent="#next-container" href="#reward"><?= $text_use_reward; ?></a></div>
						<div id="reward" class="panel-collapse collapse<?= ($next == 'reward' ? ' in' : ''); ?>">
							<div class="panel-body">
								<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
									<label for="next_reward"><h5><?= $entry_reward; ?></h5></label>
									<input type="text" name="reward" value="<?= $reward; ?>" class="form-control" placeholder="<?= $lang_entry_reward; ?>"  id="next_reward">
									<input type="hidden" name="next" value="reward">
									<input type="submit" value="<?= $lang_button_reward; ?>" class="btn btn-primary">
								</form>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if ($shipping_status){ ?>
					<div class="panel panel-default">
						<div class="panel-heading panel-heading-collapse">
							<a data-toggle="collapse" data-parent="#next-container" href="#shipping"><?= $lang_text_shipping_estimate; ?></a></div>
						<div id="shipping" class="panel-collapse collapse<?= ($next == 'shipping' ? ' in' : ''); ?>">
							<div class="panel-body">
								<form class="form-horizontal" id="form-shipping">
									<h5><?= $lang_text_shipping_detail; ?></h5><hr>
									<div class="form-group">
										<label class="control-label col-sm-3" for="country_id"><b class="required">*</b> <?= $lang_entry_country; ?></label>
										<div class="col-sm-6">
											<select name="country_id" 
												class="form-control" 
												id="country_id" 
												data-param="<?= htmlentities('{"zone_id":"' . $zone_id . '","select":"' . $lang_text_select . '","none":"' . $lang_text_none . '"}'); ?>" required>
											<option value=""><?= $lang_text_select; ?></option>
											<?php foreach ($countries as $country){ ?>
											<?php if ($country['country_id'] == $country_id){ ?>
											<option value="<?= $country['country_id']; ?>" selected=""><?= $country['name']; ?></option>
											<?php } else { ?>
											<option value="<?= $country['country_id']; ?>"><?= $country['name']; ?></option>
											<?php } ?>
											<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="zone_id"><b class="required">*</b> <?= $lang_entry_zone; ?></label>
										<div class="col-sm-6">
											<select name="zone_id" class="form-control" id="zone_id" required></select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="postcode">
										<b id="postcode-required" class="required">*</b> <?= $lang_entry_postcode; ?></label>
										<div class="col-sm-2">
											<input type="text" name="postcode" value="<?= $postcode; ?>" 
												class="form-control" placeholder="<?= $lang_entry_postcode; ?>"  id="postcode">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-6 col-sm-offset-3">
											<button type="button" id="button-quote" 
												class="btn btn-primary" data-loading-text="Loading Quotes"><?= $lang_button_quote; ?></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			</fieldset>
		<?php } ?>
		<table class="table">
			<?php foreach ($totals as $total){ ?>
				<tr>
					<td class="text-right"><?= $total['title']; ?>:</td>
					<td class="text-right col-sm-2"><?= $total['text']; ?></td>
				</tr>
			<?php } ?>
		</table>
		<div class="form-actions">
			<div class="form-actions-inner">
				<div class="form-actions-inner text-right">
					<a href="<?= $continue; ?>" class="hidden-xs btn btn-default pull-left"><?= $lang_button_shopping; ?></a>
					<a href="<?= $checkout; ?>" class="btn btn-warning btn-lg"><i class="fa fa-shopping-cart"></i> <?= $lang_button_checkout; ?></a>
				</div>
			</div>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?php if ($shipping_status){ ?>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<form class="modal-dialog" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?= $lang_text_shipping_method; ?></h4>
			</div>
			<div class="modal-body">
				<table id="modal-table" class="table table-striped"></table>
				<input type="hidden" name="next" value="shipping">
			</div>
			<div class="modal-footer">
				<button type="submit" 
					id="button-shipping" 
					class="btn btn-primary"<?= (!$shipping_method) ? ' disabled=""' : ''; ?>><?= $lang_button_shipping; ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</form>
</div>
<?php } ?>
<?= $pre_footer; ?>
<?= $footer; ?>