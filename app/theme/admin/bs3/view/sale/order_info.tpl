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
		<div class="pull-left h2"><i class="hidden-xs fa fa-shopping-cart"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right"><a class="btn btn-default" href="<?= $invoice; ?>" target="_blank"><i class="fa fa-print"></i><span class="hidden-xs"> <?= $lang_button_invoice; ?></span></a> <a class="btn btn-warning" href="<?= $cancel; ?>"><i class="fa fa-ban"></i> <?= $lang_button_cancel; ?></a></div>
	</div>
	<div class="panel-body">
		<div class="tabbable">
			<ul class="nav nav-tabs"><li><a href="#tab-order" data-toggle="tab"><?= $lang_tab_order; ?></a></li><li><a href="#tab-payment" data-toggle="tab"><?= $lang_tab_payment; ?></a></li>
				<?php if ($shipping_method) { ?>
				<li><a href="#tab-shipping" data-toggle="tab"><?= $lang_tab_shipping; ?></a></li>
				<?php } ?>
				<li><a href="#tab-product" data-toggle="tab"><?= $lang_tab_product; ?></a></li><li><a href="#tab-history" data-toggle="tab"><?= $lang_tab_history; ?></a></li>
				<?php if ($maxmind_id) { ?>
				<li><a href="#tab-fraud" data-toggle="tab"><?= $lang_tab_fraud; ?></a></li>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<div id="tab-order" class="tab-pane">
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td class="col-sm-3"><?= $lang_text_order_id; ?></td>
							<td>#<?= $order_id; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_invoice_no; ?></td>
							<td><?php if ($invoice_no) { ?>
								<?= $invoice_no; ?>
								<?php } else { ?>
								<span id="invoice"><button type="button" class="btn btn-default" id="invoice-generate"><?= $lang_text_generate; ?></button></span>
								<?php } ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_store_name; ?></td>
							<td><?= $store_name; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_store_url; ?></td>
							<td><a href="<?= $store_url; ?>" target="_blank"><?= $store_url; ?></a></td>
						</tr>
						<?php if ($customer) { ?>
						<tr>
							<td><?= $lang_text_customer; ?></td>
							<td><a href="<?= $customer; ?>"><?= $firstname; ?> <?= $lastname; ?></a></td>
						</tr>
						<?php } else { ?>
						<tr>
							<td><?= $lang_text_customer; ?></td>
							<td><?= $firstname; ?> <?= $lastname; ?></td>
						</tr>
						<?php } ?>
						<?php if ($customer_group) { ?>
						<tr>
							<td><?= $lang_text_customer_group; ?></td>
							<td><?= $customer_group; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_email; ?></td>
							<td><?= $email; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_telephone; ?></td>
							<td><?= $telephone; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_total; ?></td>
							<td><?php if ($credit && $customer) { if (!$credit_total) { ?>
								<button type="button" class="btn btn-default" id="credit" data-action="add"><b class="badge badge-info"><?= $total; ?></b>&nbsp;<span><?= $lang_text_credit_add; ?></span></button>
								<?php } else { ?>
								<button type="button" class="btn btn-default" id="credit" data-action="remove"><b class="badge badge-info"><?= $total; ?></b>&nbsp;<span><?= $lang_text_credit_remove; ?></span></button>
								<?php } } else { echo $total; } ?></td>
						</tr>
						<?php if ($reward && $customer) { ?>
						<tr>
							<td><?= $lang_text_reward; ?></td>
							<td><?php if (!$reward_total) { ?>
								<button type="button" class="btn btn-default" id="reward" data-action="add"><b class="badge badge-info"><?= $reward; ?></b>&nbsp;<span><?= $lang_text_reward_add; ?></span></button>
								<?php } else { ?>
								<button type="button" class="btn btn-default" id="reward" data-action="remove"><b class="badge badge-info"><?= $reward; ?></b>&nbsp;<span><?= $lang_text_reward_remove; ?></span></button>
								<?php } ?></td>
						</tr>
						<?php } ?>
						<?php if ($order_status) { ?>
						<tr>
							<td><?= $lang_text_order_status; ?></td>
							<td id="order-status"><?= $order_status; ?></td>
						</tr>
						<?php } ?>
						<?php if ($comment) { ?>
						<tr>
							<td><?= $lang_text_comment; ?></td>
							<td><?= $comment; ?></td>
						</tr>
						<?php } ?>
						<?php if ($affiliate) { ?>
						<tr>
							<td><?= $lang_text_affiliate; ?></td>
							<td><a href="<?= $affiliate; ?>"><?= $affiliate_firstname; ?> <?= $affiliate_lastname; ?></a></td>
						</tr>
						<tr>
							<td><?= $lang_text_commission; ?></td>
							<td><?php if (!$commission_total) { ?>
								<button type="button" class="btn btn-default" id="commission" data-action="add"><b class="badge badge-info"><?= $commission; ?></b>&nbsp;<span><?= $lang_text_commission_add; ?></span></button>
								<?php } else { ?>
								<button type="button" class="btn btn-default" id="commission" data-action="remove"><b class="badge badge-info"><?= $commission; ?></b>&nbsp;<span><?= $lang_text_commission_remove; ?></span></button>
								<?php } ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip) { ?>
						<tr>
							<td><?= $lang_text_ip; ?></td>
							<td><?= $ip; ?></td>
						</tr>
						<?php } ?>
						<?php if ($forwarded_ip) { ?>
						<tr>
							<td><?= $lang_text_forwarded_ip; ?></td>
							<td><?= $forwarded_ip; ?></td>
						</tr>
						<?php } ?>
						<?php if ($user_agent) { ?>
						<tr>
							<td><?= $lang_text_user_agent; ?></td>
							<td><?= $user_agent; ?></td>
						</tr>
						<?php } ?>
						<?php if ($accept_language) { ?>
						<tr>
							<td><?= $lang_text_accept_language; ?></td>
							<td><?= $accept_language; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_date_added; ?></td>
							<td><?= $date_added; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_date_modified; ?></td>
							<td><?= $date_modified; ?></td>
						</tr>
					</table>
				</div>
				<div id="tab-payment" class="tab-pane">
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td class="col-sm-3"><?= $lang_text_firstname; ?></td>
							<td><?= $payment_firstname; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_lastname; ?></td>
							<td><?= $payment_lastname; ?></td>
						</tr>
						<?php if ($payment_company) { ?>
						<tr>
							<td><?= $lang_text_company; ?></td>
							<td><?= $payment_company; ?></td>
						</tr>
						<?php } ?>
						<?php if ($payment_company_id) { ?>
						<tr>
							<td><?= $lang_text_company_id; ?></td>
							<td><?= $payment_company_id; ?></td>
						</tr>
						<?php } ?>	
						<?php if ($payment_tax_id) { ?>
						<tr>
							<td><?= $lang_text_tax_id; ?></td>
							<td><?= $payment_tax_id; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_address_1; ?></td>
							<td><?= $payment_address_1; ?></td>
						</tr>
						<?php if ($payment_address_2) { ?>
						<tr>
							<td><?= $lang_text_address_2; ?></td>
							<td><?= $payment_address_2; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_city; ?></td>
							<td><?= $payment_city; ?></td>
						</tr>
						<?php if ($payment_postcode) { ?>
						<tr>
							<td><?= $lang_text_postcode; ?></td>
							<td><?= $payment_postcode; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_zone; ?></td>
							<td><?= $payment_zone; ?></td>
						</tr>
						<?php if ($payment_zone_code) { ?>
						<tr>
							<td><?= $lang_text_zone_code; ?></td>
							<td><?= $payment_zone_code; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_country; ?></td>
							<td><?= $payment_country; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_payment_method; ?></td>
							<td><?= $payment_method; ?></td>
						</tr>
					</table>
				</div>
				<?php if ($shipping_method) { ?>
				<div id="tab-shipping" class="tab-pane">
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td class="col-sm-3"><?= $lang_text_firstname; ?></td>
							<td><?= $shipping_firstname; ?></td>
						</tr>
						<tr>
							<td><?= $lang_text_lastname; ?></td>
							<td><?= $shipping_lastname; ?></td>
						</tr>
						<?php if ($shipping_company) { ?>
						<tr>
							<td><?= $lang_text_company; ?></td>
							<td><?= $shipping_company; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_address_1; ?></td>
							<td><?= $shipping_address_1; ?></td>
						</tr>
						<?php if ($shipping_address_2) { ?>
						<tr>
							<td><?= $lang_text_address_2; ?></td>
							<td><?= $shipping_address_2; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_city; ?></td>
							<td><?= $shipping_city; ?></td>
						</tr>
						<?php if ($shipping_postcode) { ?>
						<tr>
							<td><?= $lang_text_postcode; ?></td>
							<td><?= $shipping_postcode; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_zone; ?></td>
							<td><?= $shipping_zone; ?></td>
						</tr>
						<?php if ($shipping_zone_code) { ?>
						<tr>
							<td><?= $lang_text_zone_code; ?></td>
							<td><?= $shipping_zone_code; ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td><?= $lang_text_country; ?></td>
							<td><?= $shipping_country; ?></td>
						</tr>
						<?php if ($shipping_method) { ?>
						<tr>
							<td><?= $lang_text_shipping_method; ?></td>
							<td><?= $shipping_method; ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php } ?>
				<div id="tab-product" class="tab-pane">
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
						<tbody>
							<?php foreach ($products as $product) { ?>
							<tr>
								<td><a href="<?= $product['href']; ?>"><?= $product['name']; ?></a>
									<?php foreach ($product['option'] as $option) { ?>
									<?php if ($option['type'] != 'file'){ ?>
									<div class="help"><?= $option['name']; ?>: <?= $option['value']; ?></div>
									<?php } else { ?>
									<div class="help"><?= $option['name']; ?>: <a href="<?= $option['href']; ?>"><?= $option['value']; ?></a></div>
									<?php } ?>
									<?php } ?></td>
								<td><?= $product['model']; ?></td>
								<td class="text-right"><?= $product['quantity']; ?></td>
								<td class="text-right"><?= $product['price']; ?></td>
								<td class="text-right"><?= $product['total']; ?></td>
							</tr>
							<?php } ?>
							<?php foreach ($gift_cards as $gift_card) { ?>
							<tr>
								<td><a href="<?= $gift_card['href']; ?>"><?= $gift_card['description']; ?></a></td>
								<td></td>
								<td class="text-right">1</td>
								<td class="text-right"><?= $gift_card['amount']; ?></td>
								<td class="text-right"><?= $gift_card['amount']; ?></td>
							</tr>
							<?php } ?>
							<?php foreach ($totals as $totals) { ?>
								<tr id="totals">
									<td colspan="4" class="text-right"><?= $totals['title']; ?>:</td>
									<td class="text-right"><?= $totals['text']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php if ($downloads) { ?>
					<h3><?= $lang_text_download; ?></h3>
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th><?= $lang_column_download; ?></th>
								<th><?= $lang_column_filename; ?></th>
								<th class="text-right"><?= $lang_column_remaining; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($downloads as $download) { ?>
							<tr>
								<td><?= $download['name']; ?></td>
								<td><?= $download['filename']; ?></td>
								<td class="text-right"><?= $download['remaining']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php } ?>
				</div>
				<div id="tab-history" class="tab-pane">
					<div id="history" data-href="sale/order/history/order_id/<?= $order_id; ?>"></div>
					<div class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_order_status; ?></label>
							<div class="control-field col-sm-4">
								<select name="order_status_id" class="form-control">
									<?php foreach ($order_statuses as $order_statuses) { ?>
									<?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
									<option value="<?= $order_statuses['order_status_id']; ?>" selected><?= $order_statuses['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $order_statuses['order_status_id']; ?>"><?= $order_statuses['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="notify"><?= $lang_entry_notify; ?></label>
							<div class="control-field col-sm-4">
								<label class="checkbox-inline"><input type="checkbox" name="notify" value="1" id="notify"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="comment"><?= $lang_entry_comment; ?></label>
							<div class="control-field col-sm-4">
								<textarea name="comment" class="form-control" rows="3" id="comment"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="control-field col-sm-4 col-sm-offset-2">
								<button type="button" id="button-history" data-action="order" data-id="<?= $order_id; ?>" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= $lang_button_add_history; ?></button>
							</div>
						</div>
					</div>
				</div>
				<?php if ($maxmind_id) { ?>
				<div id="tab-fraud" class="tab-pane">
					<table class="table table-bordered table-striped table-hover">
						<?php if ($country_match) { ?>
						<tr>
							<td><?= $lang_text_country_match; ?></td>
							<td><?= $country_match; ?></td>
						</tr>
						<?php } ?>
						<?php if ($country_code) { ?>
						<tr>
							<td><?= $lang_text_country_code; ?></td>
							<td><?= $country_code; ?></td>
						</tr>
						<?php } ?>
						<?php if ($high_risk_country) { ?>
						<tr>
							<td><?= $lang_text_high_risk_country; ?></td>
							<td><?= $high_risk_country; ?></td>
						</tr>
						<?php } ?>
						<?php if ($distance) { ?>
						<tr>
							<td><?= $lang_text_distance; ?></td>
							<td><?= $distance; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_region) { ?>
						<tr>
							<td><?= $lang_text_ip_region; ?></td>
							<td><?= $ip_region; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_city) { ?>
						<tr>
							<td><?= $lang_text_ip_city; ?></td>
							<td><?= $ip_city; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_latitude) { ?>
						<tr>
							<td><?= $lang_text_ip_latitude; ?></td>
							<td><?= $ip_latitude; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_longitude) { ?>
						<tr>
							<td><?= $lang_text_ip_longitude; ?></td>
							<td><?= $ip_longitude; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_isp) { ?>
						<tr>
							<td><?= $lang_text_ip_isp; ?></td>
							<td><?= $ip_isp; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_org) { ?>
						<tr>
							<td><?= $lang_text_ip_org; ?></td>
							<td><?= $ip_org; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_asnum) { ?>
						<tr>
							<td><?= $lang_text_ip_asnum; ?></td>
							<td><?= $ip_asnum; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_user_type) { ?>
						<tr>
							<td><?= $lang_text_ip_user_type; ?></td>
							<td><?= $ip_user_type; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_country_confidence) { ?>
						<tr>
							<td><?= $lang_text_ip_country_confidence; ?></td>
							<td><?= $ip_country_confidence; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_region_confidence) { ?>
						<tr>
							<td><?= $lang_text_ip_region_confidence; ?></td>
							<td><?= $ip_region_confidence; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_city_confidence) { ?>
						<tr>
							<td><?= $lang_text_ip_city_confidence; ?></td>
							<td><?= $ip_city_confidence; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_postal_confidence) { ?>
						<tr>
							<td><?= $lang_text_ip_postal_confidence; ?></td>
							<td><?= $ip_postal_confidence; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_postal_code) { ?>
						<tr>
							<td><?= $lang_text_ip_postal_code; ?></td>
							<td><?= $ip_postal_code; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_accuracy_radius) { ?>
						<tr>
							<td><?= $lang_text_ip_accuracy_radius; ?></td>
							<td><?= $ip_accuracy_radius; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_net_speed_cell) { ?>
						<tr>
							<td><?= $lang_text_ip_net_speed_cell; ?></td>
							<td><?= $ip_net_speed_cell; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_metro_code) { ?>
						<tr>
							<td><?= $lang_text_ip_metro_code; ?></td>
							<td><?= $ip_metro_code; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_area_code) { ?>
						<tr>
							<td><?= $lang_text_ip_area_code; ?></td>
							<td><?= $ip_area_code; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_time_zone) { ?>
						<tr>
							<td><?= $lang_text_ip_time_zone; ?></td>
							<td><?= $ip_time_zone; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_region_name) { ?>
						<tr>
							<td><?= $lang_text_ip_region_name; ?></td>
							<td><?= $ip_region_name; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_domain) { ?>
						<tr>
							<td><?= $lang_text_ip_domain; ?></td>
							<td><?= $ip_domain; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_country_name) { ?>
						<tr>
							<td><?= $lang_text_ip_country_name; ?></td>
							<td><?= $ip_country_name; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_continent_code) { ?>
						<tr>
							<td><?= $lang_text_ip_continent_code; ?></td>
							<td><?= $ip_continent_code; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ip_corporate_proxy) { ?>
						<tr>
							<td><?= $lang_text_ip_corporate_proxy; ?></td>
							<td><?= $ip_corporate_proxy; ?></td>
						</tr>
						<?php } ?>
						<?php if ($anonymous_proxy) { ?>
						<tr>
							<td><?= $lang_text_anonymous_proxy; ?></td>
							<td><?= $anonymous_proxy; ?></td>
						</tr>
						<?php } ?>
						<?php if ($proxy_score) { ?>
						<tr>
							<td><?= $lang_text_proxy_score; ?></td>
							<td><?= $proxy_score; ?></td>
						</tr>
						<?php } ?>
						<?php if ($is_trans_proxy) { ?>
						<tr>
							<td><?= $lang_text_is_trans_proxy; ?></td>
							<td><?= $is_trans_proxy; ?></td>
						</tr>
						<?php } ?>
						<?php if ($free_mail) { ?>
						<tr>
							<td><?= $lang_text_free_mail; ?></td>
							<td><?= $free_mail; ?></td>
						</tr>
						<?php } ?>
						<?php if ($carder_email) { ?>
						<tr>
							<td><?= $lang_text_carder_email; ?></td>
							<td><?= $carder_email; ?></td>
						</tr>
						<?php } ?>
						<?php if ($high_risk_username) { ?>
						<tr>
							<td><?= $lang_text_high_risk_username; ?></td>
							<td><?= $high_risk_username; ?></td>
						</tr>
						<?php } ?>
						<?php if ($high_risk_password) { ?>
						<tr>
							<td><?= $lang_text_high_risk_password; ?></td>
							<td><?= $high_risk_password; ?></td>
						</tr>
						<?php } ?>
						<?php if ($bin_match) { ?>
						<tr>
							<td><?= $lang_text_bin_match; ?></td>
							<td><?= $bin_match; ?></td>
						</tr>
						<?php } ?>
						<?php if ($bin_country) { ?>
						<tr>
							<td><?= $lang_text_bin_country; ?></td>
							<td><?= $bin_country; ?></td>
						</tr>
						<?php } ?>
						<?php if ($bin_name_match) { ?>
						<tr>
							<td><?= $lang_text_bin_name_match; ?></td>
							<td><?= $bin_name_match; ?></td>
						</tr>
						<?php } ?>
						<?php if ($bin_name) { ?>
						<tr>
							<td><?= $lang_text_bin_name; ?></td>
							<td><?= $bin_name; ?></td>
						</tr>
						<?php } ?>
						<?php if ($bin_phone_match) { ?>
						<tr>
							<td><?= $lang_text_bin_phone_match; ?></td>
							<td><?= $bin_phone_match; ?></td>
						</tr>
						<?php } ?>
						<?php if ($bin_phone) { ?>
						<tr>
							<td><?= $lang_text_bin_phone; ?></td>
							<td><?= $bin_phone; ?></td>
						</tr>
						<?php } ?>
						<?php if ($customer_phone_in_billing_location) { ?>
						<tr>
							<td><?= $lang_text_customer_phone_in_billing_location; ?></td>
							<td><?= $customer_phone_in_billing_location; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ship_forward) { ?>
						<tr>
							<td><?= $lang_text_ship_forward; ?></td>
							<td><?= $ship_forward; ?></td>
						</tr>
						<?php } ?>
						<?php if ($city_postal_match) { ?>
						<tr>
							<td><?= $lang_text_city_postal_match; ?></td>
							<td><?= $city_postal_match; ?></td>
						</tr>
						<?php } ?>
						<?php if ($ship_city_postal_match) { ?>
						<tr>
							<td><?= $lang_text_ship_city_postal_match; ?></td>
							<td><?= $ship_city_postal_match; ?></td>
						</tr>
						<?php } ?>
						<?php if ($score) { ?>
						<tr>
							<td><?= $lang_text_score; ?></td>
							<td><?= $score; ?></td>
						</tr>
						<?php } ?>
						<?php if ($explanation) { ?>
						<tr>
							<td><?= $lang_text_explanation; ?></td>
							<td><?= $explanation; ?></td>
						</tr>
						<?php } ?>
						<?php if ($risk_score) { ?>
						<tr>
							<td><?= $lang_text_risk_score; ?></td>
							<td><?= $risk_score; ?></td>
						</tr>
						<?php } ?>
						<?php if ($queries_remaining) { ?>
						<tr>
							<td><?= $lang_text_queries_remaining; ?></td>
							<td><?= $queries_remaining; ?></td>
						</tr>
						<?php } ?>
						<?php if ($maxmind_id) { ?>
						<tr>
							<td><?= $lang_text_maxmind_id; ?></td>
							<td><?= $maxmind_id; ?></td>
						</tr>
						<?php } ?>
						<?php if ($error) { ?>
						<tr>
							<td><?= $lang_text_error; ?></td>
							<td><?= $error; ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?= $footer; ?>