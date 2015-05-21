<fieldset>
	<legend><?= $lang_text_credit_card; ?></legend>
	<div class="form-horizontal" id="payment">
		<div class="form-group">
			<label class="control-label col-sm-3" for="cc_type"><?= $lang_entry_cc_type; ?></label>
			<div class="col-sm-6">
				<select name="cc_type" class="form-control" id="cc_type">
					<?php foreach ($cards as $card) { ?>
					<option value="<?= $card['value']; ?>"><?= $card['text']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="cc_number"><?= $lang_entry_cc_number; ?></label>
			<div class="col-sm-6">
				<input type="text" name="cc_number" value="" class="form-control" placeholder="<?= $lang_entry_cc_number; ?>"  id="cc_number">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="cc_start_date_month"><?= $lang_entry_cc_start_date; ?></label>
			<div class="col-sm-3">
				<select name="cc_start_date_month" class="form-control" id="cc_start_date_month">
					<?php foreach ($months as $month) { ?>
					<option value="<?= $month['value']; ?>"><?= $month['text']; ?></option>
					<?php } ?>
				</select>
				<div class="help-block"><?= $lang_text_start_date; ?></div>
			</div>
			<div class="col-sm-3">
				<select name="cc_start_date_year" class="form-control">
					<?php foreach ($year_valid as $year) { ?>
					<option value="<?= $year['value']; ?>"><?= $year['text']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-3" for="cc_expire_date_month"><?= $lang_entry_cc_expire_date; ?></label>
			<div class="col-sm-3">
				<select name="cc_expire_date_month" class="form-control" id="cc_expire_date_month">
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
		<div class="form-group">
			<label class="control-label col-sm-3" for="cc_issue"><?= $lang_entry_cc_issue; ?></label>
			<div class="col-sm-6">
				<input type="text" name="cc_issue" value="" class="form-control" placeholder="<?= $lang_entry_cc_issue; ?>"  id="cc_issue">
				<div class="help-block"><?= $lang_text_issue; ?></div>
			</div>
		</div>
	</div>
</fieldset>
<?= $javascript; ?>