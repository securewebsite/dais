<div class="panel-body">
	<form class="form-horizontal">
		<div class="form-group">
			<label class="control-label col-sm-3" for="guest-firstname"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
			<div class="col-sm-6">
				<input type="text" name="firstname" value="<?= $firstname; ?>" class="form-control" placeholder="<?= $lang_entry_firstname; ?>"  id="guest-firstname" required>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="guest-lastname"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
			<div class="col-sm-6">
				<input type="text" name="lastname" value="<?= $lastname; ?>" class="form-control" placeholder="<?= $lang_entry_lastname; ?>"  id="guest-lastname" required>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="guest-company"><?= $lang_entry_company; ?></label>
			<div class="col-sm-6">
				<input type="text" name="company" value="<?= $company; ?>" class="form-control" placeholder="<?= $lang_entry_company; ?>"  id="guest-company">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="guest-address_1"><b class="required">*</b> <?= $lang_entry_address_1; ?></label>
			<div class="col-sm-6">
				<input type="text" name="address_1" value="<?= $address_1; ?>" class="form-control" placeholder="<?= $lang_entry_address_1; ?>"  id="guest-address_1" required>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="guest-address_2"><?= $lang_entry_address_2; ?></label>
			<div class="col-sm-6">
				<input type="text" name="address_2" value="<?= $address_2; ?>" class="form-control" placeholder="<?= $lang_entry_address_2; ?>"  id="guest-address_2">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="guest-city"><b class="required">*</b> <?= $lang_entry_city; ?></label>
			<div class="col-sm-6">
				<input type="text" name="city" value="<?= $city; ?>" class="form-control" placeholder="<?= $lang_entry_city; ?>"  id="guest-city" required>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="guest-postcode"><b id="postcode-required" class="required">*</b> <?= $lang_entry_postcode; ?></label>
			<div class="col-sm-6">
				<input type="text" name="postcode" value="<?= $postcode; ?>" class="form-control" placeholder="<?= $lang_entry_postcode; ?>"  id="guest-postcode">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="guest-country_id"><b class="required">*</b> <?= $lang_entry_country; ?></label>
			<div class="col-sm-6">
				<select name="country_id" class="form-control" id="guest-country_id" data-param="<?= htmlentities('{"zone_id":"' . $zone_id . '","select":"' . $lang_text_select . '","none":"' . $lang_text_none . '"}'); ?>" required>
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
			<label class="control-label col-sm-3" for="guest-zone_id"><b class="required">*</b> <?= $lang_entry_zone; ?></label>
			<div class="col-sm-6">
				<select name="zone_id" class="form-control" id="guest-zone_id" required></select>
			</div>
		</div>
	</form>
</div>
<div class="panel-footer text-right">
	<button type="button" id="button-guest-shipping" class="btn btn-primary load-left"><?= $lang_button_continue; ?></button>
</div>
<?= $javascript; ?>