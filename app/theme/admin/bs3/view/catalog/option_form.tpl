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
			<div class="pull-left h2"><i class="hidden-xs fa fa-cogs"></i><?= $lang_heading_title; ?></div>
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
					<?php foreach ($languages as $language) { ?>
						<div class="input-group"><input type="text" name="option_description[<?= $language['language_id']; ?>][name]" value="<?= isset($option_description[$language['language_id']]) ? $option_description[$language['language_id']]['name'] :''; ?>" class="form-control">
						<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
						<?php if (isset($error_name[$language['language_id']])) { ?>
						<div class="help-block error"><?= $error_name[$language['language_id']]; ?></div>
						<?php } ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_type; ?></label>
				<div class="control-field col-sm-4">
					<select name="type" class="form-control">
						<optgroup label="<?= $lang_text_choose; ?>">
							<option value="select"<?= ($type == 'select') ? ' selected' : ''; ?>><?= $lang_text_select; ?></option>
							<option value="radio"<?= ($type == 'radio') ? ' selected' : ''; ?>><?= $lang_text_radio; ?></option>
							<option value="checkbox"<?= ($type == 'checkbox') ? ' selected' : ''; ?>><?= $lang_text_checkbox; ?></option>
							<option value="image"<?= ($type == 'image') ? ' selected' : ''; ?>><?= $lang_text_image; ?></option>
						</optgroup>
						<optgroup label="<?= $lang_text_input; ?>">
							<option value="text"<?= ($type == 'text') ? ' selected' : ''; ?>><?= $lang_text_text; ?></option>
							<option value="textarea"<?= ($type == 'textarea') ? ' selected' : ''; ?>><?= $lang_text_textarea; ?></option>
						</optgroup>
						<optgroup label="<?= $lang_text_file; ?>">
							<option value="file"<?= ($type == 'file') ? ' selected' : ''; ?>><?= $lang_text_file; ?></option>
						</optgroup>
						<optgroup label="<?= $lang_text_date; ?>">
							<option value="date"<?= ($type == 'date') ? ' selected' : ''; ?>><?= $lang_text_date; ?></option>
							<option value="time"<?= ($type == 'time') ? ' selected' : ''; ?>><?= $lang_text_time; ?></option>
							<option value="datetime"<?= ($type == 'datetime') ? ' selected' : ''; ?>><?= $lang_text_datetime; ?></option>
						</optgroup>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_sort_order; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="sort_order" value="<?= $sort_order; ?>" class="form-control">
				</div>
			</div>
			<table id="option-value" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="col-sm-6"><b class="required">*</b> <?= $lang_entry_option_value; ?></th>
						<th><?= $lang_entry_image; ?></th>
						<th class="text-right"><?= $lang_entry_sort_order; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php $option_value_row = 0; ?>
				<?php foreach ($option_values as $option_value) { ?>
					<tr id="option-value-row<?= $option_value_row; ?>">
						<td><input type="hidden" name="option_value[<?= $option_value_row; ?>][option_value_id]" value="<?= $option_value['option_value_id']; ?>">
							<?php foreach ($languages as $language) { ?>
							<div class="input-group"><input type="text" name="option_value[<?= $option_value_row; ?>][option_value_description][<?= $language['language_id']; ?>][name]" value="<?= isset($option_value['option_value_description'][$language['language_id']]) ? $option_value['option_value_description'][$language['language_id']]['name'] :''; ?>" class="form-control">
							<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
							<?php if (isset($error_option_value[$option_value_row][$language['language_id']])) { ?>
							<span class="text-danger"><?= $error_option_value[$option_value_row][$language['language_id']]; ?></span>
							<?php } ?></div>
							<?php } ?></td>
						<td><div class="media">
							<a class="pull-left" onclick="image_upload('image<?= $option_value_row; ?>','thumb<?= $option_value_row; ?>');"><img class="img-thumbnail" src="<?= $option_value['thumb']; ?>" width="100" height="100" alt="" id="thumb<?= $option_value_row; ?>"></a>
							<input type="hidden" name="option_value[<?= $option_value_row; ?>][image]" value="<?= $option_value['image']; ?>" id="image<?= $option_value_row; ?>">
							<div class="media-body hidden-xs">
								<a class="btn btn-default" onclick="image_upload('image<?= $option_value_row; ?>','thumb<?= $option_value_row; ?>');"><?= $lang_text_browse; ?></a>
								<a class="btn btn-default" onclick="$('#thumb<?= $option_value_row; ?>').attr('src', '<?= $no_image; ?>'); $('#image<?= $option_value_row; ?>').val('');"><?= $lang_text_clear; ?></a>
							</div>
						</div></td>
						<td class="text-right"><input type="text" name="option_value[<?= $option_value_row; ?>][sort_order]" value="<?= $option_value['sort_order']; ?>" class="form-control"></td>
						<td><a onclick="$('#option-value-row<?= $option_value_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
					</tr>
				<?php $option_value_row++; ?>
				<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"></td>
						<td><a onclick="addOptionValue();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_option_value; ?></span></a></td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?= $lang_text_image_manager; ?></h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning btn-block" data-dismiss="modal"><?= $lang_button_cancel; ?></button>
			</div>
		</div>
	</div>
</div>
<script>var option_value_row = <?= $option_value_row; ?>;</script>
<?= $footer; ?>