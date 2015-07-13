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
		<div>
			<ul class="nav nav-tabs"><li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li>
				<?php foreach ($geo_zones as $geo_zone) { ?>
				<li><a href="#tab-geo-zone<?= $geo_zone['geo_zone_id']; ?>" data-toggle="tab"><?= $geo_zone['name']; ?></a></li>
				<?php } ?>
			</ul>
			<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<div class="tab-content">
					<div id="tab-general" class="tab-pane">
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_tax_class; ?></label>
							<div class="control-field col-sm-4">
								<select name="weight_tax_class_id" class="form-control">
									<option value="0"><?= $lang_text_none; ?></option>
									<?php foreach ($tax_classes as $tax_class) { ?>
									<?php if ($tax_class['tax_class_id'] == $weight_tax_class_id) { ?>
									<option value="<?= $tax_class['tax_class_id']; ?>" selected><?= $tax_class['title']; ?></option>
									<?php } else { ?>
									<option value="<?= $tax_class['tax_class_id']; ?>"><?= $tax_class['title']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
							<div class="control-field col-sm-4">
								<select name="weight_status" class="form-control">
									<?php if ($weight_status) { ?>
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
								<input type="text" name="weight_sort_order" value="<?= $weight_sort_order; ?>" class="form-control">
							</div>
						</div>
					</div>
					<?php foreach ($geo_zones as $geo_zone) { ?>
					<div id="tab-geo-zone<?= $geo_zone['geo_zone_id']; ?>" class="tab-pane">
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_rate; ?></label>
							<div class="control-field col-sm-4">
								<textarea name="weight_<?= $geo_zone['geo_zone_id']; ?>_rate" class="form-control" rows="3"><?= ${'weight_' . $geo_zone['geo_zone_id'] . '_rate'}; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
							<div class="control-field col-sm-4">
								<select name="weight_<?= $geo_zone['geo_zone_id']; ?>_status" class="form-control">
									<?php if (${'weight_' . $geo_zone['geo_zone_id'] . '_status'}) { ?>
									<option value="1" selected><?= $lang_text_enabled; ?></option>
									<option value="0"><?= $lang_text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?= $lang_text_enabled; ?></option>
									<option value="0" selected><?= $lang_text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</form>
		</div>
	</div>
</div>
<?= $footer; ?> 