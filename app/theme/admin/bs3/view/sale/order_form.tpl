<?= $header; ?>
<?= $breadcrumb; ?>
<?php if (!empty($error)): ?>
<div class="alert alert-danger"><?= $error; ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
<?php endif; ?>
<?php if (!empty($error_warning)): ?>
<div class="alert alert-danger"><?= $error_warning; ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
<div class="alert alert-success"><?= $success; ?><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>
<?php endif; ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="clearfix">
			<div class="pull-left h2"><i class="hidden-xs fa fa-shopping-cart"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs"><li><a href="#tab-customer" data-toggle="tab"><?= $lang_tab_customer; ?></a></li><li><a href="#tab-payment" data-toggle="tab"><?= $lang_tab_payment; ?></a></li><li><a href="#tab-shipping" data-toggle="tab"><?= $lang_tab_shipping; ?></a></li><li><a href="#tab-product" data-toggle="tab"><?= $lang_tab_product; ?></a></li><li><a href="#tab-giftcard" data-toggle="tab"><?= $lang_tab_giftcard; ?></a></li><li><a href="#tab-total" data-toggle="tab"><?= $lang_tab_total; ?></a></li></ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<div class="tab-content">
			<div id="tab-customer" class="tab-pane">
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_store; ?></label>
					<div class="control-field col-sm-4">
						<select name="store_id" class="form-control">
							<option value="0"><?= $lang_text_default; ?></option>
							<?php foreach ($stores as $store) { ?>
								<?php if ($store['store_id'] == $store_id) { ?>
								<option value="<?= $store['store_id']; ?>" selected><?= $store['name']; ?></option>
								<?php } else { ?>
								<option value="<?= $store['store_id']; ?>"><?= $store['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_customer; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="customer" value="<?= $customer; ?>" id="order-customer" autocomplete="off" class="form-control">
						<input type="hidden" name="customer_id" value="<?= $customer_id; ?>">
						<input type="hidden" name="customer_group_id" value="<?= $customer_group_id; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_customer_group; ?></label>
					<div class="control-field col-sm-4">
						<select id="customer_group_id" class="form-control"<?= $customer_id ? ' disabled=""' :''; ?>>
							<?php foreach ($customer_groups as $customer_group) { ?>
								<?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
								<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
								<?php } else { ?>
								<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="firstname" value="<?= $firstname; ?>" class="form-control">
						<?php if ($error_firstname) { ?>
							<div class="help-block error"><?= $error_firstname; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="lastname" value="<?= $lastname; ?>" class="form-control">
						<?php if ($error_lastname) { ?>
							<div class="help-block error"><?= $error_lastname; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_email; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="email" value="<?= $email; ?>" class="form-control">
						<?php if ($error_email) { ?>
							<div class="help-block error"><?= $error_email; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_telephone; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="telephone" value="<?= $telephone; ?>" class="form-control">
						<?php if ($error_telephone) { ?>
							<div class="help-block error"><?= $error_telephone; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div id="tab-payment" class="tab-pane">
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_address; ?></label>
					<div class="control-field col-sm-4">
						<select name="payment_address" class="form-control">
							<option value="0" selected><?= $lang_text_none; ?></option>
							<?php foreach ($addresses as $address) { ?>
								<option value="<?= $address['address_id']; ?>"><?= $address['firstname'] . ' ' . $address['lastname'] . ', ' . $address['address_1'] . ', ' . $address['city'] . ', ' . $address['country']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="payment_firstname" value="<?= $payment_firstname; ?>" class="form-control">
						<?php if ($error_payment_firstname) { ?>
							<div class="help-block error"><?= $error_payment_firstname; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="payment_lastname" value="<?= $payment_lastname; ?>" class="form-control">
						<?php if ($error_payment_lastname) { ?>
							<div class="help-block error"><?= $error_payment_lastname; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_company; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="payment_company" value="<?= $payment_company; ?>" class="form-control">
					</div>
				</div>
				<div class="form-group" id="company-id-display">
					<label class="control-label col-sm-2"><span id="company-id-required" class="required">*</span> <?= $lang_entry_company_id; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="payment_company_id" value="<?= $payment_company_id; ?>" class="form-control">
					</div>
				</div>
				<div class="form-group" id="tax-id-display">
					<label class="control-label col-sm-2"><span id="tax-id-required" class="required">*</span> <?= $lang_entry_tax_id; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="payment_tax_id" value="<?= $payment_tax_id; ?>" class="form-control">
						<?php if ($error_payment_tax_id) { ?>
						<div class="help-block error"><?= $error_payment_tax_id; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_address_1; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="payment_address_1" value="<?= $payment_address_1; ?>" class="form-control">
						<?php if ($error_payment_address_1) { ?>
							<div class="help-block error"><?= $error_payment_address_1; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_address_2; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="payment_address_2" value="<?= $payment_address_2; ?>" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_city; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="payment_city" value="<?= $payment_city; ?>" class="form-control">
						<?php if ($error_payment_city) { ?>
							<div class="help-block error"><?= $error_payment_city; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><span id="payment-postcode-required" class="required">*</span> <?= $lang_entry_postcode; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="payment_postcode" value="<?= $payment_postcode; ?>" class="form-control">
						<?php if ($error_payment_postcode) { ?>
							<div class="help-block error"><?= $error_payment_postcode; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_country; ?></label>
					<div class="control-field col-sm-4">
						<select name="payment_country_id" data-provide="countries" data-target="payment" data-selected="<?= $payment_zone_id; ?>" class="form-control">
							<option value=""><?= $lang_text_select; ?></option>
							<?php foreach ($countries as $country) { ?>
								<?php if ($country['country_id'] == $payment_country_id) { ?>
								<option value="<?= $country['country_id']; ?>" selected><?= $country['name']; ?></option>
								<?php } else { ?>
								<option value="<?= $country['country_id']; ?>"><?= $country['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php if ($error_payment_country) { ?>
							<div class="help-block error"><?= $error_payment_country; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_zone; ?></label>
					<div class="control-field col-sm-4">
						<select name="payment_zone_id" class="form-control"></select>
						<?php if ($error_payment_zone) { ?>
							<div class="help-block error"><?= $error_payment_zone; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div id="tab-shipping" class="tab-pane">
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_address; ?></label>
					<div class="control-field col-sm-4">
						<select name="shipping_address" class="form-control">
							<option value="0" selected><?= $lang_text_none; ?></option>
							<?php foreach ($addresses as $address) { ?>
								<option value="<?= $address['address_id']; ?>"><?= $address['firstname'] . ' ' . $address['lastname'] . ', ' . $address['address_1'] . ', ' . $address['city'] . ', ' . $address['country']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="shipping_firstname" value="<?= $shipping_firstname; ?>" class="form-control">
						<?php if ($error_shipping_firstname) { ?>
							<div class="help-block error"><?= $error_shipping_firstname; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="shipping_lastname" value="<?= $shipping_lastname; ?>" class="form-control">
						<?php if ($error_shipping_lastname) { ?>
							<div class="help-block error"><?= $error_shipping_lastname; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_company; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="shipping_company" value="<?= $shipping_company; ?>" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_address_1; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="shipping_address_1" value="<?= $shipping_address_1; ?>" class="form-control">
						<?php if ($error_shipping_address_1) { ?>
							<div class="help-block error"><?= $error_shipping_address_1; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_address_2; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="shipping_address_2" value="<?= $shipping_address_2; ?>" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_city; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="shipping_city" value="<?= $shipping_city; ?>" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><span id="shipping-postcode-required" class="required">*</span> <?= $lang_entry_postcode; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="shipping_postcode" value="<?= $shipping_postcode; ?>" class="form-control">
						<?php if ($error_shipping_postcode) { ?>
							<div class="help-block error"><?= $error_shipping_postcode; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_country; ?></label>
					<div class="control-field col-sm-4">
						<select name="shipping_country_id" data-provide="countries" data-target="shipping" data-selected="<?= $shipping_zone_id; ?>" class="form-control">
							<option value=""><?= $lang_text_select; ?></option>
							<?php foreach ($countries as $country) { ?>
								<?php if ($country['country_id'] == $shipping_country_id) { ?>
								<option value="<?= $country['country_id']; ?>" selected><?= $country['name']; ?></option>
								<?php } else { ?>
								<option value="<?= $country['country_id']; ?>"><?= $country['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<?php if ($error_shipping_country) { ?>
							<div class="help-block error"><?= $error_shipping_country; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_zone; ?></label>
					<div class="control-field col-sm-4">
						<select name="shipping_zone_id" class="form-control"></select>
						<?php if ($error_shipping_zone) { ?>
							<div class="help-block error"><?= $error_shipping_zone; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div id="tab-product" class="tab-pane">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th width="40"></th>
							<th><?= $lang_column_product; ?></th>
							<th><?= $lang_column_model; ?></th>
							<th class="text-right"><?= $lang_column_quantity; ?></th>
							<th class="text-right"><?= $lang_column_price; ?></th>
							<th class="text-right"><?= $lang_column_total; ?></th>
						</tr>
					</thead>
					<?php $product_row = 0; ?>
					<?php $option_row = 0; ?>
					<?php $download_row = 0; ?>
					<tbody id="product">
						<?php if ($order_products) { ?>
						<?php foreach ($order_products as $order_product) { ?>
						<tr id="product-row<?= $product_row; ?>">
							<td class="text-center"><a class="label label-danger" title="<?= $lang_button_remove; ?>" onclick="$('#product-row<?= $product_row; ?>').remove();$('#button-update').trigger('click');"><i class="fa fa-trash-o fa-lg"></i></a></td>
							<td><?= $order_product['name']; ?><br>
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_product_id]" value="<?= $order_product['order_product_id']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][product_id]" value="<?= $order_product['product_id']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][name]" value="<?= $order_product['name']; ?>">
								<?php foreach ($order_product['option'] as $option) { ?>
								<div class="help"><?= $option['name']; ?>: <?= $option['value']; ?></div>
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_option][<?= $option_row; ?>][order_option_id]" value="<?= $option['order_option_id']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_option][<?= $option_row; ?>][product_option_id]" value="<?= $option['product_option_id']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_option][<?= $option_row; ?>][product_option_value_id]" value="<?= $option['product_option_value_id']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_option][<?= $option_row; ?>][name]" value="<?= $option['name']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_option][<?= $option_row; ?>][value]" value="<?= $option['value']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_option][<?= $option_row; ?>][type]" value="<?= $option['type']; ?>">
								<?php $option_row++; ?>
								<?php } ?>
								<?php foreach ($order_product['download'] as $download) { ?>
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_download][<?= $download_row; ?>][order_download_id]" value="<?= $download['order_download_id']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_download][<?= $download_row; ?>][name]" value="<?= $download['name']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_download][<?= $download_row; ?>][filename]" value="<?= $download['filename']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_download][<?= $download_row; ?>][mask]" value="<?= $download['mask']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][order_download][<?= $download_row; ?>][remaining]" value="<?= $download['remaining']; ?>">
								<?php $download_row++; ?>
								<?php } ?></td>
							<td><?= $order_product['model']; ?>
								<input type="hidden" name="order_product[<?= $product_row; ?>][model]" value="<?= $order_product['model']; ?>"></td>
							<td class="text-right"><?= $order_product['quantity']; ?>
								<input type="hidden" name="order_product[<?= $product_row; ?>][quantity]" value="<?= $order_product['quantity']; ?>"></td>
							<td class="text-right"><?= $order_product['price']; ?>
								<input type="hidden" name="order_product[<?= $product_row; ?>][price]" value="<?= $order_product['price']; ?>"></td>
							<td class="text-right"><?= $order_product['total']; ?>
								<input type="hidden" name="order_product[<?= $product_row; ?>][total]" value="<?= $order_product['total']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][tax]" value="<?= $order_product['tax']; ?>">
								<input type="hidden" name="order_product[<?= $product_row; ?>][reward]" value="<?= $order_product['reward']; ?>"></td>
						</tr>
						<?php $product_row++; ?>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td class="text-center" colspan="6"><?= $lang_text_no_results; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<fieldset>
					<legend><?= $lang_text_product; ?></legend>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_product; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="product" value="" id="order-product" class="form-control" autocomplete="off"><input type="hidden" name="product_id" value="" class="form-control">
						</div>
					</div>
					<div id="option"></div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_quantity; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="quantity" value="1" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="control-field col-sm-4 col-sm-offset-2">
							<button type="button" id="button-product" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= $lang_button_add_product; ?></button>
						</div>
					</div>
				</fieldset>
			</div>
			<div id="tab-giftcard" class="tab-pane">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th></th>
							<th><?= $lang_column_product; ?></th>
							<th><?= $lang_column_model; ?></th>
							<th class="text-right"><?= $lang_column_quantity; ?></th>
							<th class="text-right"><?= $lang_column_price; ?></th>
							<th class="text-right"><?= $lang_column_total; ?></th>
						</tr>
					</thead>
					<tbody id="giftcard">
						<?php $giftcard_row = 0; ?>
						<?php if ($order_giftcards) { ?>
						<?php foreach ($order_giftcards as $order_giftcard) { ?>
						<tr id="giftcard-row<?= $giftcard_row; ?>">
							<td class="text-center"><a title="<?= $lang_button_remove; ?>" onclick="$('#giftcard-row<?= $giftcard_row; ?>').remove();$('#button-update').trigger('click');"><i class="fa fa-trash-o fa-lg"></i></a></td>
							<td><?= $order_giftcard['description']; ?>
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][order_giftcard_id]" value="<?= $order_giftcard['order_giftcard_id']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][giftcard_id]" value="<?= $order_giftcard['giftcard_id']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][description]" value="<?= $order_giftcard['description']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][code]" value="<?= $order_giftcard['code']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][from_name]" value="<?= $order_giftcard['from_name']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][from_email]" value="<?= $order_giftcard['from_email']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][to_name]" value="<?= $order_giftcard['to_name']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][to_email]" value="<?= $order_giftcard['to_email']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][giftcard_theme_id]" value="<?= $order_giftcard['giftcard_theme_id']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][message]" value="<?= $order_giftcard['message']; ?>">
								<input type="hidden" name="order_giftcard[<?= $giftcard_row; ?>][amount]" value="<?= $order_giftcard['amount']; ?>"></td>
							<td></td>
							<td class="text-right">1</td>
							<td class="text-right"><?= number_format($order_giftcard['amount'], 2); ?></td>
							<td class="text-right"><?= number_format($order_giftcard['amount'], 2); ?></td>
						</tr>
						<?php $giftcard_row++; ?>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td class="text-center" colspan="6"><?= $lang_text_no_results; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<fieldset>
					<legend><?= $lang_text_giftcard; ?></legend>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_to_name; ?></label>
						<div class="control-field col-sm-4"><input type="text" name="to_name" value="" class="form-control" class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_to_email; ?></label>
						<div class="control-field col-sm-4"><input type="text" name="to_email" value="" class="form-control" class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_from_name; ?></label>
						<div class="control-field col-sm-4"><input type="text" name="from_name" value="" class="form-control" class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_from_email; ?></label>
						<div class="control-field col-sm-4"><input type="text" name="from_email" value="" class="form-control" class="form-control"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_theme; ?></label>
						<div class="control-field col-sm-4">
							<select name="giftcard_theme_id" class="form-control">
								<?php foreach ($giftcard_themes as $giftcard_theme) { ?>
									<option value="<?= $giftcard_theme['giftcard_theme_id']; ?>"><?= addslashes($giftcard_theme['name']); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_message; ?></label>
						<div class="control-field col-sm-4"><textarea name="message" class="form-control" rows="3"></textarea></div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_amount; ?></label>
						<div class="control-field col-sm-4"><input type="text" name="amount" value="25.00" class="form-control"></div>
					</div>
					<div class="form-group">
						<div class="control-field col-sm-4 col-sm-offset-2">
							<button type="button" id="button-giftcard" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= $lang_button_add_giftcard; ?></button>
						</div>
					</div>
				</fieldset>
			</div>
			<div id="tab-total" class="tab-pane">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th><?= $lang_column_product; ?></th>
							<th><?= $lang_column_model; ?></th>
							<th class="text-right"><?= $lang_column_quantity; ?></th>
							<th class="text-right"><?= $lang_column_price; ?></th>
							<th class="text-right"><?= $lang_column_total; ?></th>
						</tr>
					</thead>
					<tbody id="total">
						<?php $total_row = 0; ?>
						<?php if ($order_products || $order_giftcards || $order_totals) { ?>
						<?php foreach ($order_products as $order_product) { ?>
						<tr>
							<td><?= $order_product['name']; ?>
							<?php foreach ($order_product['option'] as $option) { ?>
								<div class="help"><?= $option['name']; ?>: <?= $option['value']; ?></div>
							<?php } ?></td>
							<td><?= $order_product['model']; ?></td>
							<td class="text-right"><?= $order_product['quantity']; ?></td>
							<td class="text-right"><?= $order_product['price']; ?></td>
							<td class="text-right"><?= $order_product['total']; ?></td>
						</tr>
						<?php } ?>
						<?php foreach ($order_giftcards as $order_giftcard) { ?>
						<tr>
							<td><?= $order_giftcard['description']; ?></td>
							<td></td>
							<td class="text-right">1</td>
							<td class="text-right"><?= number_format($order_giftcard['amount'], 2); ?></td>
							<td class="text-right"><?= number_format($order_giftcard['amount'], 2); ?></td>
						</tr>
						<?php } ?>
						<?php foreach ($order_totals as $order_total) { ?>
						<tr id="total-row<?= $total_row; ?>">
							<td class="text-right" colspan="4"><?= $order_total['title']; ?>:
								<input type="hidden" name="order_total[<?= $total_row; ?>][order_total_id]" value="<?= $order_total['order_total_id']; ?>">
								<input type="hidden" name="order_total[<?= $total_row; ?>][code]" value="<?= $order_total['code']; ?>">
								<input type="hidden" name="order_total[<?= $total_row; ?>][title]" value="<?= $order_total['title']; ?>">
								<input type="hidden" name="order_total[<?= $total_row; ?>][text]" value="<?= $order_total['text']; ?>">
								<input type="hidden" name="order_total[<?= $total_row; ?>][value]" value="<?= $order_total['value']; ?>">
								<input type="hidden" name="order_total[<?= $total_row; ?>][sort_order]" value="<?= $order_total['sort_order']; ?>"></td>
							<td class="text-right"><?= number_format($order_total['value'], 2); ?></td>
						</tr>
						<?php $total_row++; ?>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td class="text-center" colspan="5"><?= $lang_text_no_results; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<fieldset>
					<legend><?= $lang_text_order; ?></legend>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_shipping; ?></label>
						<div class="control-field col-sm-4">
							<select name="shipping" class="form-control">
								<option value=""><?= $lang_text_select; ?></option>
								<?php if ($shipping_code): ?>
								<option value="<?= $shipping_code; ?>" selected><?= $shipping_method; ?></option>
								<?php endif; ?>
							</select>
							<input type="hidden" name="shipping_method" value="<?= $shipping_method; ?>">
							<input type="hidden" name="shipping_code" value="<?= $shipping_code; ?>">
							<?php if ($error_shipping_method) { ?>
								<div class="help-block error"><?= $error_shipping_method; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_payment; ?></label>
						<div class="control-field col-sm-4">
							<select name="payment" class="form-control">
								<option value=""><?= $lang_text_select; ?></option>
								<?php if ($payment_code): ?>
								<option value="<?= $payment_code; ?>" selected><?= $payment_method; ?></option>
								<?php endif; ?>
							</select>
							<input type="hidden" name="payment_method" value="<?= $payment_method; ?>">
							<input type="hidden" name="payment_code" value="<?= $payment_code; ?>">
							<?php if ($error_payment_method) { ?>
								<div class="help-block error"><?= $error_payment_method; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_coupon; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="coupon" value="" class="form-control" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_giftcard; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="giftcard" value="" class="form-control" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_reward; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="reward" value="" class="form-control" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_order_status; ?></label>
						<div class="control-field col-sm-4">
							<select name="order_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
								<?php if ($order_status['order_status_id'] == $order_status_id) { ?>
								<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
								<?php } else { ?>
								<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_comment; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="comment" class="form-control" rows="3"><?= $comment; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_affiliate; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="affiliate" value="<?= $affiliate; ?>" class="form-control" autocomplete="off">
							<input type="hidden" name="affiliate_id" value="<?= $affiliate_id; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="control-field col-sm-4 col-sm-offset-2">
							<button type="button" id="button-update" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= $lang_button_update_total; ?></button>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		</form>
	</div>
</div>
<input type="hidden" id="text_none" value="<?= $lang_text_none; ?>">
<input type="hidden" id="text_select" value="<?= $lang_text_select; ?>">
<input type="hidden" id="button_upload" value="<?= $lang_button_upload; ?>">
<input type="hidden" id="store_url" value="<?= $store_url; ?>">
<input type="hidden" id="button_remove" value="<?= $lang_button_remove; ?>">
<input type="hidden" id="text_no_results" value="<?= $lang_text_no_results; ?>">
<?= $footer; ?>