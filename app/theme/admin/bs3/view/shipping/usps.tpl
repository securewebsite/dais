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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_user_id; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="usps_user_id" value="<?= $usps_user_id; ?>" class="form-control" autofocus>
					<?php if ($error_user_id) { ?>
						<div class="help-block error"><?= $error_user_id; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_postcode; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="usps_postcode" value="<?= $usps_postcode; ?>" class="form-control">
					<?php if ($error_postcode) { ?>
						<div class="help-block error"><?= $error_postcode; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><p><?= $lang_entry_domestic; ?></p>
					<div class="btn-group-vertical">
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'usps_domestic\']').prop('checked',true);"><?= $lang_text_select_all; ?></a>
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'usps_domestic\']').prop('checked',false);"><?= $lang_text_unselect_all; ?></a>
					</div>
				</label>
				<div class="control-field col-sm-4">
					<div class="panel panel-default panel-scrollable">
						<div class="list-group list-group-hover">
							<label class="list-group-item">
								<?php if ($usps_domestic_00) { ?>
								<input type="checkbox" name="usps_domestic_00" value="1" checked=""><?= $lang_text_domestic_00; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_00" value="1"><?= $lang_text_domestic_00; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_01) { ?>
								<input type="checkbox" name="usps_domestic_01" value="1" checked=""><?= $lang_text_domestic_01; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_01" value="1"><?= $lang_text_domestic_01; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_02) { ?>
								<input type="checkbox" name="usps_domestic_02" value="1" checked=""><?= $lang_text_domestic_02; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_02" value="1"><?= $lang_text_domestic_02; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_03) { ?>
								<input type="checkbox" name="usps_domestic_03" value="1" checked=""><?= $lang_text_domestic_03; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_03" value="1"><?= $lang_text_domestic_03; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_1) { ?>
								<input type="checkbox" name="usps_domestic_1" value="1" checked=""><?= $lang_text_domestic_1; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_1" value="1"><?= $lang_text_domestic_1; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_2) { ?>
								<input type="checkbox" name="usps_domestic_2" value="1" checked=""><?= $lang_text_domestic_2; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_2" value="1"><?= $lang_text_domestic_2; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_3) { ?>
								<input type="checkbox" name="usps_domestic_3" value="1" checked=""><?= $lang_text_domestic_3; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_3" value="1"><?= $lang_text_domestic_3; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_4) { ?>
								<input type="checkbox" name="usps_domestic_4" value="1" checked=""><?= $lang_text_domestic_4; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_4" value="1"><?= $lang_text_domestic_4; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_5) { ?>
								<input type="checkbox" name="usps_domestic_5" value="1" checked=""><?= $lang_text_domestic_5; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_5" value="1"><?= $lang_text_domestic_5; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_6) { ?>
								<input type="checkbox" name="usps_domestic_6" value="1" checked=""><?= $lang_text_domestic_6; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_6" value="1"><?= $lang_text_domestic_6; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_7) { ?>
								<input type="checkbox" name="usps_domestic_7" value="1" checked=""><?= $lang_text_domestic_7; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_7" value="1"><?= $lang_text_domestic_7; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_12) { ?>
								<input type="checkbox" name="usps_domestic_12" value="1" checked=""><?= $lang_text_domestic_12; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_12" value="1"><?= $lang_text_domestic_12; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_13){ ?>
								<input type="checkbox" name="usps_domestic_13" value="1" checked=""><?= $lang_text_domestic_13; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_13" value="1"><?= $lang_text_domestic_13; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_16) { ?>
								<input type="checkbox" name="usps_domestic_16" value="1" checked=""><?= $lang_text_domestic_16; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_16" value="1"><?= $lang_text_domestic_16; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_17) { ?>
								<input type="checkbox" name="usps_domestic_17" value="1" checked=""><?= $lang_text_domestic_17; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_17" value="1"><?= $lang_text_domestic_17; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_18) { ?>
								<input type="checkbox" name="usps_domestic_18" value="1" checked=""><?= $lang_text_domestic_18; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_18" value="1"><?= $lang_text_domestic_18; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_19) { ?>
								<input type="checkbox" name="usps_domestic_19" value="1" checked=""><?= $lang_text_domestic_19; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_19" value="1"><?= $lang_text_domestic_19; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_22) { ?>
								<input type="checkbox" name="usps_domestic_22" value="1" checked=""><?= $lang_text_domestic_22; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_22" value="1"><?= $lang_text_domestic_22; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_23) { ?>
								<input type="checkbox" name="usps_domestic_23" value="1" checked=""><?= $lang_text_domestic_23; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_23" value="1"><?= $lang_text_domestic_23; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_25) { ?>
								<input type="checkbox" name="usps_domestic_25" value="1" checked=""><?= $lang_text_domestic_25; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_25" value="1"><?= $lang_text_domestic_25; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_27) { ?>
								<input type="checkbox" name="usps_domestic_27" value="1" checked=""><?= $lang_text_domestic_27; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_27" value="1"><?= $lang_text_domestic_27; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_domestic_28) { ?>
								<input type="checkbox" name="usps_domestic_28" value="1" checked=""><?= $lang_text_domestic_28; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_domestic_28" value="1"><?= $lang_text_domestic_28; ?>
								<?php } ?>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><p><?= $lang_entry_international; ?></p>
					<div class="btn-group-vertical">
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'usps_international\']').prop('checked',true);"><?= $lang_text_select_all; ?></a>
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'usps_international\']').prop('checked',false);"><?= $lang_text_unselect_all; ?></a>
					</div>
				</label>
				<div class="control-field col-sm-4">
					<div class="panel panel-default panel-scrollable">
						<div class="list-group list-group-hover">
							<label class="list-group-item">
								<?php if ($usps_international_1) { ?>
								<input type="checkbox" name="usps_international_1" value="1" checked=""><?= $lang_text_international_1; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_1" value="1"><?= $lang_text_international_1; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_2) { ?>
								<input type="checkbox" name="usps_international_2" value="1" checked=""><?= $lang_text_international_2; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_2" value="1"><?= $lang_text_international_2; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_4) { ?>
								<input type="checkbox" name="usps_international_4" value="1" checked=""><?= $lang_text_international_4; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_4" value="1"><?= $lang_text_international_4; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_5) { ?>
								<input type="checkbox" name="usps_international_5" value="1" checked=""><?= $lang_text_international_5; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_5" value="1"><?= $lang_text_international_5; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_6) { ?>
								<input type="checkbox" name="usps_international_6" value="1" checked=""><?= $lang_text_international_6; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_6" value="1"><?= $lang_text_international_6; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_7) { ?>
								<input type="checkbox" name="usps_international_7" value="1" checked=""><?= $lang_text_international_7; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_7" value="1"><?= $lang_text_international_7; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_8) { ?>
								<input type="checkbox" name="usps_international_8" value="1" checked=""><?= $lang_text_international_8; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_8" value="1"><?= $lang_text_international_8; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_9) { ?>
								<input type="checkbox" name="usps_international_9" value="1" checked=""><?= $lang_text_international_9; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_9" value="1"><?= $lang_text_international_9; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_10) { ?>
								<input type="checkbox" name="usps_international_10" value="1" checked=""><?= $lang_text_international_10; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_10" value="1"><?= $lang_text_international_10; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_11) { ?>
								<input type="checkbox" name="usps_international_11" value="1" checked=""><?= $lang_text_international_11; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_11" value="1"><?= $lang_text_international_11; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_12) { ?>
								<input type="checkbox" name="usps_international_12" value="1" checked=""><?= $lang_text_international_12; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_12" value="1"><?= $lang_text_international_12; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_13){ ?>
								<input type="checkbox" name="usps_international_13" value="1" checked=""><?= $lang_text_international_13; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_13" value="1"><?= $lang_text_international_13; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_14) { ?>
								<input type="checkbox" name="usps_international_14" value="1" checked=""><?= $lang_text_international_14; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_14" value="1"><?= $lang_text_international_14; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_15) { ?>
								<input type="checkbox" name="usps_international_15" value="1" checked=""><?= $lang_text_international_15; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_15" value="1"><?= $lang_text_international_15; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_16) { ?>
								<input type="checkbox" name="usps_international_16" value="1" checked=""><?= $lang_text_international_16; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_16" value="1"><?= $lang_text_international_16; ?>
								<?php } ?>
							</label>
							<label class="list-group-item">
								<?php if ($usps_international_21) { ?>
								<input type="checkbox" name="usps_international_21" value="1" checked=""><?= $lang_text_international_21; ?>
								<?php } else { ?>
								<input type="checkbox" name="usps_international_21" value="1"><?= $lang_text_international_21; ?>
								<?php } ?>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_size; ?></label>
				<div class="control-field col-sm-4">
					<select name="usps_size" class="form-control">
						<?php foreach ($sizes as $size) { ?>
						<?php if ($size['value'] == $usps_size) { ?>
						<option value="<?= $size['value']; ?>" selected><?= $size['text']; ?></option>
						<?php } else { ?>
						<option value="<?= $size['value']; ?>"><?= $size['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_container; ?></label>
				<div class="control-field col-sm-4">
					<select name="usps_container" class="form-control">
						<?php foreach ($containers as $container) { ?>
						<?php if ($container['value'] == $usps_container) { ?>
						<option value="<?= $container['value']; ?>" selected><?= $container['text']; ?></option>
						<?php } else { ?>
						<option value="<?= $container['value']; ?>"><?= $container['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_machinable; ?></label>
				<div class="control-field col-sm-4">
					<select name="usps_machinable" class="form-control">
						<?php if ($usps_machinable) { ?>
						<option value="1" selected><?= $lang_text_yes; ?></option>
						<option value="0"><?= $lang_text_no; ?></option>
						<?php } else { ?>
						<option value="1"><?= $lang_text_yes; ?></option>
						<option value="0" selected><?= $lang_text_no; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_dimension; ?></label>
				<div class="control-field col-sm-4">
					<div class="slim-row">
						<div class="slim-col-sm-4">
							<input type="text" name="usps_length" value="<?= $usps_length; ?>" class="form-control">
							<?php if ($error_length) { ?>
								<span class="help-block error"><?= $error_length; ?></span>
							<?php } ?>
						</div>
						<div class="slim-col-sm-4">
							<input type="text" name="usps_width" value="<?= $usps_width; ?>" class="form-control">
							<?php if ($error_width) { ?>
								<span class="help-block error"><?= $error_width; ?></span>
							<?php } ?>
						</div>
						<div class="slim-col-sm-4">
							<input type="text" name="usps_height" value="<?= $usps_height; ?>" class="form-control">
							<?php if ($error_height) { ?>
								<span class="help-block error"><?= $error_height; ?></span>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_display_time; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($usps_display_time) { ?>
						<label class="radio-inline"><input type="radio" name="usps_display_time" value="1" checked=""><?= $lang_text_yes; ?></label>
						<label class="radio-inline"><input type="radio" name="usps_display_time" value="0"><?= $lang_text_no; ?></label>
						<?php } else { ?>
						<label class="radio-inline"><input type="radio" name="usps_display_time" value="1"><?= $lang_text_yes; ?></label>
						<label class="radio-inline"><input type="radio" name="usps_display_time" value="0" checked=""><?= $lang_text_no; ?></label>
						<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_display_weight; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($usps_display_weight) { ?>
						<label class="radio-inline"><input type="radio" name="usps_display_weight" value="1" checked=""><?= $lang_text_yes; ?></label>
						<label class="radio-inline"><input type="radio" name="usps_display_weight" value="0"><?= $lang_text_no; ?></label>
						<?php } else { ?>
						<label class="radio-inline"><input type="radio" name="usps_display_weight" value="1"><?= $lang_text_yes; ?></label>
						<label class="radio-inline"><input type="radio" name="usps_display_weight" value="0" checked=""><?= $lang_text_no; ?></label>
						<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_weight_class; ?></label>
				<div class="control-field col-sm-4">
					<select name="usps_weight_class_id" class="form-control">
						<?php foreach ($weight_classes as $weight_class) { ?>
						<?php if ($weight_class['weight_class_id'] == $usps_weight_class_id) { ?>
						<option value="<?= $weight_class['weight_class_id']; ?>" selected><?= $weight_class['title']; ?></option>
						<?php } else { ?>
						<option value="<?= $weight_class['weight_class_id']; ?>"><?= $weight_class['title']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_tax; ?></label>
				<div class="control-field col-sm-4">
					<select name="usps_tax_class_id" class="form-control">
						<option value="0"><?= $lang_text_none; ?></option>
						<?php foreach ($tax_classes as $tax_class) { ?>
						<?php if ($tax_class['tax_class_id'] == $usps_tax_class_id) { ?>
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
					<select name="usps_geo_zone_id" class="form-control">
						<option value="0"><?= $lang_text_all_zones; ?></option>
						<?php foreach ($geo_zones as $geo_zone) { ?>
						<?php if ($geo_zone['geo_zone_id'] == $usps_geo_zone_id) { ?>
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
					<select name="usps_debug" class="form-control">
						<?php if ($usps_debug) { ?>
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
					<select name="usps_status" class="form-control">
						<?php if ($usps_status) { ?>
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
					<input type="text" name="usps_sort_order" value="<?= $usps_sort_order; ?>" class="form-control">
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>