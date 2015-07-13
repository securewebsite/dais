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
			<div class="pull-left h2"><i class="hidden-xs fa fa-tablet"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_name; ?></label>
				<div class="control-field col-sm-4">
					<?php foreach ($languages as $language) { ?>
						<div class="input-group"><input type="text" name="recurring_description[<?= $language['language_id']; ?>][name]" value="<?= isset($recurring_description[$language['language_id']]) ? $recurring_description[$language['language_id']]['name'] :''; ?>" class="form-control">
						<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
						<?php if (isset($error_name[$language['language_id']])) { ?>
						<div class="help-block error"><?= $error_name[$language['language_id']]; ?></div>
						<?php } ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_sort_order; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="sort_order" value="<?= $sort_order ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="control-field col-sm-8 col-sm-offset-2">
					<div class="alert alert-info">
						<p class="form-control-static"><?= $lang_text_recurring; ?></p>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="status" class="form-control">
						<?php if ($status): ?>
							<option value="0"><?= $lang_text_disabled; ?></option>
							<option value="1" selected><?= $lang_text_enabled; ?></option>
						<?php else: ?>
							<option value="0" selected><?= $lang_text_disabled; ?></option>
							<option value="1"><?= $lang_text_enabled; ?></option>
						<?php endif; ?>
				</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_price; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="price" value="<?= $price ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_duration; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="duration" value="<?= $duration ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_cycle; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="cycle" value="<?= $cycle ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_frequency; ?></label>
				<div class="control-field col-sm-4">
					<select name="frequency" id="input-frequency" class="form-control">
					<?php foreach ($frequencies as $frequency_option) { ?>
					<?php if ($frequency == $frequency_option['value']) { ?>
						<option value="<?= $frequency_option['value']; ?>" selected="selected"><?= $frequency_option['text']; ?></option>
					<?php } else { ?>
						<option value="<?= $frequency_option['value']; ?>"><?= $frequency_option['text']; ?></option>
					<?php } ?>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_trial_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="trial_status" class="form-control">
						<?php if ($trial_status): ?>
							<option value="0"><?= $lang_text_disabled; ?></option>
							<option value="1" selected><?= $lang_text_enabled; ?></option>
						<?php else: ?>
							<option value="0" selected><?= $lang_text_disabled; ?></option>
							<option value="1"><?= $lang_text_enabled; ?></option>
						<?php endif; ?>
				</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_trial_price; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="trial_price" value="<?= $trial_price ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_trial_duration; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="trial_duration" value="<?= $trial_duration; ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_trial_cycle; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="trial_cycle" value="<?= $trial_cycle; ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_trial_frequency; ?></label>
				<div class="control-field col-sm-4">
					<select name="trial_frequency" id="input-trial-frequency" class="form-control">
					<?php foreach ($frequencies as $frequency_option) { ?>
					<?php if ($trial_frequency  == $frequency_option['value']) { ?>
						<option value="<?= $frequency_option['value']; ?>" selected="selected"><?= $frequency_option['text']; ?></option>
					<?php } else { ?>
						<option value="<?= $frequency_option['value']; ?>"><?= $frequency_option['text']; ?></option>
					<?php } ?>
					<?php } ?>
					</select>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>