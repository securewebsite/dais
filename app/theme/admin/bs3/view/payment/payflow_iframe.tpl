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
		<form class="form-inline" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="form">
				<tr>
					<td><b class="required">*</b> <?= $lang_entry_vendor; ?><br><span class="help-block muted"><?= $help_vendor ?></span></td>
					<td><input type="text" name="payflow_iframe_vendor" value="<?= $payflow_iframe_vendor; ?>" class="form-control" autofocus>
						<?php if ($error_vendor) { ?>
							<span class="help-block error"><?= $error_vendor; ?></span>
						<?php } ?></td>
				</tr>
				<tr>
					<td><b class="required">*</b> <?= $lang_entry_user; ?><br><span class="help-block muted"><?= $help_user ?></span></td>
					<td><input type="text" name="payflow_iframe_user" value="<?= $payflow_iframe_user; ?>" class="form-control">
						<?php if ($error_user) { ?>
							<span class="help-block error"><?= $error_user; ?></span>
						<?php } ?></td>
				</tr>
				<tr>
					<td><b class="required">*</b> <?= $lang_entry_password; ?><br><span class="help-block muted"><?= $help_password ?></span></td>
					<td><input type="text" name="payflow_iframe_password" value="<?= $payflow_iframe_password; ?>" class="form-control">
						<?php if ($error_password) { ?>
							<span class="help-block error"><?= $error_password; ?></span>
						<?php } ?></td>
				</tr>
				<tr>
					<td><b class="required">*</b> <?= $lang_entry_partner; ?><br><span class="help-block muted"><?= $help_partner ?></span></td>
					<td><input type="text" name="payflow_iframe_partner" value="<?= $payflow_iframe_partner; ?>" class="form-control">
						<?php if ($error_partner) { ?>
							<span class="help-block error"><?= $error_partner; ?></span>
						<?php } ?></td>
				</tr>
				<tr>
					<td><?= $lang_entry_transaction_method; ?></td>
					<td><select name="payflow_iframe_transaction_method" class="form-control">
							<?php if ($payflow_iframe_transaction_method == 'authorization') { ?>
								<option value="sale"><?= $lang_text_sale; ?></option>
								<option value="authorization" selected><?= $lang_text_authorization; ?></option>
							<?php } else { ?>
								<option value="sale" selected><?= $lang_text_sale; ?></option>
								<option value="authorization"><?= $lang_text_authorization; ?></option>
							<?php } ?>
						</select></td>
				</tr>
				<tr>
					<td><?= $lang_entry_test; ?></td>
					<td><?php if ($payflow_iframe_test) { ?>
							<input type="radio" name="payflow_iframe_test" value="1" checked="">
							<?= $lang_text_yes; ?>
							<input type="radio" name="payflow_iframe_test" value="0">
							<?= $lang_text_no; ?>
						<?php } else { ?>
							<input type="radio" name="payflow_iframe_test" value="1">
							<?= $lang_text_yes; ?>
							<input type="radio" name="payflow_iframe_test" value="0" checked="">
							<?= $lang_text_no; ?>
						<?php } ?></td>
				</tr>
				<tr>
					<td><?= $lang_entry_debug; ?><br><span class="help-block muted"><?= $lang_help_debug ?></span></td>
					<td><select name="payflow_iframe_debug" class="form-control">
							<?php if ($payflow_iframe_debug) { ?>
								<option value="1" selected><?= $lang_text_yes ?></option>
								<option value="0"><?= $lang_text_no ?></option>
							<?php } else { ?>
								<option value="1"><?= $lang_text_yes ?></option>
								<option value="0" selected><?= $lang_text_no ?></option>
							<?php } ?>
						</select></td>
				</tr>
				<tr>
					<td><?= $lang_entry_checkout_method ?><br><span class="help-block muted"><?= $lang_help_checkout_method ?></span></td>
					<td><select name="payflow_iframe_checkout_method" class="form-control">
							<?php if ($payflow_iframe_checkout_method == 'iframe'): ?>
								<option value="iframe" selected><?= $lang_text_iframe ?></option>
								<option value="redirect"><?= $lang_text_redirect ?></option>
							<?php else: ?>
								<option value="iframe"><?= $lang_text_iframe ?></option>
								<option value="redirect" selected><?= $lang_text_redirect ?></option>
							<?php endif; ?>
						</select></td>
				</tr>
				<tr>
					<td><?= $lang_entry_order_status; ?></td>
					<td><select name="payflow_iframe_order_status_id" class="form-control">
							<?php foreach ($order_statuses as $order_status) { ?>
								<?php if ($order_status['order_status_id'] == $payflow_iframe_order_status_id) { ?>
									<option value="<?= $order_status['order_status_id']; ?>" selected><?= $order_status['name']; ?></option>
								<?php } else { ?>
									<option value="<?= $order_status['order_status_id']; ?>"><?= $order_status['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select></td>
				</tr>
				<tr>
					<td><?= $lang_entry_total; ?></td>
					<td><input type="text" name="payflow_iframe_total" value="<?= $payflow_iframe_total; ?>" class="form-control"></td>
				</tr>
				<tr>
					<td><?= $lang_entry_geo_zone; ?></td>
					<td><select name="payflow_iframe_geo_zone_id" class="form-control">
							<option value="0"><?= $lang_text_all_zones; ?></option>
							<?php foreach ($geo_zones as $geo_zone) { ?>
								<?php if ($geo_zone['geo_zone_id'] == $payflow_iframe_geo_zone_id) { ?>
									<option value="<?= $geo_zone['geo_zone_id']; ?>" selected><?= $geo_zone['name']; ?></option>
								<?php } else { ?>
									<option value="<?= $geo_zone['geo_zone_id']; ?>"><?= $geo_zone['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select></td>
				</tr>
				<tr>
					<td><?= $lang_entry_status; ?></td>
					<td><select name="payflow_iframe_status" class="form-control">
							<?php if ($payflow_iframe_status) { ?>
								<option value="1" selected><?= $lang_text_enabled; ?></option>
								<option value="0"><?= $lang_text_disabled; ?></option>
							<?php } else { ?>
								<option value="1"><?= $lang_text_enabled; ?></option>
								<option value="0" selected><?= $lang_text_disabled; ?></option>
							<?php } ?>
						</select></td>
				</tr>
				<tr>
					<td><?= $lang_entry_sort_order; ?></td>
					<td><input type="text" name="payflow_iframe_sort_order" value="<?= $payflow_iframe_sort_order; ?>" class="form-control"></td>
				</tr>
				<tr>
					<td><?= $lang_entry_cancel_url; ?></td>
					<td><?= $cancel_url ?></td>
				</tr>
				<tr>
					<td><?= $lang_entry_error_url; ?></td>
					<td><?= $error_url ?></td>
				</tr>
				<tr>
					<td><?= $lang_entry_return_url; ?></td>
					<td><?= $return_url ?></td>
				</tr>
				<tr>
					<td><?= $lang_entry_post_url; ?></td>
					<td><?= $post_url ?></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?= $footer; ?>