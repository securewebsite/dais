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
			<div class="pull-left h2"><i class="hidden-xs fa fa-money"></i><?= $lang_heading_title; ?></div>
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
					<input type="text" name="name" value="<?= $name; ?>" class="form-control" autofocus>
					<?php if ($error_name) { ?>
						<div class="help-block error"><?= $error_name; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_rate; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="rate" value="<?= $rate; ?>" class="form-control">
					<?php if ($error_rate) { ?>
						<div class="help-block error"><?= $error_rate; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_type; ?></label>
				<div class="control-field col-sm-4">
					<select name="type" class="form-control">
						<?php if ($type == 'P') { ?>
						<option value="P" selected><?= $lang_text_percent; ?></option>
						<?php } else { ?>
						<option value="P"><?= $lang_text_percent; ?></option>
						<?php } ?>
						<?php if ($type == 'F') { ?>
						<option value="F" selected><?= $lang_text_amount; ?></option>
						<?php } else { ?>
						<option value="F"><?= $lang_text_amount; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_customer_group; ?></label>
				<div class="control-field col-sm-4">
					<div class="panel panel-default panel-scrollable">
						<div class="list-group list-group-hover">
						<?php foreach ($customer_groups as $customer_group) { ?>
						<label class="list-group-item">
							<?php if (in_array($customer_group['customer_group_id'], $tax_rate_customer_group)) { ?>
							<input type="checkbox" name="tax_rate_customer_group[]" value="<?= $customer_group['customer_group_id']; ?>" checked="">
							<?= $customer_group['name']; ?>
							<?php } else { ?>
							<input type="checkbox" name="tax_rate_customer_group[]" value="<?= $customer_group['customer_group_id']; ?>">
							<?= $customer_group['name']; ?>
							<?php } ?>
						</label>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_geo_zone; ?></label>
				<div class="control-field col-sm-4">
					<select name="geo_zone_id" class="form-control">
						<?php foreach ($geo_zones as $geo_zone) { ?>
						<?php	if ($geo_zone['geo_zone_id'] == $geo_zone_id) { ?>
						<option value="<?= $geo_zone['geo_zone_id']; ?>" selected><?= $geo_zone['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $geo_zone['geo_zone_id']; ?>"><?= $geo_zone['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>