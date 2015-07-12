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
			<ul id="htabs" class="nav nav-tabs">
				<li><a href="#tab-settings" data-toggle="tab"><?= $lang_tab_settings; ?></a></li>
				<li><a href="#tab-order-status" data-toggle="tab"><?= $lang_tab_order_status; ?></a></li>
			</ul>
			<div class="tab-content">
			<div class="tab-pane" id="tab-settings">
				<table class="form">
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_user; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="paypal_pro_iframe_user" value="<?= $paypal_pro_iframe_user; ?>" class="form-control" autofocus>
							<?php if ($error_user) { ?>
								<span class="help-block error"><?= $error_user; ?></span>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_password; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="paypal_pro_iframe_password" value="<?= $paypal_pro_iframe_password; ?>" class="form-control">
							<?php if ($error_password) { ?>
								<span class="help-block error"><?= $error_password; ?></span>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_sig; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="paypal_pro_iframe_sig" value="<?= $paypal_pro_iframe_sig; ?>" class="form-control">
							<?php if ($error_sig) { ?>
								<span class="help-block error"><?= $error_sig; ?></span>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_transaction_method; ?></label>
						<div class="control-field col-sm-4">
							<select name="paypal_pro_iframe_transaction_method" class="form-control">
								<?php if ($paypal_pro_iframe_transaction_method == 'authorization') { ?>
									<option value="sale"><?= $lang_text_sale; ?></option>
									<option value="authorization" selected><?= $lang_text_authorization; ?></option>
								<?php } else { ?>
									<option value="sale" selected><?= $lang_text_sale; ?></option>
									<option value="authorization"><?= $lang_text_authorization; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_test; ?></label>
						<div class="control-field col-sm-4">
							<?php if ($paypal_pro_iframe_test) { ?>
								<label class="radio-inline"><input type="radio" name="paypal_pro_iframe_test" value="1" checked=""><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="paypal_pro_iframe_test" value="0"><?= $lang_text_no; ?></label>
							<?php } else { ?>
								<label class="radio-inline"><input type="radio" name="paypal_pro_iframe_test" value="1"><?= $lang_text_yes; ?></label>
								<label class="radio-inline"><input type="radio" name="paypal_pro_iframe_test" value="0" checked=""><?= $lang_text_no; ?></label>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_debug; ?><br><span class="help-block muted"><?= $lang_help_debug ?></span></label>
						<div class="control-field col-sm-4">
							<select name="paypal_pro_iframe_debug" class="form-control">
								<?php if ($paypal_pro_iframe_debug) { ?>
									<option value="1" selected><?= $lang_text_yes ?></option>
									<option value="0"><?= $lang_text_no ?></option>
								<?php } else { ?>
									<option value="1"><?= $lang_text_yes ?></option>
									<option value="0" selected><?= $lang_text_no ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_checkout_method ?><br><span class="help-block muted"><?= $lang_help_checkout_method ?></span></label>
						<div class="control-field col-sm-4">
							<select name="paypal_pro_iframe_checkout_method" class="form-control">
								<?php if ($paypal_pro_iframe_checkout_method == 'iframe'): ?>
								<option value="iframe" selected><?= $lang_text_iframe ?></option>
								<option value="redirect"><?= $lang_text_redirect ?></option>
								<?php else: ?>
								<option value="iframe"><?= $lang_text_iframe ?></option>
								<option value="redirect" selected><?= $lang_text_redirect ?></option>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_total; ?></label>
						<div class="control-field col-sm-4">
							<input type="text" name="paypal_pro_iframe_total" value="<?= $paypal_pro_iframe_total; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_geo_zone; ?></label>
						<div class="control-field col-sm-4">
							<select name="paypal_pro_iframe_geo_zone_id" class="form-control">
								<option value="0"><?= $lang_text_all_zones; ?></option>
								<?php foreach ($geo_zones as $geo_zone) { ?>
									<?php if ($geo_zone['geo_zone_id'] == $paypal_pro_iframe_geo_zone_id) { ?>
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
							<select name="paypal_pro_iframe_status" class="form-control">
								<?php if ($paypal_pro_iframe_status) { ?>
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
							<input type="text" name="paypal_pro_iframe_sort_order" value="<?= $paypal_pro_iframe_sort_order; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_ipn_url; ?></label>
						<div class="control-field col-sm-4">
							<p class="form-control-static"><?= $ipn_url ?></p>
						</div>
					</div>
				</table>
			</div>
			<div class="tab-pane" id="tab-order-status">
				<table class="form">
					<div class="form-group">
						<label class="control-label col-sm-2"><?= $lang_entry_canceled_reversal_status; ?></label>
						<div class="control-field col-sm-4">
							<select name="paypal_pro_iframe_canceled_reversal_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_canceled_reversal_status_id) { ?>
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
							<select name="paypal_pro_iframe_completed_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_completed_status_id) { ?>
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
							<select name="paypal_pro_iframe_denied_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_denied_status_id) { ?>
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
							<select name="paypal_pro_iframe_expired_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_expired_status_id) { ?>
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
							<select name="paypal_pro_iframe_failed_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_failed_status_id) { ?>
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
							<select name="paypal_pro_iframe_pending_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_pending_status_id) { ?>
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
							<select name="paypal_pro_iframe_processed_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_processed_status_id) { ?>
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
							<select name="paypal_pro_iframe_refunded_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_refunded_status_id) { ?>
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
							<select name="paypal_pro_iframe_reversed_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_reversed_status_id) { ?>
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
							<select name="paypal_pro_iframe_voided_status_id" class="form-control">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $paypal_pro_iframe_voided_status_id) { ?>
										<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
									<?php } else { ?>
										<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
				</table>
			</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>