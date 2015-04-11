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
			<div class="pull-left h2"><i class="hidden-xs fa fa-globe"></i><?= $lang_heading_title; ?></div>
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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_description; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="description" value="<?= $description; ?>" class="form-control">
					<?php if ($error_description) { ?>
						<div class="help-block error"><?= $error_description; ?></div>
					<?php } ?>
				</div>
			</div>
			<table id="zone-to-geo-zone" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><?= $lang_entry_country; ?></th>
						<th><?= $lang_entry_zone; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php $zone_to_geo_zone_row = 0; ?>
				<?php foreach ($zone_to_geo_zones as $zone_to_geo_zone) { ?>
					<tr id="zone-to-geo-zone-row<?= $zone_to_geo_zone_row; ?>">
						<td><select name="zone_to_geo_zone[<?= $zone_to_geo_zone_row; ?>][country_id]" id="country<?= $zone_to_geo_zone_row; ?>" onchange="$('#zone<?= $zone_to_geo_zone_row; ?>').load('index.php?route=localization/geozone/zone&token=<?= $token; ?>&country_id='+this.value+'&zone_id=0');" class="form-control">
							<?php foreach ($countries as $country) { ?>
							<?php	if ($country['country_id'] == $zone_to_geo_zone['country_id']) { ?>
							<option value="<?= $country['country_id']; ?>" selected><?= $country['name']; ?></option>
							<?php } else { ?>
							<option value="<?= $country['country_id']; ?>"><?= $country['name']; ?></option>
							<?php } ?>
							<?php } ?>
						</select></td>
						<td><select name="zone_to_geo_zone[<?= $zone_to_geo_zone_row; ?>][zone_id]" id="zone<?= $zone_to_geo_zone_row; ?>" class="form-control"></select></td>
						<td><a onclick="$('#zone-to-geo-zone-row<?= $zone_to_geo_zone_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
					</tr>
				<?php $zone_to_geo_zone_row++; ?>
				<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"></td>
						<td><a onclick="addGeoZone();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs">	<?= $lang_button_add_geo_zone; ?></span></a></td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</div>
<?php $zone_to_geo_zone_row = 0; ?>
<?= $footer; ?>
<script>
$('#zone-id').load('index.php?route=localization/geozone/zone&token=<?= $token; ?>&country_id='+$('#country-id').val()+'&zone_id=0');
<?php foreach ($zone_to_geo_zones as $zone_to_geo_zone) { ?>
$('#zone<?= $zone_to_geo_zone_row; ?>').load('index.php?route=localization/geozone/zone&token=<?= $token; ?>&country_id=<?= $zone_to_geo_zone['country_id']; ?>&zone_id=<?= $zone_to_geo_zone['zone_id']; ?>');
<?php $zone_to_geo_zone_row++; ?>
<?php } ?>
var zone_to_geo_zone_row=<?= $zone_to_geo_zone_row; ?>;
</script>
