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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_login; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="authorizenet_login" value="<?= $authorizenet_login; ?>" class="form-control">
					<?php if ($error_login) { ?>
						<div class="help-block error"><?= $error_login; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_key; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="authorizenet_key" value="<?= $authorizenet_key; ?>" class="form-control">
					<?php if ($error_key) { ?>
						<div class="help-block error"><?= $error_key; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_hash; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="authorizenet_hash" value="<?= $authorizenet_hash; ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_server; ?></label>
				<div class="control-field col-sm-4">
					<select name="authorizenet_server" class="form-control">
						<?php if ($authorizenet_server == 'live'){ ?>
						<option value="live" selected><?= $lang_text_live; ?></option>
						<?php } else { ?>
						<option value="live"><?= $lang_text_live; ?></option>
						<?php } ?>
						<?php if ($authorizenet_server == 'test') { ?>
						<option value="test" selected><?= $lang_text_test; ?></option>
						<?php } else { ?>
						<option value="test"><?= $lang_text_test; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_mode; ?></label>
				<div class="control-field col-sm-4">
					<select name="authorizenet_mode" class="form-control">
						<?php if ($authorizenet_mode == 'live'){ ?>
						<option value="live" selected><?= $lang_text_live; ?></option>
						<?php } else { ?>
						<option value="live"><?= $lang_text_live; ?></option>
						<?php } ?>
						<?php if ($authorizenet_mode == 'test') { ?>
						<option value="test" selected><?= $lang_text_test; ?></option>
						<?php } else { ?>
						<option value="test"><?= $lang_text_test; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_method; ?></label>
				<div class="control-field col-sm-4">
					<select name="authorizenet_method" class="form-control">
						<?php if ($authorizenet_method == 'authorization') { ?>
						<option value="authorization" selected><?= $lang_text_authorization; ?></option>
						<?php } else { ?>
						<option value="authorization"><?= $lang_text_authorization; ?></option>
						<?php } ?>
						<?php if ($authorizenet_method == 'capture'){ ?>
						<option value="capture" selected><?= $lang_text_capture; ?></option>
						<?php } else { ?>
						<option value="capture"><?= $lang_text_capture; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_total; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="authorizenet_total" value="<?= $authorizenet_total; ?>" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_order_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="authorizenet_order_status_id" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $authorizenet_order_status_id) { ?>
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
					<select name="authorizenet_geo_zone_id" class="form-control">
						<option value="0"><?= $lang_text_all_zones; ?></option>
						<?php foreach ($geo_zones as $geo_zone) { ?>
						<?php if ($geo_zone['geo_zone_id'] == $authorizenet_geo_zone_id) { ?>
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
					<select name="authorizenet_status" class="form-control">
						<?php if ($authorizenet_status) { ?>
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
					<input type="text" name="authorizenet_sort_order" value="<?= $authorizenet_sort_order; ?>" class="form-control">
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?> 