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
			<div class="pull-left h2"><i class="hidden-xs fa fa-cog"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs"><li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li><li><a href="#tab-store" data-toggle="tab"><?= $lang_tab_store; ?></a></li><li><a href="#tab-local" data-toggle="tab"><?= $lang_tab_local; ?></a></li><li><a href="#tab-option" data-toggle="tab"><?= $lang_tab_option; ?></a></li><li><a href="#tab-image" data-toggle="tab"><?= $lang_tab_image; ?></a></li><li><a href="#tab-server" data-toggle="tab"><?= $lang_tab_server; ?></a></li></ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="tab-content">
				<div class="tab-pane" id="tab-general">
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_url; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_url" value="<?= $config_url; ?>" class="form-control">
							<?php if ($error_url) { ?>
								<div class="help-block error"><?= $error_url; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_ssl; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_ssl" value="<?= $config_ssl; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_name; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_name" value="<?= $config_name; ?>" class="form-control">
							<?php if ($error_name) { ?>
								<div class="help-block error"><?= $error_name; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_owner; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_owner" value="<?= $config_owner; ?>" class="form-control">
							<?php if ($error_owner) { ?>
								<div class="help-block error"><?= $error_owner; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_address; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="config_address" class="form-control" rows="3"><?= $config_address; ?></textarea>
							<?php if ($error_address) { ?>
								<div class="help-block error"><?= $error_address; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_email; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_email" value="<?= $config_email; ?>" class="form-control">
							<?php if ($error_email) { ?>
								<div class="help-block error"><?= $error_email; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_telephone; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_telephone" value="<?= $config_telephone; ?>" class="form-control">
							<?php if ($error_telephone) { ?>
								<div class="help-block error"><?= $error_telephone; ?></div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-store">
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_title; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_title" value="<?= $config_title; ?>" class="form-control">
							<?php if ($error_title) { ?>
								<div class="help-block error"><?= $error_title; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_meta_description; ?></label>
						<div class="control-field col-sm-4">
							<textarea name="config_meta_description" class="form-control" rows="3"><?= $config_meta_description; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_theme; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_theme" onchange="$('#theme').load('index.php?route=setting/store/theme&theme=' +encodeURIComponent(this.value));" class="form-control">
								<?php foreach ($themes as $theme) { ?>
									<?php if ($theme == $config_theme) { ?>
									<option value="<?= $theme; ?>" selected><?= $theme; ?></option>
									<?php } else { ?>
									<option value="<?= $theme; ?>"><?= $theme; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<div class="help-block" id="theme"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_layout; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_layout_id" class="form-control">
								<?php foreach ($layouts as $layout) { ?>
									<?php if ($layout['layout_id'] == $config_layout_id) { ?>
									<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-local">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_country; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_country_id" data-id="<?= $config_zone_id; ?>" data-none="<?= $lang_text_none; ?>" class="form-control">
								<?php foreach ($countries as $country) { ?>
									<?php if ($country['country_id'] == $config_country_id) { ?>
									<option value="<?= $country['country_id']; ?>" selected><?= $country['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $country['country_id']; ?>"><?= $country['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_zone; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_zone_id" class="form-control"></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_language; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_language" class="form-control">
								<?php foreach ($languages as $language) { ?>
									<?php if ($language['code'] == $config_language) { ?>
									<option value="<?= $language['code']; ?>" selected><?= $language['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $language['code']; ?>"><?= $language['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_currency; ?></label>
						<div class="control-field col-sm-4">
							<select name="config_currency" class="form-control">
								<?php foreach ($currencies as $currency) { ?>
									<?php if ($currency['code'] == $config_currency) { ?>
									<option value="<?= $currency['code']; ?>" selected><?= $currency['title']; ?></option>
									<?php } else { ?>
									<option value="<?= $currency['code']; ?>"><?= $currency['title']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div id="tab-option" class="tab-pane">
					<div>
						<ul class="nav nav-tabs">
							<li><a href="#tab-items" data-toggle="tab"><?= $lang_text_items; ?></a></li>
							<li><a href="#tab-tax" data-toggle="tab"><?= $lang_text_tax; ?></a></li>
							<li><a href="#tab-account" data-toggle="tab"><?= $lang_text_account; ?></a></li>
							<li><a href="#tab-checkout" data-toggle="tab"><?= $lang_text_checkout; ?></a></li>
							<li><a href="#tab-stock" data-toggle="tab"><?= $lang_text_stock; ?></a></li>
						</ul>
						<div class="tab-content">
							<div id="tab-items" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_catalog_limit; ?></label>
									<div class="control-field col-sm-4">
										<input type="text" name="config_catalog_limit" value="<?= $config_catalog_limit; ?>" class="form-control">
										<?php if ($error_catalog_limit) { ?>
											<div class="help-block error"><?= $error_catalog_limit; ?></div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div id="tab-tax" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_tax; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_tax) { ?>
										<label class="radio-inline"><input type="radio" name="config_tax" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_tax" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_tax" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_tax" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_tax_default; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_tax_default" class="form-control">
											<option value=""><?= $lang_text_none; ?></option>
											<?php	if ($config_tax_default == 'shipping') { ?>
											<option value="shipping" selected><?= $lang_text_shipping; ?></option>
											<?php } else { ?>
											<option value="shipping"><?= $lang_text_shipping; ?></option>
											<?php } ?>
											<?php	if ($config_tax_default == 'payment') { ?>
											<option value="payment" selected><?= $lang_text_payment; ?></option>
											<?php } else { ?>
											<option value="payment"><?= $lang_text_payment; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_tax_customer; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_tax_customer" class="form-control">
											<option value=""><?= $lang_text_none; ?></option>
											<?php	if ($config_tax_customer == 'shipping') { ?>
											<option value="shipping" selected><?= $lang_text_shipping; ?></option>
											<?php } else { ?>
											<option value="shipping"><?= $lang_text_shipping; ?></option>
											<?php } ?>
											<?php	if ($config_tax_customer == 'payment') { ?>
											<option value="payment" selected><?= $lang_text_payment; ?></option>
											<?php } else { ?>
											<option value="payment"><?= $lang_text_payment; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div id="tab-account" class="tab-pane">	
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_customer_group; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_customer_group_id" class="form-control">
											<?php foreach ($customer_groups as $customer_group) { ?>
												<?php if ($customer_group['customer_group_id'] == $config_customer_group_id) { ?>
												<option value="<?= $customer_group['customer_group_id']; ?>" selected><?= $customer_group['name']; ?></option>
												<?php } else { ?>
												<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_customer_group_display; ?></label>
									<div class="control-field col-sm-4">
										<div class="panel panel-default panel-scrollable">
											<div class="list-group">
											<?php foreach ($customer_groups as $customer_group) { ?>
												<label class="list-group-item">
													<?php if (in_array($customer_group['customer_group_id'], $config_customer_group_display)) { ?>
													<input type="checkbox" name="config_customer_group_display[]" value="<?= $customer_group['customer_group_id']; ?>" checked="">
													<?= $customer_group['name']; ?>
													<?php } else { ?>
													<input type="checkbox" name="config_customer_group_display[]" value="<?= $customer_group['customer_group_id']; ?>">
													<?= $customer_group['name']; ?>
													<?php } ?>
												</label>
											<?php } ?>
											</div>
										</div>
										<?php if ($error_customer_group_display) { ?>
											<div class="help-block error"><?= $error_customer_group_display; ?></div>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_customer_price; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_customer_price) { ?>
										<label class="radio-inline"><input type="radio" name="config_customer_price" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_customer_price" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_customer_price" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_customer_price" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_account; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_account_id" class="form-control">
											<option value="0"><?= $lang_text_none; ?></option>
											<?php foreach ($pages as $page) { ?>
												<?php if ($page['page_id'] == $config_account_id) { ?>
												<option value="<?= $page['page_id']; ?>" selected><?= $page['title']; ?></option>
												<?php } else { ?>
												<option value="<?= $page['page_id']; ?>"><?= $page['title']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div id="tab-checkout" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_cart_weight; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_cart_weight) { ?>
										<label class="radio-inline"><input type="radio" name="config_cart_weight" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_cart_weight" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_cart_weight" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_cart_weight" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_guest_checkout; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_guest_checkout) { ?>
										<label class="radio-inline"><input type="radio" name="config_guest_checkout" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_guest_checkout" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_guest_checkout" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_guest_checkout" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_checkout; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_checkout_id" class="form-control">
											<option value="0"><?= $lang_text_none; ?></option>
											<?php foreach ($pages as $page) { ?>
												<?php if ($page['page_id'] == $config_checkout_id) { ?>
												<option value="<?= $page['page_id']; ?>" selected><?= $page['title']; ?></option>
												<?php } else { ?>
												<option value="<?= $page['page_id']; ?>"><?= $page['title']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_order_status; ?></label>
									<div class="control-field col-sm-4">
										<select name="config_order_status_id" class="form-control">
											<?php foreach ($order_statuses as $order_status) { ?>
												<?php if ($order_status['order_status_id'] == $config_order_status_id) { ?>
												<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
												<?php } else { ?>
												<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div id="tab-stock" class="tab-pane">
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_stock_display; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_stock_display) { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_display" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_display" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_display" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_display" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2"><?= $lang_entry_stock_checkout; ?></label>
									<div class="control-field col-sm-4">
										<?php if ($config_stock_checkout) { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_checkout" value="1" checked=""><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_checkout" value="0"><?= $lang_text_no; ?></label>
										<?php } else { ?>
										<label class="radio-inline"><input type="radio" name="config_stock_checkout" value="1"><?= $lang_text_yes; ?></label>
										<label class="radio-inline"><input type="radio" name="config_stock_checkout" value="0" checked=""><?= $lang_text_no; ?></label>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-image">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_logo; ?></label>
						<div class="control-field col-sm-4">
							<div class="media">
								<a class="pull-left" onclick="image_upload('logo','thumb-logo');"><img class="img-thumbnail" src="<?= $logo; ?>" width="100" height="100" alt="" id="thumb-logo"></a>
								<input type="hidden" name="config_logo" value="<?= $config_logo; ?>" id="logo">
								<div class="media-body hidden-xs">
									<a class="btn btn-default" onclick="image_upload('logo','thumb-logo');"><?= $lang_text_browse; ?></a>&nbsp;
									<a class="btn btn-default" onclick="$('#thumb-logo').attr('src', '<?= $no_image; ?>'); $('#logo').val('');"><?= $lang_text_clear; ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_icon; ?></label>
						<div class="control-field col-sm-4">
							<div class="media">
								<a class="pull-left" onclick="image_upload('icon','thumb-icon');"><img class="img-thumbnail" src="<?= $icon; ?>" width="100" height="100" alt="" id="thumb-icon"></a>
								<input type="hidden" name="config_icon" value="<?= $config_icon; ?>" id="icon">
								<div class="media-body hidden-xs">
									<a class="btn btn-default" onclick="image_upload('icon','thumb-icon');"><?= $lang_text_browse; ?></a>&nbsp;
									<a class="btn btn-default" onclick="$('#thumb-icon').attr('src', '<?= $no_image; ?>'); $('#icon').val('');"><?= $lang_text_clear; ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_category; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_category_width" value="<?= $config_image_category_width; ?>" class="form-control"> <input type="text" name="config_image_category_height" value="<?= $config_image_category_height; ?>" class="form-control">
							<?php if ($error_image_category) { ?>
								<div class="help-block error"><?= $error_image_category; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_thumb; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_thumb_width" value="<?= $config_image_thumb_width; ?>" class="form-control"> <input type="text" name="config_image_thumb_height" value="<?= $config_image_thumb_height; ?>" class="form-control">
							<?php if ($error_image_thumb) { ?>
								<div class="help-block error"><?= $error_image_thumb; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_popup; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_popup_width" value="<?= $config_image_popup_width; ?>" class="form-control"> <input type="text" name="config_image_popup_height" value="<?= $config_image_popup_height; ?>" class="form-control">
							<?php if ($error_image_popup) { ?>
								<div class="help-block error"><?= $error_image_popup; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_product; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_product_width" value="<?= $config_image_product_width; ?>" class="form-control"> <input type="text" name="config_image_product_height" value="<?= $config_image_product_height; ?>" class="form-control">
							<?php if ($error_image_product) { ?>
								<div class="help-block error"><?= $error_image_product; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_additional; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_additional_width" value="<?= $config_image_additional_width; ?>" class="form-control"> <input type="text" name="config_image_additional_height" value="<?= $config_image_additional_height; ?>" class="form-control">
							<?php if ($error_image_additional) { ?>
								<div class="help-block error"><?= $error_image_additional; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_related; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_related_width" value="<?= $config_image_related_width; ?>" class="form-control"> <input type="text" name="config_image_related_height" value="<?= $config_image_related_height; ?>" class="form-control">
							<?php if ($error_image_related) { ?>
								<div class="help-block error"><?= $error_image_related; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_compare; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_compare_width" value="<?= $config_image_compare_width; ?>" class="form-control"> <input type="text" name="config_image_compare_height" value="<?= $config_image_compare_height; ?>" class="form-control">
							<?php if ($error_image_compare) { ?>
								<div class="help-block error"><?= $error_image_compare; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_wishlist; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_wishlist_width" value="<?= $config_image_wishlist_width; ?>" class="form-control"> <input type="text" name="config_image_wishlist_height" value="<?= $config_image_wishlist_height; ?>" class="form-control">
							<?php if ($error_image_wishlist) { ?>
								<div class="help-block error"><?= $error_image_wishlist; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_image_cart; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="config_image_cart_width" value="<?= $config_image_cart_width; ?>" class="form-control"> <input type="text" name="config_image_cart_height" value="<?= $config_image_cart_height; ?>" class="form-control">
							<?php if ($error_image_cart) { ?>
								<div class="help-block error"><?= $error_image_cart; ?></div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-server">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_secure; ?></label>
						<div class="control-field col-sm-4">
							<?php if ($config_secure) { ?>
							<label class="radio-inline"><input type="radio" name="config_secure" value="1" checked=""><?= $lang_text_yes; ?></label>
							<label class="radio-inline"><input type="radio" name="config_secure" value="0"><?= $lang_text_no; ?></label>
							<?php } else { ?>
							<label class="radio-inline"><input type="radio" name="config_secure" value="1"><?= $lang_text_yes; ?></label>
							<label class="radio-inline"><input type="radio" name="config_secure" value="0" checked=""><?= $lang_text_no; ?></label>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?= $lang_text_image_manager; ?></h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning btn-block" data-dismiss="modal"><?= $lang_button_cancel; ?></button>
			</div>
		</div>
	</div>
</div>
<?= $footer; ?>