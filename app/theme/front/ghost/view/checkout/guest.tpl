<div class="panel-body">
	<form id="form-guest" class="form-horizontal">
		<fieldset>
			<legend><?= $lang_text_your_details; ?></legend>
			<div class="form-group">
				<label class="control-label col-sm-3" for="firstname"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
				<div class="col-sm-6">
					<input type="text" name="firstname" value="<?= $firstname; ?>" class="form-control" placeholder="<?= $lang_entry_firstname; ?>"  id="firstname" autofocus required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="lastname"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
				<div class="col-sm-6">
					<input type="text" name="lastname" value="<?= $lastname; ?>" class="form-control" placeholder="<?= $lang_entry_lastname; ?>"  id="lastname" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="email"><b class="required">*</b> <?= $lang_entry_email; ?></label>
				<div class="col-sm-6">
					<input type="text" name="email" value="<?= $email; ?>" class="form-control" placeholder="<?= $lang_entry_email; ?>"  id="email" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="telephone"><b class="required">*</b> <?= $lang_entry_telephone; ?></label>
				<div class="col-sm-6">
					<input type="text" name="telephone" value="<?= $telephone; ?>" class="form-control" placeholder="<?= $lang_entry_telephone; ?>"  id="telephone" required>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend><?= $lang_text_your_address; ?></legend>
			<div class="form-group">
				<label class="control-label col-sm-3" for="company"><?= $lang_entry_company; ?></label>
				<div class="col-sm-6">
					<input type="text" name="company" value="<?= $company; ?>" class="form-control" placeholder="<?= $lang_entry_company; ?>"  id="company">
				</div>
			</div>
			<div class="form-group" style="display:<?= count($customer_groups) > 1 ? 'block' : 'none'; ?>;">
				<label class="control-label col-sm-3" for="customer_group_id"><?= !empty($entry_account) ? $entry_account : $entry_customer_group; ?></label>
				<div class="col-sm-6">
					<select name="customer_group_id" class="form-control" id="customer_group_id">
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
				<div class="col-sm-6">
					<input type="text" name="company_id" value="<?= $company_id; ?>" class="form-control" placeholder="<?= $lang_entry_company_id; ?>"  id="company_id">
				</div>
			</div>
			<div class="form-group" id="tax-id-display">
				<label class="control-label col-sm-3" for="tax_id"><b id="tax-id-required" class="required">*</b> <?= $lang_entry_tax_id; ?></label>
				<div class="col-sm-6">
					<input type="text" name="tax_id" value="<?= $tax_id; ?>" class="form-control" placeholder="<?= $lang_entry_tax_id; ?>"  id="tax_id">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="address_1"><b class="required">*</b> <?= $lang_entry_address_1; ?></label>
				<div class="col-sm-6">
					<input type="text" name="address_1" value="<?= $address_1; ?>" class="form-control" placeholder="<?= $lang_entry_address_1; ?>"  id="address_1" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="address_2"><?= $lang_entry_address_2; ?></label>
				<div class="col-sm-6">
					<input type="text" name="address_2" value="<?= $address_2; ?>" class="form-control" placeholder="<?= $lang_entry_address_2; ?>"  id="address_2">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="city"><b class="required">*</b> <?= $lang_entry_city; ?></label>
				<div class="col-sm-6">
					<input type="text" name="city" value="<?= $city; ?>" class="form-control" placeholder="<?= $lang_entry_city; ?>"  id="city" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="postcode"><b id="postcode-required" class="required">*</b> <?= $lang_entry_postcode; ?></label>
				<div class="col-sm-6">
					<input type="text" name="postcode" value="<?= $postcode; ?>" class="form-control" placeholder="<?= $lang_entry_postcode; ?>"  id="postcode">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="country"><b class="required">*</b> <?= $lang_entry_country; ?></label>
				<div class="col-sm-6">
					<select name="country_id" class="form-control" id="country" data-param="<?= htmlentities('{"zone_id":"' . $zone_id . '","select":"' . $lang_text_select . '","none":"' . $lang_text_none . '"}'); ?>" required>
						<option value=""><?= $lang_text_select; ?></option>
						<?php foreach ($countries as $country) { ?>
						<?php if ($country['country_id'] == $country_id) { ?>
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
			<?php if ($shipping_required) { ?>
			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-3">
					<?php if ($shipping_address) { ?>
					<div class="checkbox"><label><input type="checkbox" name="shipping_address" value="1" checked=""><?= $lang_entry_shipping; ?></label></div>
					<?php } else { ?>
					<div class="checkbox"><label><input type="checkbox" name="shipping_address" value="1"><?= $lang_entry_shipping; ?></label></div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
		</fieldset>
	</form>
</div>
<div class="panel-footer text-right">
	<button type="button" id="button-guest" class="btn btn-primary load-left"><?= $lang_button_continue; ?></button>
</div>
<?= $javascript; ?>