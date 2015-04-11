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
			<div class="pull-left h2"><i class="hidden-xs fa fa-user"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li>
			<?php if ($customer_id) { ?>
			<li><a href="#tab-credit" data-toggle="tab"><?= $lang_tab_credit; ?></a></li>
			<li><a href="#tab-reward" data-toggle="tab"><?= $lang_tab_reward; ?></a></li>
			<?php if ($is_affiliate): ?>
			<li><a href="#tab-affiliate" data-toggle="tab"><?= $lang_tab_affiliate; ?></a></li>
			<li><a href="#tab-commission" data-toggle="tab"><?= $lang_tab_commission; ?></a></li>
			<?php endif; ?>
			<?php } ?>
			<li><a href="#tab-ip" data-toggle="tab"><?= $lang_tab_ip; ?></a></li>
		</ul>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="tab-content">
				<div class="tab-pane" id="tab-general">
					<div class="row">
						<div class="col-sm-2">
							<div class="tabs-left">
								<ul id="vtab-address" class="nav nav-tabs"><li><a href="#tab-customer" data-toggle="tab"><?= $lang_tab_general; ?></a></li>
									<?php $address_row = 1; ?>
									<?php foreach ($addresses as $address) { ?>
									<li><a href="#tab-address-<?= $address_row; ?>" id="address-<?= $address_row; ?>" data-toggle="tab">
										<span class="label label-danger" onclick="$('#tab-general .nav-tabs a:first').trigger('click');$('#address-<?= $address_row; ?>').remove();$('#tab-address-<?= $address_row; ?>').remove();return false;"><i class="fa fa-trash-o"></i></span>
										<?= $lang_tab_address . ' ' . $address_row; ?>
									</a></li>
									<?php $address_row++; ?>
									<?php } ?>
									<li class="action" id="address-add">
										<button type="button" id="address-button" class="btn btn-info btn-block"><i class="fa fa-plus-circle"></i>&nbsp;<?= $lang_button_add_address; ?></button>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-sm-10">
							<div class="tab-content" id="customer-content">
								<div class="tab-pane" id="tab-customer">
									<div class="form-group">
										<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_referrer; ?></label>
										<div class="control-field col-sm-4">
											<?php if ($referrer): ?>
											<p class="form-control-static"><?= $referrer['firstname']; ?> <?= $referrer['lastname']; ?> ( <a href="<?= $referrer['href']; ?>"><?= $referrer['username']; ?></a> )</p>
											<?php else: ?>
											<p class="form-control-static"><?= $lang_text_no_referrer; ?></p>
											<?php endif; ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_username; ?></label>
										<div class="control-field col-sm-4">
											<input type="text" name="username" value="<?= $username; ?>" class="form-control">
											<?php if ($error_username) { ?>
												<div class="help-block error"><?= $error_username; ?></div>
											<?php } ?>
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
											<?php	} ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_telephone; ?></label>
										<div class="control-field col-sm-4">
											<input type="text" name="telephone" value="<?= $telephone; ?>" class="form-control">
											<?php if ($error_telephone) { ?>
												<div class="help-block error"><?= $error_telephone; ?></div>
											<?php	} ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2"><?= $lang_entry_password; ?></label>
										<div class="control-field col-sm-4">
											<input type="password" name="password" value="<?= $password; ?>" class="form-control">
											<?php if ($error_password) { ?>
												<div class="help-block error"><?= $error_password; ?></div>
											<?php	} ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2"><?= $lang_entry_confirm; ?></label>
										<div class="control-field col-sm-4">
											<input type="password" name="confirm" value="<?= $confirm; ?>" class="form-control">
											<?php if ($error_confirm) { ?>
												<div class="help-block error"><?= $error_confirm; ?></div>
											<?php	} ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2"><?= $lang_entry_newsletter; ?></label>
										<div class="control-field col-sm-4">
											<select name="newsletter" class="form-control">
												<?php if ($newsletter) { ?>
												<option value="1" selected><?= $lang_text_enabled; ?></option>
												<option value="0"><?= $lang_text_disabled; ?></option>
												<?php } else { ?>
												<option value="1"><?= $lang_text_enabled; ?></option>
												<option value="0" selected><?= $lang_text_disabled; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2"><?= $lang_entry_customer_group; ?></label>
										<div class="control-field col-sm-4">
											<select name="customer_group_id" onchange="groupToggle();" class="form-control">
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
										<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
										<div class="control-field col-sm-4">
											<select name="status" class="form-control">
												<?php if ($status) { ?>
													<option value="1" selected><?= $lang_text_enabled; ?></option>
													<option value="0"><?= $lang_text_disabled; ?></option>
												<?php } else { ?>
													<option value="1"><?= $lang_text_enabled; ?></option>
													<option value="0" selected><?= $lang_text_disabled; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<?php $address_row = 1; ?>
								<?php foreach ($addresses as $address) { ?>
									<div class="tab-pane" id="tab-address-<?= $address_row; ?>">
										<input type="hidden" name="address[<?= $address_row; ?>][address_id]" value="<?= $address['address_id']; ?>">
										<div class="form-group">
											<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="address[<?= $address_row; ?>][firstname]" value="<?= $address['firstname']; ?>" class="form-control">
												<?php if (isset($error_address_firstname[$address_row])) { ?>
													<div class="help-block error"><?= $error_address_firstname[$address_row]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="address[<?= $address_row; ?>][lastname]" value="<?= $address['lastname']; ?>" class="form-control">
												<?php if (isset($error_address_lastname[$address_row])) { ?>
													<div class="help-block error"><?= $error_address_lastname[$address_row]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"><?= $lang_entry_company; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="address[<?= $address_row; ?>][company]" value="<?= $address['company']; ?>" class="form-control">
											</div>
										</div>
										<div class="form-group company-id-display">
											<label class="control-label col-sm-2"><?= $lang_entry_company_id; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="address[<?= $address_row; ?>][company_id]" value="<?= $address['company_id']; ?>" class="form-control">
											</div>
										</div>
										<div class="form-group tax-id-display">
											<label class="control-label col-sm-2"><?= $lang_entry_tax_id; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="address[<?= $address_row; ?>][tax_id]" value="<?= $address['tax_id']; ?>" class="form-control">
												<?php if (isset($error_address_tax_id[$address_row])) { ?>
													<div class="help-block error"><?= $error_address_tax_id[$address_row]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_address_1; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="address[<?= $address_row; ?>][address_1]" value="<?= $address['address_1']; ?>" class="form-control">
												<?php if (isset($error_address_address_1[$address_row])) { ?>
													<div class="help-block error"><?= $error_address_address_1[$address_row]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"><?= $lang_entry_address_2; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="address[<?= $address_row; ?>][address_2]" value="<?= $address['address_2']; ?>" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_city; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="address[<?= $address_row; ?>][city]" value="<?= $address['city']; ?>" class="form-control">
												<?php if (isset($error_address_city[$address_row])) { ?>
													<div class="help-block error"><?= $error_address_city[$address_row]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"><span id="postcode-required<?= $address_row; ?>" class="required">*</span> <?= $lang_entry_postcode; ?></label>
											<div class="control-field col-sm-4">
												<input type="text" name="address[<?= $address_row; ?>][postcode]" value="<?= $address['postcode']; ?>" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_country; ?></label>
											<div class="control-field col-sm-4">
												<select name="address[<?= $address_row; ?>][country_id]" onchange="country(this,'<?= $address_row; ?>','<?= $address['zone_id']; ?>');" class="form-control">
														<option value=""><?= $lang_text_select; ?></option>
													<?php foreach ($countries as $country) { ?>
														<?php if ($country['country_id'] == $address['country_id']) { ?>
														<option value="<?= $country['country_id']; ?>" selected><?= $country['name']; ?></option>
														<?php } else { ?>
														<option value="<?= $country['country_id']; ?>"><?= $country['name']; ?></option>
														<?php } ?>
													<?php } ?>
												</select>
												<?php if (isset($error_address_country[$address_row])) { ?>
													<div class="help-block error"><?= $error_address_country[$address_row]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_zone; ?></label>
											<div class="control-field col-sm-4">
												<select name="address[<?= $address_row; ?>][zone_id]" class="form-control">
												</select>
												<?php if (isset($error_address_zone[$address_row])) { ?>
													<div class="help-block error"><?= $error_address_zone[$address_row]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="default<?= $address_row; ?>"><?= $lang_entry_default; ?></label>
											<div class="control-field col-sm-4">
												<label class="radio-inline"><?php if (($address['address_id'] == $address_id) || !$addresses) { ?>
													<input type="radio" name="address[<?= $address_row; ?>][default]" value="<?= $address_row; ?>" id="default<?= $address_row; ?>" checked="">
												<?php } else { ?>
													<input type="radio" name="address[<?= $address_row; ?>][default]" value="<?= $address_row; ?>" id="default<?= $address_row; ?>">
												<?php } ?></label>
											</div>
										</div>
									</div>
									<?php $address_row++; ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<?php if ($customer_id) { ?>
					<div class="tab-pane" id="tab-credit">
						<div id="credit" data-href="index.php?route=people/customer/credit&token=<?= $token; ?>&customer_id=<?= $customer_id; ?>"></div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_description; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="description" value="" class="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_amount; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="amount" value="" class="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="control-field col-sm-4 col-sm-offset-2">
								<button type="button" id="button-credit" data-target="customer" data-id="<?= $customer_id; ?>" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= $lang_button_add_credit; ?></button>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab-reward">
						<div id="reward" data-href="index.php?route=people/customer/reward&token=<?= $token; ?>&customer_id=<?= $customer_id; ?>"></div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_description; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="description" value="" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_points; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="points" value="" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="control-field col-sm-4 col-sm-offset-2">
								<button type="button" id="button-reward" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= $lang_button_add_reward; ?></button>
							</div>
						</div>
					</div>
					<?php if ($is_affiliate): ?>
					<div class="tab-pane" id="tab-affiliate">
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_affiliate_status; ?></label>
							<div class="control-field col-sm-4">
								<?php if ($affiliate['affiliate_status']): ?>
									<label class="radio-inline"><input type="radio" name="affiliate[affiliate_status]" value="1" checked><?= $lang_text_enabled; ?></label>
									<label class="radio-inline"><input type="radio" name="affiliate[affiliate_status]" value="0"><?= $lang_text_disabled; ?></label>
								<?php else: ?>
									<label class="radio-inline"><input type="radio" name="affiliate[affiliate_status]" value="1"><?= $lang_text_enabled; ?></label>
									<label class="radio-inline"><input type="radio" name="affiliate[affiliate_status]" value="0" checked><?= $lang_text_disabled; ?></label>
								<?php endif; ?>
								<input type="hidden" name="is_affiliate" value="<?= $is_affiliate; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_company; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="affiliate[company]" value="<?= $affiliate['company']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_website; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="affiliate[website]" value="<?= $affiliate['website']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_code; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="affiliate[code]" value="<?= $affiliate['code']; ?>" class="form-control">
								<?php if ($error_code): ?>
									<div class="help-block error"><?= $error_code; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="commission"><b class="required">*</b> <?= $lang_entry_commission; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="affiliate[commission]" value="<?= $affiliate['commission']; ?>" class="form-control">
								<?php if ($error_commission): ?>
									<div class="help-block error"><?= $error_commission; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="tax_id"><b class="required">*</b> <?= $lang_entry_tax_id; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="affiliate[tax_id]" value="<?= $affiliate['tax_id']; ?>" class="form-control">
								<?php if ($error_tax_id): ?>
									<div class="help-block error"><?= $error_tax_id; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_payment_method; ?></label>
							<div class="control-field col-sm-4">
								<?php if ($affiliate['payment_method'] == 'cheque') { ?>
									<label class="radio-inline"><input type="radio" name="affiliate[payment_method]" value="cheque" checked><?= $lang_text_cheque; ?></label>
								<?php } else { ?>
									<label class="radio-inline"><input type="radio" name="affiliate[payment_method]" value="cheque"><?= $lang_text_cheque; ?></label>
								<?php } ?>
								<?php if ($affiliate['payment_method'] == 'paypal') { ?>
									<label class="radio-inline"><input type="radio" name="affiliate[payment_method]" value="paypal" checked><?= $lang_text_paypal; ?></label>
								<?php } else { ?>
									<label class="radio-inline"><input type="radio" name="affiliate[payment_method]" value="paypal"><?= $lang_text_paypal; ?></label>
								<?php } ?>
								<?php if ($affiliate['payment_method'] == 'bank') { ?>
									<label class="radio-inline"><input type="radio" name="affiliate[payment_method]" value="bank" checked><?= $lang_text_bank; ?></label>
								<?php } else { ?>
									<label class="radio-inline"><input type="radio" name="affiliate[payment_method]" value="bank"><?= $lang_text_bank; ?></label>
								<?php } ?>
								<?php if ($error_payment): ?>
									<div class="help-block error"><?= $error_payment; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div id="payment-cheque" class="payment form-group">
							<label class="control-label col-sm-2" for="cheque"><b class="required">*</b> <?= $lang_entry_cheque; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="affiliate[cheque]" value="<?= $affiliate['cheque']; ?>" class="form-control">
								<?php if ($error_cheque): ?>
									<div class="help-block error"><?= $error_cheque; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div id="payment-paypal" class="payment form-group">
							<label class="control-label col-sm-2" for="paypal"><b class="required">*</b> <?= $lang_entry_paypal; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="affiliate[paypal]" value="<?= $affiliate['paypal']; ?>" class="form-control">
								<?php if ($error_paypal): ?>
									<div class="help-block error"><?= $error_paypal; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div id="payment-bank" class="payment">
							<div class="form-group">
								<label class="control-label col-sm-2" for="bank_name"><b class="required">*</b> <?= $lang_entry_bank_name; ?></label>
								<div class="control-field col-sm-4">
									<input type="text" name="affiliate[bank_name]" value="<?= $affiliate['bank_name']; ?>" class="form-control">
									<?php if ($error_bank_name): ?>
									<div class="help-block error"><?= $error_bank_name; ?></div>
								<?php endif; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="bank_branch_number"><?= $lang_entry_bank_branch_number; ?></label>
								<div class="control-field col-sm-4">
									<input type="text" name="affiliate[bank_branch_number]" value="<?= $affiliate['bank_branch_number']; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="bank_swift_code"><?= $lang_entry_bank_swift_code; ?></label>
								<div class="control-field col-sm-4">
									<input type="text" name="affiliate[bank_swift_code]" value="<?= $affiliate['bank_swift_code']; ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="bank_account_name"><b class="required">*</b> <?= $lang_entry_bank_account_name; ?></label>
								<div class="control-field col-sm-4">
									<input type="text" name="affiliate[bank_account_name]" value="<?= $affiliate['bank_account_name']; ?>" class="form-control">
									<?php if ($error_account_name): ?>
									<div class="help-block error"><?= $error_account_name; ?></div>
								<?php endif; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="bank_account_number"><b class="required">*</b> <?= $lang_entry_bank_account_number; ?></label>
								<div class="control-field col-sm-4">
									<input type="text" name="affiliate[bank_account_number]" value="<?= $affiliate['bank_account_number']; ?>" class="form-control">
									<?php if ($error_account_number): ?>
									<div class="help-block error"><?= $error_account_number; ?></div>
								<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab-commission">
						<div id="commission" data-href="index.php?route=people/customer/commission&token=<?= $token; ?>&customer_id=<?= $customer_id; ?>"></div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_description; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="description" value="" class="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_amount; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="amount" value="" class="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="control-field col-sm-4 col-sm-offset-2">
								<a id="button-commission" class="btn btn-info" data-target="customer" data-id="<?= $customer_id; ?>"><i class="fa fa-plus-circle"></i> <?= $lang_button_add_commission; ?></a>
							</div>
						</div>
					</div>
					<?php endif; ?>
				<?php } ?>
				<div class="tab-pane" id="tab-ip">
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th><?= $lang_column_ip; ?></th>
								<th class="text-right"><?= $lang_column_total; ?></th>
								<th class="hidden-xs"><?= $lang_column_date_added; ?></th>
								<th class="col-sm-4 text-right"><?= $lang_column_action; ?></th>
							</tr>
						</thead>
						<tbody>
						<?php if ($ips) { ?>
						<?php foreach ($ips as $ip) { ?>
							<tr>
								<td><a href="http://www.geoiptool.com/en/?IP=<?= $ip['ip']; ?>" target="_blank"><?= $ip['ip']; ?></a></td>
								<td class="text-right"><a href="<?= $ip['filter_ip']; ?>" target="_blank"><?= $ip['total']; ?></a></td>
								<td class="hidden-xs"><?= $ip['date_added']; ?></td>
								<td class="text-right"><?php if ($ip['ban_ip']) { ?>
									<span class="bracket"><a id="<?= str_replace('.', '-', $ip['ip']); ?>" onclick="removeBanIP('<?= $ip['ip']; ?>');"><?= $lang_text_remove_ban_ip; ?></a></span>
									<?php } else { ?>
									<span class="bracket"><a id="<?= str_replace('.', '-', $ip['ip']); ?>" onclick="addBanIP('<?= $ip['ip']; ?>');"><?= $lang_text_add_ban_ip; ?></a></span>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
						<?php } else { ?>
							<tr>
								<td class="text-center" colspan="4"><?= $lang_text_no_results; ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<script>var address_row = <?= $address_row; ?>;</script>
<?= $footer; ?>