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
			<div class="pull-left h2"><i class="hidden-xs fa fa-credit-card"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form-ppexpress" class="btn btn-primary">
					<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
					<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
				<a href="<?= $search; ?>" class="btn btn-info"><i class="fa fa-search"></i></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-ppexpress" class="form-horizontal">
			<input type="hidden" name="paypalexpress_login_seamless" value="1">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab-api-details" data-toggle="tab"><?= $lang_tab_api_details; ?></a></li>
				<li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li>
				<li><a href="#tab-status" data-toggle="tab"><?= $lang_tab_order_status; ?></a></li>
				<li><a href="#tab-customise" data-toggle="tab"><?= $lang_tab_customise; ?></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-api-details">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="entry-username"><span class="required">*</span> <?= $lang_entry_username; ?></label>
						<div class="col-sm-10">
							<input type="text" name="paypalexpress_username" value="<?= $paypalexpress_username; ?>" 
								placeholder="<?= $lang_entry_username; ?>" id="entry-username" class="form-control" required>
							<?php if (isset($error['username'])) { ?>
							<div class="text-danger"><?= $error['username']; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="entry-password"><span class="required">*</span> <?= $lang_entry_password; ?></label>
						<div class="col-sm-10">
							<input type="text" name="paypalexpress_password" value="<?= $paypalexpress_password; ?>" 
								placeholder="<?= $lang_entry_password; ?>" id="entry-password" class="form-control" required>
							<?php if (isset($error['password'])) { ?>
							<div class="text-danger"><?= $error['password']; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="entry-signature"><span class="required">*</span> <?= $lang_entry_signature; ?></label>
						<div class="col-sm-10">
							<input type="text" name="paypalexpress_signature" value="<?= $paypalexpress_signature; ?>" 
								placeholder="<?= $lang_entry_signature; ?>" id="entry-signature" class="form-control" required>
							<?php if (isset($error['signature'])) { ?>
							<div class="text-danger"><?= $error['signature']; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><?= $lang_text_ipn; ?></label>
						<div class="col-sm-10">
						<div class="input-group"> <span class="input-group-addon"><i class="fa fa-link"></i></span>
							<input type="text" value="<?= $text_ipn_url; ?>" class="form-control" />
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="tab-general">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-live-demo"><?= $lang_entry_test; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_test" id="input-live-demo" class="form-control">
						<?php if ($paypalexpress_test) { ?>
							<option value="1" selected="selected"><?= $lang_text_yes; ?></option>
							<option value="0"><?= $lang_text_no; ?></option>
						<?php } else { ?>
							<option value="1"><?= $lang_text_yes; ?></option>
							<option value="0" selected="selected"><?= $lang_text_no; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-debug"><?= $lang_entry_debug; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_debug" id="input-debug" class="form-control">
						<?php if ($paypalexpress_debug) { ?>
							<option value="1" selected="selected"><?= $lang_text_yes; ?></option>
							<option value="0"><?= $lang_text_no; ?></option>
						<?php } else { ?>
							<option value="1"><?= $lang_text_yes; ?></option>
							<option value="0" selected="selected"><?= $lang_text_no; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-currency"><?= $lang_entry_currency; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_currency" id="input-currency" class="form-control">
						<?php foreach ($currency_codes as $code) { ?>
						<?php if ($code == $paypalexpress_currency) { ?>
							<option value="<?= $code; ?>" selected="selected"><?= $code; ?></option>
						<?php } else { ?>
							<option value="<?= $code; ?>"><?= $code; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-recurring-cancel"><?= $lang_entry_recurring_cancellation; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_recurring_cancel_status" id="input-recurring-cancel" class="form-control">
						<?php if ($paypalexpress_recurring_cancel_status) { ?>
							<option value="1" selected="selected"><?= $lang_text_enabled; ?></option>
							<option value="0"><?= $lang_text_disabled; ?></option>
						<?php } else { ?>
							<option value="1"><?= $lang_text_enabled; ?></option>
							<option value="0" selected="selected"><?= $lang_text_disabled; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-method"><?= $lang_entry_method; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_method" id="input-method" class="form-control">
							<option value="Sale" <?php  echo (($paypalexpress_method == '' || $paypalexpress_method == 'Sale') ? 'selected="selected"' : ''); ?>><?= $lang_text_sale; ?></option>
							<option value="Authorization" <?= ($paypalexpress_method == 'Authorization' ? 'selected="selected"' : ''); ?>><?= $lang_text_authorization; ?></option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-total"><?= $lang_entry_total; ?></label>
					<div class="col-sm-10">
						<input type="text" name="paypalexpress_total" value="<?= $paypalexpress_total; ?>" id="input-total" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-sort-order"><?= $lang_entry_sort_order; ?></label>
					<div class="col-sm-10">
						<input type="text" name="paypalexpress_sort_order" value="<?= $paypalexpress_sort_order; ?>" placeholder="<?= $lang_entry_sort_order; ?>" id="input-sort-order" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-geo-zone"><?= $lang_entry_geo_zone; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_geo_zone_id" id="input-geo-zone" class="form-control">
						<option value="0"><?= $lang_text_all_zones; ?></option>
						<?php foreach ($geo_zones as $geo_zone) { ?>
						<?php if ($geo_zone['geo_zone_id'] == $paypalexpress_geo_zone_id) { ?>
							<option value="<?= $geo_zone['geo_zone_id']; ?>" selected="selected"><?= $geo_zone['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $geo_zone['geo_zone_id']; ?>"><?= $geo_zone['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-status"><?= $lang_entry_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_status" id="input-status" class="form-control">
						<?php if ($paypalexpress_status) { ?>
							<option value="1" selected="selected"><?= $lang_text_enabled; ?></option>
							<option value="0"><?= $lang_text_disabled; ?></option>
						<?php } else { ?>
							<option value="1"><?= $lang_text_enabled; ?></option>
							<option value="0" selected="selected"><?= $lang_text_disabled; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="tab-status">
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_canceled_reversal_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_canceled_reversal_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_canceled_reversal_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_completed_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_completed_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_completed_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_denied_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_denied_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_denied_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_expired_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_expired_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_expired_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_failed_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_failed_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_failed_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_pending_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_pending_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_pending_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_processed_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_processed_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_processed_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_refunded_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_refunded_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_refunded_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_reversed_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_reversed_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_reversed_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?= $lang_entry_voided_status; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_voided_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypalexpress_voided_status_id) { ?>
							<option value="<?= $order_status['order_status_id']; ?>" selected="selected"><?= $order_status['name']; ?></option>
						<?php } else { ?>
							<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="tab-customise">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-notes"><?= $lang_entry_allow_notes; ?></label>
					<div class="col-sm-10">
						<select name="paypalexpress_allow_note" id="input-notes" class="form-control">
						<?php if ($paypalexpress_allow_note) { ?>
							<option value="1" selected="selected"><?= $lang_text_yes; ?></option>
							<option value="0"><?= $lang_text_no; ?></option>
						<?php } else { ?>
							<option value="1"><?= $lang_text_yes; ?></option>
							<option value="0" selected="selected"><?= $lang_text_no; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-page-color"><?= $lang_entry_page_colour; ?></label>
					<div class="col-sm-10">
						<input type="text" name="paypalexpress_page_colour" value="<?= $paypalexpress_page_colour; ?>" id="input-page-color" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-image"><?= $lang_entry_logo; ?></label>
					<div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?= $thumb; ?>" alt="" title="" data-placeholder="<?= $no_image; ?>" /></a>
						<input type="hidden" name="paypalexpress_logo" value="<?= $paypalexpress_logo; ?>" id="input-image" />
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?= $footer; ?> 