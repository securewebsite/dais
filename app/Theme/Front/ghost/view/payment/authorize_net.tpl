<fieldset>
<legend><?= $lang_text_credit_card; ?></legend>
<div class="form-horizontal" id="payment">
	<div class="form-group">
		<label class="control-label col-sm-3" for="cc_owner"><?= $lang_entry_cc_owner; ?></label>
		<div class="col-sm-6">
			<input type="text" name="cc_owner" value="" class="form-control" placeholder="<?= $lang_entry_cc_owner; ?>"  id="cc_owner">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3" for="cc_number"><?= $lang_entry_cc_number; ?></label>
		<div class="col-sm-6">
			<input type="text" name="cc_number" value="" class="form-control" placeholder="<?= $lang_entry_cc_number; ?>"  id="cc_number">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3" for="cc_expire_date"><?= $lang_entry_cc_expire_date; ?></label>
		<div class="col-sm-3">
			<select name="cc_expire_date_month" class="form-control" id="cc_expire_date">
				<?php foreach ($months as $month) { ?>
				<option value="<?= $month['value']; ?>"><?= $month['text']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-3">
			<select name="cc_expire_date_year" class="form-control">
				<?php foreach ($year_expire as $year) { ?>
				<option value="<?= $year['value']; ?>"><?= $year['text']; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3" for="cc_cvv2"><?= $lang_entry_cc_cvv2; ?></label>
		<div class="col-sm-6">
			<input type="text" name="cc_cvv2" value="" class="form-control" placeholder="<?= $lang_entry_cc_cvv2; ?>"  id="cc_cvv2">
		</div>
	</div>
</div>
</fieldset>
<?= $javascript; ?>