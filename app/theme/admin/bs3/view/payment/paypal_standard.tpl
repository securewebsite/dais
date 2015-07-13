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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_email; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="paypal_standard_email" value="<?= $paypal_standard_email; ?>" class="form-control" autofocus>
					<?php if ($error_email) { ?>
						<div class="help-block error"><?= $error_email; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_test; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($paypal_standard_test) { ?>
					<label class="radio-inline"><input type="radio" name="paypal_standard_test" value="1" checked=""><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="paypal_standard_test" value="0"><?= $lang_text_no; ?></label>
					<?php } else { ?>
					<label class="radio-inline"><input type="radio" name="paypal_standard_test" value="1"><?= $lang_text_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="paypal_standard_test" value="0" checked=""><?= $lang_text_no; ?></label>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_transaction; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_transaction" class="form-control">
						<?php if (!$paypal_standard_transaction) { ?>
						<option value="0" selected><?= $lang_text_authorization; ?></option>
						<?php } else { ?>
						<option value="0"><?= $lang_text_authorization; ?></option>
						<?php } ?>
						<?php if ($paypal_standard_transaction) { ?>
						<option value="1" selected><?= $lang_text_sale; ?></option>
						<?php } else { ?>
						<option value="1"><?= $lang_text_sale; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_debug; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_debug" class="form-control">
						<?php if ($paypal_standard_debug) { ?>
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
				<label class="control-label col-sm-2"><?= $lang_entry_total; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="paypal_standard_total" value="<?= $paypal_standard_total; ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_canceled_reversal_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_canceled_reversal_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_canceled_reversal_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_completed_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_completed_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_completed_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_denied_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_denied_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_denied_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_expired_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_expired_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_expired_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_failed_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_failed_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_failed_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_pending_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_pending_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_pending_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_processed_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_processed_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_processed_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_refunded_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_refunded_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_refunded_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_reversed_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_reversed_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_reversed_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_voided_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_voided_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $paypal_standard_voided_status_id) { ?>
						<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_geo_zone; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_geo_zone_id" class="form-control">
						<option value="0"><?= $lang_text_all_zones; ?></option>
						<?php foreach ($geo_zones as $geo_zone) { ?>
						<?php if ($geo_zone['geo_zone_id'] == $paypal_standard_geo_zone_id) { ?>
						<option value="<?= $geo_zone['geo_zone_id']; ?>" selected><?= $geo_zone['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $geo_zone['geo_zone_id']; ?>"><?= $geo_zone['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="paypal_standard_status" class="form-control">
						<?php if ($paypal_standard_status) { ?>
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
					<input type="text" name="paypal_standard_sort_order" value="<?= $paypal_standard_sort_order; ?>" class="form-control">
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?> 