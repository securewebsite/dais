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
			<div class="pull-left h2"><i class="hidden-xs fa fa-picture-o"></i><?= $lang_heading_title; ?></div>
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
				<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="status" class="form-control">
						<?php if ($status) { ?>
						<option value="1" selected><?= $lang_text_enabled; ?></option>
						<option value="0"><?= $lang_text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?= $lang_text_enabled; ?></option>
						<option value="0" selected><?= $lang_text_disabled; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<table id="images" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="col-sm-4"><?= $lang_entry_title; ?></th>
						<th><?= $lang_entry_link; ?></th>
						<th><?= $lang_entry_image; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php $image_row = 0; ?>
				<?php foreach ($banner_images as $banner_image) { ?>
					<tr id="image-row<?= $image_row; ?>">
						<td><?php foreach ($languages as $language) { ?>
							<div class="input-group"><input type="text" name="banner_image[<?= $image_row; ?>][banner_image_description][<?= $language['language_id']; ?>][title]" value="<?= isset($banner_image['banner_image_description'][$language['language_id']]) ? $banner_image['banner_image_description'][$language['language_id']]['title'] :''; ?>" class="form-control">
							<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
							<?php if (isset($error_banner_image[$image_row][$language['language_id']])) { ?>
							<span class="text-danger"><?= $error_banner_image[$image_row][$language['language_id']]; ?></span>
							<?php } ?></div>
							<?php } ?></td>
						<td><input type="text" name="banner_image[<?= $image_row; ?>][link]" value="<?= $banner_image['link']; ?>" class="form-control"></td>
						<td><div class="media">
							<a class="pull-left" onclick="image_upload('image<?= $image_row; ?>','thumb<?= $image_row; ?>');"><img class="img-thumbnail" src="<?= $banner_image['thumb']; ?>" width="100" height="100" alt="" id="thumb<?= $image_row; ?>"></a>
							<input type="hidden" name="banner_image[<?= $image_row; ?>][image]" value="<?= $banner_image['image']; ?>" id="image<?= $image_row; ?>">
							<div class="media-body hidden-xs">
								<a class="btn btn-default" onclick="image_upload('image<?= $image_row; ?>','thumb<?= $image_row; ?>');"><?= $lang_text_browse; ?></a>
								<a class="btn btn-default" onclick="$('#thumb<?= $image_row; ?>').attr('src', '<?= $no_image; ?>'); $('#image<?= $image_row; ?>').val('');"><?= $lang_text_clear; ?></a>
							</div>
						</div></td>
						<td><a onclick="$('#image-row<?= $image_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>
					</tr>
				<?php $image_row++; ?>
				<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"></td>
						<td><a onclick="addImage();" class="btn btn-info"><i class="fa fa-plus-circle"></i><span class="hidden-xs"> <?= $lang_button_add_banner; ?></span></a></td>
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
<script>var image_row=<?= $image_row; ?>;</script>
<?= $footer; ?>