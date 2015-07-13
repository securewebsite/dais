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
					<input type="text" name="fedex_key" value="<?= $fedex_key; ?>" class="form-control">
					<?php if ($error_key) { ?>
					<div class="help-block error"><?= $error_key; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_password; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="fedex_password" value="<?= $fedex_password; ?>" class="form-control">
					<?php if ($error_password) { ?>
					<div class="help-block error"><?= $error_password; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_account; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="fedex_account" value="<?= $fedex_account; ?>" class="form-control">
					<?php if ($error_account) { ?>
						<div class="help-block error"><?= $error_account; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_meter; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="fedex_meter" value="<?= $fedex_meter; ?>" class="form-control">
					<?php if ($error_meter) { ?>
						<div class="help-block error"><?= $error_meter; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_postcode; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="fedex_postcode" value="<?= $fedex_postcode; ?>" class="form-control">
					<?php if ($error_postcode) { ?>
						<div class="help-block error"><?= $error_postcode; ?></div>
					<?php } ?>
				</div>
			</div>	
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_test; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($fedex_test) { ?>
						<label class="radio-inline"><input type="radio" name="fedex_test" value="1" checked=""><?= $lang_text_yes; ?></label>
						<label class="radio-inline"><input type="radio" name="fedex_test" value="0"><?= $lang_text_no; ?></label>
						<?php } else { ?>
						<label class="radio-inline"><input type="radio" name="fedex_test" value="1"><?= $lang_text_yes; ?></label>
						<label class="radio-inline"><input type="radio" name="fedex_test" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><p><?= $lang_entry_service; ?></p>
					<div class="btn-group-vertical">
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'fedex_service\']').prop('checked',true);"><?= $lang_text_select_all; ?></a>
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'fedex_service\']').prop('checked',false);"><?= $lang_text_unselect_all; ?></a>
					</div>
				</label>
				<div class="control-field col-sm-4">
					<div class="panel panel-default panel-scrollable">
						<div class="list-group list-group-hover">
						<?php foreach ($services as $service) { ?>
						<label class="list-group-item">
							<?php if (in_array($service['value'], $fedex_service)) { ?>
							<input type="checkbox" name="fedex_service[]" value="<?= $service['value']; ?>" checked=""><?= $service['text']; ?>
							<?php } else { ?>
							<input type="checkbox" name="fedex_service[]" value="<?= $service['value']; ?>"><?= $service['text']; ?>
							<?php } ?>
						</label>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_dropoff_type; ?></label>
				<div class="control-field col-sm-4">
					<select name="fedex_dropoff_type" class="form-control">
						<?php if ($fedex_dropoff_type == 'REGULAR_PICKUP') { ?>
						<option value="REGULAR_PICKUP" selected><?= $lang_text_regular_pickup; ?></option>
						<?php } else { ?>
						<option value="REGULAR_PICKUP"><?= $lang_text_regular_pickup; ?></option>
						<?php } ?>
						<?php if ($fedex_dropoff_type == 'REQUEST_COURIER') { ?>
						<option value="REQUEST_COURIER" selected><?= $lang_text_request_courier; ?></option>
						<?php } else { ?>
						<option value="REQUEST_COURIER"><?= $lang_text_request_courier; ?></option>
						<?php } ?>
						<?php if ($fedex_dropoff_type == 'DROP_BOX') { ?>
						<option value="DROP_BOX" selected><?= $lang_text_drop_box; ?></option>
						<?php } else { ?>
						<option value="DROP_BOX"><?= $lang_text_drop_box; ?></option>
						<?php } ?>
						<?php if ($fedex_dropoff_type == 'BUSINESS_SERVICE_CENTER') { ?>
						<option value="BUSINESS_SERVICE_CENTER" selected><?= $lang_text_business_service_center; ?></option>
						<?php } else { ?>
						<option value="BUSINESS_SERVICE_CENTER"><?= $lang_text_business_service_center; ?></option>
						<?php } ?>
						<?php if ($fedex_dropoff_type == 'STATION') { ?>
						<option value="STATION" selected><?= $lang_text_station; ?></option>
						<?php } else { ?>
						<option value="STATION"><?= $lang_text_station; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_packaging_type; ?></label>
				<div class="control-field col-sm-4">
					<select name="fedex_packaging_type" class="form-control">
						<?php if ($fedex_packaging_type == 'FEDEX_ENVELOPE') { ?>
						<option value="FEDEX_ENVELOPE" selected><?= $lang_text_fedex_envelope; ?></option>
						<?php } else { ?>
						<option value="FEDEX_ENVELOPE"><?= $lang_text_fedex_envelope; ?></option>
						<?php } ?>
						<?php if ($fedex_packaging_type == 'FEDEX_PAK') { ?>
						<option value="FEDEX_PAK" selected><?= $lang_text_fedex_pak; ?></option>
						<?php } else { ?>
						<option value="FEDEX_PAK"><?= $lang_text_fedex_pak; ?></option>
						<?php } ?>
						<?php if ($fedex_packaging_type == 'FEDEX_BOX') { ?>
						<option value="FEDEX_BOX" selected><?= $lang_text_fedex_box; ?></option>
						<?php } else { ?>
						<option value="FEDEX_BOX"><?= $lang_text_fedex_box; ?></option>
						<?php } ?>
						<?php if ($fedex_packaging_type == 'FEDEX_TUBE') { ?>
						<option value="FEDEX_TUBE" selected><?= $lang_text_fedex_tube; ?></option>
						<?php } else { ?>
						<option value="FEDEX_TUBE"><?= $lang_text_fedex_tube; ?></option>
						<?php } ?>
						<?php if ($fedex_packaging_type == 'FEDEX_10KG_BOX') { ?>
						<option value="FEDEX_10KG_BOX" selected><?= $lang_text_fedex_10kg_box; ?></option>
						<?php } else { ?>
						<option value="FEDEX_10KG_BOX"><?= $lang_text_fedex_10kg_box; ?></option>
						<?php } ?>
						<?php if ($fedex_packaging_type == 'STATION') { ?>
						<option value="FEDEX_25KG_BOX" selected><?= $lang_text_fedex_25kg_box; ?></option>
						<?php } else { ?>
						<option value="FEDEX_25KG_BOX"><?= $lang_text_fedex_25kg_box; ?></option>
						<?php } ?>
						<?php if ($fedex_packaging_type == 'STATION') { ?>
						<option value="YOUR_PACKAGING" selected><?= $lang_text_your_packaging; ?></option>
						<?php } else { ?>
						<option value="YOUR_PACKAGING"><?= $lang_text_your_packaging; ?></option>
						<?php } ?>										
					</select>
				</div>
			</div> 
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_rate_type; ?></label>
				<div class="control-field col-sm-4">
					<select name="fedex_rate_type" class="form-control">
						<?php if ($fedex_rate_type == 'LIST') { ?>
						<option value="LIST" selected><?= $lang_text_list_rate; ?></option>
						<?php } else { ?>
						<option value="LIST"><?= $lang_text_list_rate; ?></option>
						<?php } ?>
						<?php if ($fedex_rate_type == 'ACCOUNT') { ?>
						<option value="ACCOUNT" selected><?= $lang_text_account_rate; ?></option>
						<?php } else { ?>
						<option value="ACCOUNT"><?= $lang_text_account_rate; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_display_time; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($fedex_display_time) { ?>
					<label class="radio-inline"><input type="radio" name="fedex_display_time" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="fedex_display_time" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="fedex_display_time" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="fedex_display_time" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_display_weight; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($fedex_display_weight) { ?>
					<label class="radio-inline"><input type="radio" name="fedex_display_weight" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="fedex_display_weight" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="fedex_display_weight" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="fedex_display_weight" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_weight_class; ?></label>
				<div class="control-field col-sm-4">
					<select name="fedex_weight_class_id" class="form-control">
						<?php foreach ($weight_classes as $weight_class) { ?>
						<?php if ($weight_class['weight_class_id'] == $fedex_weight_class_id) { ?>
						<option value="<?= $weight_class['weight_class_id']; ?>" selected><?= $weight_class['title']; ?></option>
						<?php } else { ?>
						<option value="<?= $weight_class['weight_class_id']; ?>"><?= $weight_class['title']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>							
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_tax_class; ?></label>
				<div class="control-field col-sm-4">
					<select name="fedex_tax_class_id" class="form-control">
						<option value="0"><?= $lang_text_none; ?></option>
						<?php foreach ($tax_classes as $tax_class) { ?>
						<?php if ($tax_class['tax_class_id'] == $fedex_tax_class_id) { ?>
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
					<select name="fedex_geo_zone_id" class="form-control">
						<option value="0"><?= $lang_text_all_zones; ?></option>
						<?php foreach ($geo_zones as $geo_zone) { ?>
						<?php if ($geo_zone['geo_zone_id'] == $fedex_geo_zone_id) { ?>
						<option value="<?= $geo_zone['geo_zone_id']; ?>" selected><?= $geo_zone['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $geo_zone['geo_zone_id']; ?>"><?= $geo_zone['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_status ?></label>
				<div class="control-field col-sm-4">
					<select name="fedex_status" class="form-control">
						<?php if ($fedex_status) { ?>
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
					<input type="text" name="fedex_sort_order" value="<?= $fedex_sort_order; ?>" class="form-control">
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>