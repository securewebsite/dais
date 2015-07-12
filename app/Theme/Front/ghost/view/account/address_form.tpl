<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend><?= $lang_text_edit_address; ?></legend>
				<div class="form-group">
					<label class="control-label col-sm-3" for="firstname"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
					<div class="col-sm-6">
						<input type="text" name="firstname" value="<?= $firstname; ?>" class="form-control" placeholder="<?= $lang_entry_firstname; ?>"  autofocus id="firstname" required>
						<?php if ($error_firstname) { ?>
						<span class="help-block error"><?= $error_firstname; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="lastname"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
					<div class="col-sm-6">
						<input type="text" name="lastname" value="<?= $lastname; ?>" class="form-control" placeholder="<?= $lang_entry_lastname; ?>"  id="lastname" required>
						<?php if ($error_lastname) { ?>
						<span class="help-block error"><?= $error_lastname; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="company"><?= $lang_entry_company; ?></label>
					<div class="col-sm-6">
						<input type="text" name="company" value="<?= $company; ?>" class="form-control" placeholder="<?= $lang_entry_company; ?>"  id="company">
					</div>
				</div>
				<div class="form-group" style="display: <?= ($company_id_display ? 'block' : 'none'); ?>;">
					<label class="control-label col-sm-3" for="company_id"><?= $lang_entry_company_id; ?></label>
					<div class="col-sm-6">
						<input type="text" name="company_id" value="<?= $company_id; ?>" class="form-control" placeholder="<?= $lang_entry_company_id; ?>"  id="company_id">
						<?php if ($error_company_id) { ?>
						<span class="help-block error"><?= $error_company_id; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group" style="display: <?= ($tax_id_display ? 'block' : 'none'); ?>;">
					<label class="control-label col-sm-3" for="tax_id"><?= $lang_entry_tax_id; ?></label>
					<div class="col-sm-6">
						<input type="text" name="tax_id" value="<?= $tax_id; ?>" class="form-control" placeholder="<?= $lang_entry_tax_id; ?>"  id="tax_id">
						<?php if ($error_tax_id) { ?>
						<span class="help-block error"><?= $error_tax_id; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="address_1"><b class="required">*</b> <?= $lang_entry_address_1; ?></label>
					<div class="col-sm-6">
						<input type="text" name="address_1" value="<?= $address_1; ?>" class="form-control" placeholder="<?= $lang_entry_address_1; ?>"  id="address_1" required>
						<?php if ($error_address_1) { ?>
						<span class="help-block error"><?= $error_address_1; ?></span>
						<?php } ?>
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
						<?php if ($error_city) { ?>
						<span class="help-block error"><?= $error_city; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="postcode"><b id="postcode-required" class="required">*</b> <?= $lang_entry_postcode; ?></label>
					<div class="col-sm-6">
						<input type="text" name="postcode" value="<?= $postcode; ?>" class="form-control" placeholder="<?= $lang_entry_postcode; ?>"  id="postcode">
						<?php if ($error_postcode) { ?>
						<span class="help-block error"><?= $error_postcode; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3"><b class="required">*</b> <?= $lang_entry_country; ?></label>
					<div class="col-sm-6">
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
					<div class="col-sm-6">
						<select name="zone_id" class="form-control" required></select>
						<?php if ($error_zone) { ?>
						<span class="help-block error"><?= $error_zone; ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3"><?= $lang_entry_default; ?></label>
					<div class="col-sm-6">
						<?php if ($default) { ?>
							<div class="radio radio-inline">
							<label><input type="radio" name="default" value="1" checked=""> <?= $lang_text_yes; ?></label>
							</div>
							<div class="radio radio-inline">
							<label><input type="radio" name="default" value="0"> <?= $lang_text_no; ?></label>
							</div>
						<?php } else { ?>
							<div class="radio radio-inline">
							<label><input type="radio" name="default" value="1"> <?= $lang_text_yes; ?></label>
							</div>
							<div class="radio radio-inline">
							<label><input type="radio" name="default" value="0" checked=""> <?= $lang_text_no; ?></label>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="form-actions">
					<div class="form-actions-inner text-right">
						<a href="<?= $back; ?>" class="btn btn-default pull-left"><?= $lang_button_back; ?></a>
						<button type="submit" class="btn btn-primary"><?= $lang_button_continue; ?></button>
					</div>
				</div>
			</fieldset>
		</form>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>