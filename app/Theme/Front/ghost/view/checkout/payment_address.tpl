<div class="panel-body">
	<form class="form-horizontal">
		<?php if ($addresses) { ?>
		<div class="radio">
			<label for="payment-address-existing">
				<input type="radio" name="payment_address" value="existing" id="payment-address-existing" checked="">
				<?= $lang_text_address_existing; ?></label>
		</div>
		<div id="payment-existing">
			<select name="address_id" class="form-control-multiple" size="5">
				<?php foreach ($addresses as $address) { ?>
				<?php if ($address['address_id'] == $address_id) { ?>
				<option value="<?= $address['address_id']; ?>" selected=""><?= $address['firstname']; ?> <?= $address['lastname']; ?>, <?= $address['address_1']; ?>, <?= $address['city']; ?>, <?= $address['zone']; ?>, <?= $address['country']; ?></option>
				<?php } else { ?>
				<option value="<?= $address['address_id']; ?>"><?= $address['firstname']; ?> <?= $address['lastname']; ?>, <?= $address['address_1']; ?>, <?= $address['city']; ?>, <?= $address['zone']; ?>, <?= $address['country']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		</div>
		<p>
			<div class="radio">
				<label for="payment-address-new">
					<input type="radio" name="payment_address" value="new" id="payment-address-new">
					<?= $lang_text_address_new; ?></label>
			</div>
		</p>
		<?php } ?>
		<div id="payment-new" style="display:<?= $addresses ? 'none' : 'block'; ?>;">
			<hr>
			<div class="form-group">
				<label class="control-label col-sm-3" for="firstname"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
				<div class="col-sm-6">
					<input type="text" name="firstname" value="" class="form-control" placeholder="<?= $lang_entry_firstname; ?>"  id="firstname" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="lastname"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
				<div class="col-sm-6">
					<input type="text" name="lastname" value="" class="form-control" placeholder="<?= $lang_entry_lastname; ?>"  id="lastname" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="company"><?= $lang_entry_company; ?></label>
				<div class="col-sm-6">
					<input type="text" name="company" value="" class="form-control" placeholder="<?= $lang_entry_company; ?>"  id="company">
				</div>
			</div>
			<?php if ($company_id_display) { ?>
			<div class="form-group">
				<label class="control-label col-sm-3" for="company_id"><?= $company_id_required ? '<b class="required">*</b> ' : ''; echo $entry_company_id; ?></label>
				<div class="col-sm-6">
					<input type="text" name="company_id" value="" class="form-control" placeholder="<?= $lang_entry_company_id; ?>"  id="company_id">
				</div>
			</div>
			<?php } ?>
			<?php if ($tax_id_display) { ?>
			<div class="form-group">
				<label class="control-label col-sm-3" for="tax_id"><?= $tax_id_required ? '<b class="required">*</b> ' : ''; echo $entry_tax_id; ?></label>
				<div class="col-sm-6">
					<input type="text" name="tax_id" value="" class="form-control" placeholder="<?= $lang_entry_tax_id; ?>"  id="tax_id">
				</div>
			</div>
			<?php } ?>
			<div class="form-group">
				<label class="control-label col-sm-3" for="address_1"><b class="required">*</b> <?= $lang_entry_address_1; ?></label>
				<div class="col-sm-6">
					<input type="text" name="address_1" value="" class="form-control" placeholder="<?= $lang_entry_address_1; ?>"  id="address_1" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="address_2"><?= $lang_entry_address_2; ?></label>
				<div class="col-sm-6">
					<input type="text" name="address_2" value="" class="form-control" placeholder="<?= $lang_entry_address_2; ?>"  id="address_2">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="city"><b class="required">*</b> <?= $lang_entry_city; ?></label>
				<div class="col-sm-6">
					<input type="text" name="city" value="" class="form-control" placeholder="<?= $lang_entry_city; ?>"  id="city" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="postcode"><b id="postcode-required" class="required">*</b> <?= $lang_entry_postcode; ?></label>
				<div class="col-sm-6">
					<input type="text" name="postcode" value="" class="form-control" placeholder="<?= $lang_entry_postcode; ?>"  id="postcode">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="country_id"><b class="required">*</b> <?= $lang_entry_country; ?></label>
				<div class="col-sm-6">
					<select name="country_id" class="form-control" id="country_id" data-param="<?= htmlentities('{"zone_id":"' . $zone_id . '","select":"' . $lang_text_select . '","none":"' . $lang_text_none . '"}'); ?>" required>
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
					<select name="zone_id" class="form-control" required></select>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="panel-footer text-right">
	<button type="button" id="button-payment-address" class="btn btn-primary load-left"><?= $lang_button_continue; ?></button>
</div>
<?= $javascript; ?>