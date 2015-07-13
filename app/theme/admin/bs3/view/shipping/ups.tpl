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
			<div class="pull-left h2"><i class="hidden-xs fa fa-qrcode"></i><?= $lang_heading_title; ?></div>
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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_key; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="ups_key" value="<?= $ups_key; ?>" class="form-control" autofocus>
					<?php if ($error_key) { ?>
						<div class="help-block error"><?= $error_key; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_username; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="ups_username" value="<?= $ups_username; ?>" class="form-control">
					<?php if ($error_username) { ?>
						<div class="help-block error"><?= $error_username; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_password; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="ups_password" value="<?= $ups_password; ?>" class="form-control">
					<?php if ($error_password) { ?>
						<div class="help-block error"><?= $error_password; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_pickup; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_pickup" class="form-control">
						<?php foreach ($pickups as $pickup) { ?>
						<?php if ($pickup['value'] == $ups_pickup) { ?>
						<option value="<?= $pickup['value']; ?>" selected><?= $pickup['text']; ?></option>
						<?php } else { ?>
						<option value="<?= $pickup['value']; ?>"><?= $pickup['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_packaging; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_packaging" class="form-control">
						<?php foreach ($packages as $package) { ?>
						<?php if ($package['value'] == $ups_packaging) { ?>
						<option value="<?= $package['value']; ?>" selected><?= $package['text']; ?></option>
						<?php } else { ?>
						<option value="<?= $package['value']; ?>"><?= $package['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_classification; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_classification" class="form-control">
						<?php foreach ($classifications as $classification) { ?>
						<?php if ($classification['value'] == $ups_classification) { ?>
						<option value="<?= $classification['value']; ?>" selected><?= $classification['text']; ?></option>
						<?php } else { ?>
						<option value="<?= $classification['value']; ?>"><?= $classification['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_origin; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_origin" class="form-control">
						<?php foreach ($origins as $origin) { ?>
						<?php if ($origin['value'] == $ups_origin) { ?>
						<option value="<?= $origin['value']; ?>" selected><?= $origin['text']; ?></option>
						<?php } else { ?>
						<option value="<?= $origin['value']; ?>"><?= $origin['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_city; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="ups_city" value="<?= $ups_city; ?>" class="form-control">
					<?php if ($error_city) { ?>
						<div class="help-block error"><?= $error_city; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_state; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="ups_state" value="<?= $ups_state; ?>" maxlength="2" class="form-control">
					<?php if ($error_state) { ?>
						<div class="help-block error"><?= $error_state; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_country; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="ups_country" value="<?= $ups_country; ?>" maxlength="2" class="form-control">
					<?php if ($error_country) { ?>
						<div class="help-block error"><?= $error_country; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_postcode; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="ups_postcode" value="<?= $ups_postcode; ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_test; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($ups_test) { ?>
					<label class="radio-inline"><input type="radio" name="ups_test" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="ups_test" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="ups_test" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="ups_test" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_quote_type; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_quote_type" class="form-control">
						<?php foreach ($quote_types as $quote_type) { ?>
						<?php if ($quote_type['value'] == $ups_quote_type) { ?>
						<option value="<?= $quote_type['value']; ?>" selected><?= $quote_type['text']; ?></option>
						<?php } else { ?>
						<option value="<?= $quote_type['value']; ?>"><?= $quote_type['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><p><?= $lang_entry_service; ?></p>
					<div class="btn-group-vertical">
						<a class="btn btn-default btn-sm" onclick="$('#service :checkbox').prop('checked',true);"><?= $lang_text_select_all; ?></a>
						<a class="btn btn-default btn-sm" onclick="$('#service :checkbox').prop('checked',false);"><?= $lang_text_unselect_all; ?></a>
					</div>
				</label>
				<div class="control-field col-sm-4">
					<div class="panel panel-default panel-scrollable">
						<div id="service" class="list-group list-group-hover">
							<div id="US">
								<label class="list-group-item">
									<?php if ($ups_us_01) { ?>
									<input type="checkbox" name="ups_us_01" value="1" checked=""><?= $lang_text_next_day_air; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_01" value="1"><?= $lang_text_next_day_air; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_02) { ?>
									<input type="checkbox" name="ups_us_02" value="1" checked=""><?= $lang_text_2nd_day_air; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_02" value="1"><?= $lang_text_2nd_day_air; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_03) { ?>
									<input type="checkbox" name="ups_us_03" value="1" checked=""><?= $lang_text_ground; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_03" value="1"><?= $lang_text_ground; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_07) { ?>
									<input type="checkbox" name="ups_us_07" value="1" checked=""><?= $lang_text_worldwide_express; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_07" value="1"><?= $lang_text_worldwide_express; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_08) { ?>
									<input type="checkbox" name="ups_us_08" value="1" checked=""><?= $lang_text_worldwide_expedited; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_08" value="1"><?= $lang_text_worldwide_expedited; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_11) { ?>
									<input type="checkbox" name="ups_us_11" value="1" checked=""><?= $lang_text_standard; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_11" value="1"><?= $lang_text_standard; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_12) { ?>
									<input type="checkbox" name="ups_us_12" value="1" checked=""><?= $lang_text_3_day_select; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_12" value="1"><?= $lang_text_3_day_select; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_13){ ?>
									<input type="checkbox" name="ups_us_13" value="1" checked=""><?= $lang_text_next_day_air_saver; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_13" value="1"><?= $lang_text_next_day_air_saver; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_14) { ?>
									<input type="checkbox" name="ups_us_14" value="1" checked=""><?= $lang_text_next_day_air_early_am; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_14" value="1"><?= $lang_text_next_day_air_early_am; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_54) { ?>
									<input type="checkbox" name="ups_us_54" value="1" checked=""><?= $lang_text_worldwide_express_plus; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_54" value="1"><?= $lang_text_worldwide_express_plus; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_59) { ?>
									<input type="checkbox" name="ups_us_59" value="1" checked=""><?= $lang_text_2nd_day_air_am; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_59" value="1"><?= $lang_text_2nd_day_air_am; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_us_65) { ?>
									<input type="checkbox" name="ups_us_65" value="1" checked=""><?= $lang_text_saver; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_us_65" value="1"><?= $lang_text_saver; ?>
									<?php } ?>
								</label>
							</div>
							<div id="PR">
								<label class="list-group-item">
									<?php if ($ups_pr_01) { ?>
									<input type="checkbox" name="ups_pr_01" value="1" checked=""><?= $lang_text_next_day_air; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_pr_01" value="1"><?= $lang_text_next_day_air; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_pr_02) { ?>
									<input type="checkbox" name="ups_pr_02" value="1" checked=""><?= $lang_text_2nd_day_air; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_pr_02" value="1"><?= $lang_text_2nd_day_air; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_pr_03) { ?>
									<input type="checkbox" name="ups_pr_03" value="1" checked=""><?= $lang_text_ground; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_pr_03" value="1"><?= $lang_text_ground; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_pr_07) { ?>
									<input type="checkbox" name="ups_pr_07" value="1" checked=""><?= $lang_text_worldwide_express; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_pr_07" value="1"><?= $lang_text_worldwide_express; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_pr_08) { ?>
									<input type="checkbox" name="ups_pr_08" value="1" checked=""><?= $lang_text_worldwide_expedited; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_pr_08" value="1"><?= $lang_text_worldwide_expedited; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_pr_14) { ?>
									<input type="checkbox" name="ups_pr_14" value="1" checked=""><?= $lang_text_next_day_air_early_am; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_pr_14" value="1"><?= $lang_text_next_day_air_early_am; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_pr_54) { ?>
									<input type="checkbox" name="ups_pr_54" value="1" checked=""><?= $lang_text_worldwide_express_plus; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_pr_54" value="1"><?= $lang_text_worldwide_express_plus; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_pr_65) { ?>
									<input type="checkbox" name="ups_pr_65" value="1" checked=""><?= $lang_text_saver; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_pr_65" value="1"><?= $lang_text_saver; ?>
									<?php } ?>
								</label>
							</div>
							<div id="CA">
								<label class="list-group-item">
									<?php if ($ups_ca_01) { ?>
									<input type="checkbox" name="ups_ca_01" value="1" checked=""><?= $lang_text_express; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_01" value="1"><?= $lang_text_express; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_ca_02) { ?>
									<input type="checkbox" name="ups_ca_02" value="1" checked=""><?= $lang_text_expedited; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_02" value="1"><?= $lang_text_expedited; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_ca_07) { ?>
									<input type="checkbox" name="ups_ca_07" value="1" checked=""><?= $lang_text_worldwide_express; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_07" value="1"><?= $lang_text_worldwide_express; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_ca_08) { ?>
									<input type="checkbox" name="ups_ca_08" value="1" checked=""><?= $lang_text_worldwide_expedited; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_08" value="1"><?= $lang_text_worldwide_expedited; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_ca_11) { ?>
									<input type="checkbox" name="ups_ca_11" value="1" checked=""><?= $lang_text_standard; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_11" value="1"><?= $lang_text_standard; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_ca_12) { ?>
									<input type="checkbox" name="ups_ca_12" value="1" checked=""><?= $lang_text_3_day_select; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_12" value="1"><?= $lang_text_3_day_select; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_ca_13){ ?>
									<input type="checkbox" name="ups_ca_13" value="1" checked=""><?= $lang_text_saver; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_13" value="1"><?= $lang_text_saver; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_ca_14) { ?>
									<input type="checkbox" name="ups_ca_14" value="1" checked=""><?= $lang_text_express_early_am; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_14" value="1"><?= $lang_text_express_early_am; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_ca_54) { ?>
									<input type="checkbox" name="ups_ca_54" value="1" checked=""><?= $lang_text_worldwide_express_plus; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_54" value="1"><?= $lang_text_worldwide_express_plus; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_ca_65) { ?>
									<input type="checkbox" name="ups_ca_65" value="1" checked=""><?= $lang_text_saver; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_ca_65" value="1"><?= $lang_text_saver; ?>
									<?php } ?>
								</label>
							</div>
							<div id="MX">
								<label class="list-group-item">
									<?php if ($ups_mx_07) { ?>
									<input type="checkbox" name="ups_mx_07" value="1" checked=""><?= $lang_text_worldwide_express; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_mx_07" value="1"><?= $lang_text_worldwide_express; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_mx_08) { ?>
									<input type="checkbox" name="ups_mx_08" value="1" checked=""><?= $lang_text_worldwide_expedited; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_mx_08" value="1"><?= $lang_text_worldwide_expedited; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_mx_54) { ?>
									<input type="checkbox" name="ups_mx_54" value="1" checked=""><?= $lang_text_worldwide_express_plus; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_mx_54" value="1"><?= $lang_text_worldwide_express_plus; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_mx_65) { ?>
									<input type="checkbox" name="ups_mx_65" value="1" checked=""><?= $lang_text_saver; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_mx_65" value="1"><?= $lang_text_saver; ?>
									<?php } ?>
								</label>
							</div>
							<div id="EU">
								<label class="list-group-item">
									<?php if ($ups_eu_07) { ?>
									<input type="checkbox" name="ups_eu_07" value="1" checked=""><?= $lang_text_express; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_07" value="1"><?= $lang_text_express; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_eu_08) { ?>
									<input type="checkbox" name="ups_eu_08" value="1" checked=""><?= $lang_text_expedited; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_08" value="1"><?= $lang_text_expedited; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_eu_11) { ?>
									<input type="checkbox" name="ups_eu_11" value="1" checked=""><?= $lang_text_standard; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_11" value="1"><?= $lang_text_standard; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_eu_54) { ?>
									<input type="checkbox" name="ups_eu_54" value="1" checked=""><?= $lang_text_worldwide_express_plus; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_54" value="1"><?= $lang_text_worldwide_express_plus; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_eu_65) { ?>
									<input type="checkbox" name="ups_eu_65" value="1" checked=""><?= $lang_text_saver; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_65" value="1"><?= $lang_text_saver; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_eu_82) { ?>
									<input type="checkbox" name="ups_eu_82" value="1" checked=""><?= $lang_text_today_standard; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_82" value="1"><?= $lang_text_today_standard; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_eu_83) { ?>
									<input type="checkbox" name="ups_eu_83" value="1" checked=""><?= $lang_text_today_dedicated_courier; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_83" value="1"><?= $lang_text_today_dedicated_courier; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_eu_84) { ?>
									<input type="checkbox" name="ups_eu_84" value="1" checked=""><?= $lang_text_today_intercity; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_84" value="1"><?= $lang_text_today_intercity; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_eu_85) { ?>
									<input type="checkbox" name="ups_eu_85" value="1" checked=""><?= $lang_text_today_express; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_85" value="1"><?= $lang_text_today_express; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_eu_86) { ?>
									<input type="checkbox" name="ups_eu_86" value="1" checked=""><?= $lang_text_today_express_saver; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_eu_86" value="1"><?= $lang_text_today_express_saver; ?>
									<?php } ?>
								</label>
							</div>
							<div id="other">
								<label class="list-group-item">
									<?php if ($ups_other_07) { ?>
									<input type="checkbox" name="ups_other_07" value="1" checked=""><?= $lang_text_express; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_other_07" value="1"><?= $lang_text_express; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_other_08) { ?>
									<input type="checkbox" name="ups_other_08" value="1" checked=""><?= $lang_text_expedited; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_other_08" value="1"><?= $lang_text_expedited; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_other_11) { ?>
									<input type="checkbox" name="ups_other_11" value="1" checked=""><?= $lang_text_standard; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_other_11" value="1"><?= $lang_text_standard; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_other_54) { ?>
									<input type="checkbox" name="ups_other_54" value="1" checked=""><?= $lang_text_worldwide_express_plus; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_other_54" value="1"><?= $lang_text_worldwide_express_plus; ?>
									<?php } ?>
								</label>
								<label class="list-group-item">
									<?php if ($ups_other_65) { ?>
									<input type="checkbox" name="ups_other_65" value="1" checked=""><?= $lang_text_saver; ?>
									<?php } else { ?>
									<input type="checkbox" name="ups_other_65" value="1"><?= $lang_text_saver; ?>
									<?php } ?>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_insurance; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($ups_insurance) { ?>
					<label class="radio-inline"><input type="radio" name="ups_insurance" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="ups_insurance" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="ups_insurance" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="ups_insurance" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_display_weight; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($ups_display_weight) { ?>
					<label class="radio-inline"><input type="radio" name="ups_display_weight" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="ups_display_weight" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="ups_display_weight" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="ups_display_weight" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_weight_class; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_weight_class_id" class="form-control">
						<?php foreach ($weight_classes as $weight_class) { ?>
						<?php if ($weight_class['weight_class_id'] == $ups_weight_class_id) { ?>
						<option value="<?= $weight_class['weight_class_id']; ?>" selected><?= $weight_class['title']; ?></option>
						<?php } else { ?>
						<option value="<?= $weight_class['weight_class_id']; ?>"><?= $weight_class['title']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_length_class; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_length_class_id" class="form-control">
						<?php foreach ($length_classes as $length_class) { ?>
						<?php if ($length_class['length_class_id'] == $ups_length_class_id) { ?>
						<option value="<?= $length_class['length_class_id']; ?>" selected><?= $length_class['title']; ?></option>
						<?php } else { ?>
						<option value="<?= $length_class['length_class_id']; ?>"><?= $length_class['title']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_dimension; ?></label>
				<div class="control-field col-sm-4">
					<div class="slim-row">
						<div class="slim-col-sm-4">
							<input type="text" name="ups_length" value="<?= $ups_length; ?>" class="form-control">
						</div>
						<div class="slim-col-sm-4">
							<input type="text" name="ups_width" value="<?= $ups_width; ?>" class="form-control">
						</div>
						<div class="slim-col-sm-4">
							<input type="text" name="ups_height" value="<?= $ups_height; ?>" class="form-control">
						</div>
					</div>
					<?php if ($error_dimension) { ?>
						<span class="text-danger"><?= $error_dimension; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_tax_class; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_tax_class_id" class="form-control">
						<option value="0"><?= $lang_text_none; ?></option>
						<?php foreach ($tax_classes as $tax_class) { ?>
						<?php if ($tax_class['tax_class_id'] == $ups_tax_class_id) { ?>
						<option value="<?= $tax_class['tax_class_id']; ?>" selected><?= $tax_class['title']; ?></option>
						<?php } else { ?>
						<option value="<?= $tax_class['tax_class_id']; ?>"><?= $tax_class['title']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_geo_zone; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_geo_zone_id" class="form-control">
						<option value="0"><?= $lang_text_all_zones; ?></option>
						<?php foreach ($geo_zones as $geo_zone) { ?>
						<?php if ($geo_zone['geo_zone_id'] == $ups_geo_zone_id) { ?>
						<option value="<?= $geo_zone['geo_zone_id']; ?>" selected><?= $geo_zone['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $geo_zone['geo_zone_id']; ?>"><?= $geo_zone['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_debug; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_debug" class="form-control">
						<?php if ($ups_debug) { ?>
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
				<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="ups_status" class="form-control">
						<?php if ($ups_status) { ?>
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
				<label class="control-label col-sm-2"><?= $lang_entry_sort_order; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="ups_sort_order" value="<?= $ups_sort_order; ?>" class="form-control">
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>