<?= $header; ?>
<?php if ($error_warning): ?>
<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $error_warning; ?></div>
<?php endif; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">&times;</a><?= $text_account_already; ?></div>
		<?php $count = 0; ?>
		<form class="form-horizontal" id="register-form" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
			<h3><?php $count++; echo $count; ?></h3>
			<fieldset>
				<legend><?= $lang_text_your_details; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-3" for="username"><b class="required">*</b> <?= $lang_entry_username; ?></label>
					<div class="col-sm-8">
						<input type="text" name="username" value="<?= $username; ?>" class="form-control" placeholder="<?= $lang_entry_username; ?>" autofocus id="username" required>
						<?php if ($error_username) { ?>
						<span class="help-block error"><?= $error_username; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="firstname"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
					<div class="col-sm-8">
						<input type="text" name="firstname" value="<?= $firstname; ?>" class="form-control" placeholder="<?= $lang_entry_firstname; ?>" id="firstname" required>
						<?php if ($error_firstname) { ?>
						<span class="help-block error"><?= $error_firstname; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="lastname"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
					<div class="col-sm-8">
						<input type="text" name="lastname" value="<?= $lastname; ?>" class="form-control" placeholder="<?= $lang_entry_lastname; ?>"  id="lastname" required>
						<?php if ($error_lastname) { ?>
						<span class="help-block error"><?= $error_lastname; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="email"><b class="required">*</b> <?= $lang_entry_email; ?></label>
					<div class="col-sm-8">
						<input type="text" name="email" value="<?= $email; ?>" class="form-control" placeholder="<?= $lang_entry_email; ?>"  id="email" required>
						<?php if ($error_email) { ?>
						<span class="help-block error"><?= $error_email; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="password"><b class="required">*</b> <?= $lang_entry_password; ?></label>
					<div class="col-sm-8">
						<input type="password" name="password" value="<?= $password; ?>" class="form-control" placeholder="<?= $lang_entry_password; ?>"  id="password" required>
						<?php if ($error_password) { ?>
						<span class="help-block error"><?= $error_password; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="confirm"><b class="required">*</b> <?= $lang_entry_confirm; ?></label>
					<div class="col-sm-8">
						<input type="password" name="confirm" value="<?= $confirm; ?>" class="form-control" placeholder="<?= $lang_entry_confirm; ?>"  id="confirm" required>
						<?php if ($error_confirm) { ?>
						<span class="help-block error"><?= $error_password; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="telephone"><b class="required">*</b> <?= $lang_entry_telephone; ?></label>
					<div class="col-sm-8">
						<input type="text" name="telephone" value="<?= $telephone; ?>" class="form-control" placeholder="<?= $lang_entry_telephone; ?>"  id="telephone" required>
						<?php if ($error_telephone) { ?>
						<span class="help-block error"><?= $error_telephone; ?></span>
						<?php } ?>
					</div>
				</div>
			</fieldset>
			<h3><?php $count++; echo $count; ?></h3>
			<fieldset>
				<legend><?= $lang_text_your_address; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-3" for="company"><?= $lang_entry_company; ?></label>
					<div class="col-sm-8">
						<input type="text" name="company" value="<?= $company; ?>" class="form-control" placeholder="<?= $lang_entry_company; ?>"  id="company">
					</div>
				</div>
				<div class="form-group<?= (count($customer_groups) > 1 ? '' : ' hide'); ?>">
					<label class="control-label col-sm-3" for="customer_group_id"><?= $lang_entry_customer_group; ?></label>
					<div class="col-sm-8">
						<select name="customer_group_id" class="form-control col-sm-3" id="customer_group_id">
							<?php foreach ($customer_groups as $customer_group) { ?>
							<?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
							<option value="<?= $customer_group['customer_group_id']; ?>" selected=""><?= $customer_group['name']; ?></option>
							<?php } else { ?>
							<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group" id="company-id-display">
					<label class="control-label col-sm-3" for="company_id"><b id="company-id-required" class="required">*</b> <?= $lang_entry_company_id; ?></label>
					<div class="col-sm-8">
						<input type="text" name="company_id" value="<?= $company_id; ?>" class="form-control" placeholder="<?= $lang_entry_company_id; ?>"  id="company_id">
						<?php if ($error_company_id) { ?>
						<span class="help-block error"><?= $error_company_id; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group" id="tax-id-display">
					<label class="control-label col-sm-3" for="tax_id"><b id="tax-id-required" class="required">*</b> <?= $lang_entry_tax_id; ?></label>
					<div class="col-sm-8">
						<input type="text" name="tax_id" value="<?= $tax_id; ?>" class="form-control" placeholder="<?= $lang_entry_tax_id; ?>"  id="tax_id">
						<?php if ($error_tax_id) { ?>
						<span class="help-block error"><?= $error_tax_id; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="address_1"><b class="required">*</b> <?= $lang_entry_address_1; ?></label>
					<div class="col-sm-8">
						<input type="text" name="address_1" value="<?= $address_1; ?>" class="form-control" placeholder="<?= $lang_entry_address_1; ?>"  id="address_1" required>
						<?php if ($error_address_1) { ?>
						<span class="help-block error"><?= $error_address_1; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="address_2"><?= $lang_entry_address_2; ?></label>
					<div class="col-sm-8">
						<input type="text" name="address_2" value="<?= $address_2; ?>" class="form-control" placeholder="<?= $lang_entry_address_2; ?>"  id="address_2">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="city"><b class="required">*</b> <?= $lang_entry_city; ?></label>
					<div class="col-sm-8">
						<input type="text" name="city" value="<?= $city; ?>" class="form-control" placeholder="<?= $lang_entry_city; ?>"  id="city" required>
						<?php if ($error_city) { ?>
						<span class="help-block error"><?= $error_city; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="postcode"><b class="required">*</b> <?= $lang_entry_postcode; ?></label>
					<div class="col-sm-8">
						<input type="text" name="postcode" value="<?= $postcode; ?>" class="form-control" placeholder="<?= $lang_entry_postcode; ?>"  id="postcode" required>
						<?php if ($error_postcode) { ?>
						<span class="help-block error"><?= $error_postcode; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3"><b class="required">*</b> <?= $lang_entry_country; ?></label>
					<div class="col-sm-8">
						<select name="country_id" class="form-control" data-param="<?= htmlentities('{"zone_id":"' . $zone_id . '","select":"' . $lang_text_select . '","none":"' . $lang_text_none . '"}'); ?>" required>
							<option value=""><?= $lang_text_select; ?></option>
							<?php foreach ($countries as $country) { ?>
							<?php if ($country['country_id'] == $country_id) { ?>
							<option value="<?= $country['country_id']; ?>" selected=""><?= $country['name']; ?></option>
							<?php } else { ?>
							<option value="<?= $country['country_id']; ?>"><?= $country['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select>
						<?php if ($error_country) { ?>
						<span class="help-block error"><?= $error_country; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3"><b class="required">*</b> <?= $lang_entry_zone; ?></label>
					<div class="col-sm-8">
						<select name="zone_id" class="form-control" required></select>
						<?php if ($error_zone) { ?>
						<span class="help-block error"><?= $error_zone; ?></span>
						<?php } ?>
					</div>
				</div>
			</fieldset>
			<?php if ($affiliate_allowed): ?>
			<h3><?php $count++; echo $count; ?></h3>
			<fieldset>
				<legend><?= $lang_text_be_affiliate; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-3" for="status"><span class="required">*</span> <?= $lang_entry_status; ?></label>
					<div class="col-sm-8">
						<?php if ($affiliate['status']): ?>
						<div class="radio radio-inline"><label><input type="radio" name="affiliate[status]" value="1" checked><?= $lang_text_yes; ?></label></div>
						<div class="radio radio-inline"><label><input type="radio" name="affiliate[status]" value="0"> <?= $lang_text_no; ?></label></div>
						<?php else: ?>
						<div class="radio radio-inline"><label><input type="radio" name="affiliate[status]" value="1"> <?= $lang_text_yes; ?></label></div>
						<div class="radio radio-inline"><label><input type="radio" name="affiliate[status]" value="0" checked> <?= $lang_text_no; ?></label></div>
						<?php endif; ?>
					</div>
				</div>
				<hr>
				<div id="affiliate-panel">
					<div class="form-group">
						<label class="control-label col-sm-3" for="website"><?= $lang_entry_website; ?></label>
						<div class="col-sm-8">
							<input type="text" name="affiliate[website]" value="<?= $affiliate['website']; ?>" class="form-control" id="website">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="tax"><span class="required">*</span> <?= $lang_entry_tax; ?></label>
						<div class="col-sm-8">
							<input type="text" name="affiliate[tax]" value="<?= $affiliate['tax']; ?>" class="form-control" id="tax" required>
							<?php if ($error_tax): ?>
								<div class="help-block error"><?= $error_tax; ?></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3"><span class="required">*</span> <?= $lang_entry_slug; ?></label>
						<div class="control-field col-sm-8">
							<input type="text" name="affiliate[slug]" value="<?= $affiliate['slug']; ?>" id="slug" class="form-control">
							<?php if ($error_slug): ?>
							<span class="help-block error"><?= $error_slug; ?></span>
							<?php endif; ?>
							<br>
							<div class="alert alert-info">
								<?= $vanity_base; ?><span id="vanity"><?= $affiliate['slug']; ?></span>
							</div>
						</div>
					</div>
					<div class="form-group" id="tab-payment">
						<label class="control-label col-sm-3"><span class="required">*</span> <?= $lang_entry_payment; ?></label>
						<div class="col-sm-8">
							<div class="radio radio-inline">
								<?php if (!$affiliate['payment_method']) $affiliate['payment_method'] = 'cheque'; ?>
								<label>
									<input type="radio" name="affiliate[payment_method]" value="cheque"<?= ($affiliate['payment_method'] == 'cheque') ? ' checked' : ''; ?>> <?= $lang_text_cheque; ?>
								</label>
							</div>
							<div class="radio radio-inline">
								<label>
									<input type="radio" name="affiliate[payment_method]" value="paypal"<?= ($affiliate['payment_method'] == 'paypal') ? ' checked' : ''; ?>> <?= $lang_text_paypal; ?>
								</label>
							</div>
							<div class="radio radio-inline">
								<label>
									<input type="radio" name="affiliate[payment_method]" value="bank"<?= ($affiliate['payment_method'] == 'bank') ? ' checked' : ''; ?>> <?= $lang_text_bank; ?>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group payment" id="payment-cheque">
						<label class="control-label col-sm-3" for="cheque"><span class="required">*</span> <?= $lang_entry_cheque; ?></label>
						<div class="col-sm-8">
							<input type="text" name="affiliate[cheque]" value="<?= $affiliate['cheque']; ?>" class="form-control" id="cheque">
							<?php if ($error_cheque): ?>
								<div class="help-block error"><?= $error_cheque; ?></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group payment" id="payment-paypal">
						<label class="control-label col-sm-3" for="paypal"><span class="required">*</span> <?= $lang_entry_paypal; ?></label>
						<div class="col-sm-8">
							<input type="text" name="affiliate[paypal]" value="<?= $affiliate['paypal']; ?>" class="form-control" id="paypal">
							<?php if ($error_paypal): ?>
							<div class="help-block error"><?= $error_paypal; ?></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="payment" id="payment-bank">
						<div class="form-group">
							<label class="control-label col-sm-3" for="bank_name"><span class="required">*</span> <?= $lang_entry_bank_name; ?></label>
							<div class="col-sm-8">
								<input type="text" name="affiliate[bank_name]" value="<?= $affiliate['bank_name']; ?>" class="form-control" id="bank_name">
								<?php if ($error_bank_name): ?>
								<div class="help-block error"><?= $error_bank_name; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="bank_branch_number"><?= $lang_entry_bank_branch_number; ?></label>
							<div class="col-sm-8">
								<input type="text" name="affiliate[bank_branch_number]" value="<?= $affiliate['bank_branch_number']; ?>" class="form-control" id="bank_branch_number">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="bank_swift_code"><?= $lang_entry_bank_swift_code; ?></label>
							<div class="col-sm-8">
								<input type="text" name="affiliate[bank_swift_code]" value="<?= $affiliate['bank_swift_code']; ?>" class="form-control" id="bank_swift_code">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="bank_account_name"><span class="required">*</span> <?= $lang_entry_bank_account_name; ?></label>
							<div class="col-sm-8">
								<input type="text" name="affiliate[bank_account_name]" value="<?= $affiliate['bank_account_name']; ?>" class="form-control" id="bank_account_name">
								<?php if ($error_bank_account_name): ?>
								<div class="help-block error"><?= $error_bank_account_name; ?></div>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="bank_account_number"><span class="required">*</span> <?= $lang_entry_bank_account_number; ?></label>
							<div class="col-sm-8">
								<input type="text" name="affiliate[bank_account_number]" value="<?= $affiliate['bank_account_number']; ?>" class="form-control" id="bank_account_number">
								<?php if ($error_bank_account_number): ?>
								<div class="help-block error"><?= $error_bank_account_number; ?></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<?php endif; ?>
			<h3><?php $count++; echo $count; ?></h3>
			<fieldset>
				<legend><?= $lang_text_agreements; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-4"><?= $lang_entry_newsletter; ?></label>
					<div class="col-sm-7">
						<?php if ($newsletter) { ?>
						<div class="radio radio-inline">
						<label><input type="radio" name="newsletter" value="1" checked> <?= $lang_text_yes; ?></label>
						</div>
						<div class="radio radio-inline">
						<label><input type="radio" name="newsletter" value="0"> <?= $lang_text_no; ?></label>
						</div>
						<?php } else { ?>
						<div class="radio radio-inline">
						<label><input type="radio" name="newsletter" value="1"> <?= $lang_text_yes; ?></label>
						</div>
						<div class="radio radio-inline">
						<label><input type="radio" name="newsletter" value="0" checked> <?= $lang_text_no; ?></label>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php if ($text_agree): ?>
				<hr>
				<div class="form-group">
					<label class="control-label col-sm-3"><b class="required">*</b> <?= $legal_account; ?></label>
					<div class="col-sm-8">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="agree" value="1"<?= $agree ? ' checked' : ''; ?> required><?= $text_agree; ?>
							</label>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<?php if ($text_affiliate_agree): ?>
				<div id="affiliate-agree-panel">
					<div class="form-group">
						<label class="control-label col-sm-3"><b class="required">*</b> <?= $legal_affiliate; ?></label>
						<div class="col-sm-8">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="affiliate_agree" value="1"<?= $affiliate_agree ? ' checked' : ''; ?> required><?= $text_affiliate_agree; ?>
								</label>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</fieldset>
		</form>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>