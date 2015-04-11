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
		<ul class="nav nav-tabs"><li><a href="#tab-general" data-toggle="tab"><?= $lang_tab_general; ?></a></li></ul>
		<div class="tab-content">
			<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<div class="form-group">
					<label class="control-label col-sm-2" for="name"><b class="required">*</b> <?= $lang_entry_name; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="name" value="<?= $name; ?>" class="form-control" id="name" class="form-control">
						<?php if ($error_name) { ?>
						<div class="help-block error"><?= $error_name; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_store; ?></label>
					<div class="control-field col-sm-4">
						<div class="panel panel-default panel-scrollable">
							<div class="list-group">
								<label class="list-group-item">
									<?php if (in_array(0, $manufacturer_store)) { ?>
									<input type="checkbox" name="manufacturer_store[]" value="0" checked=""><?= $lang_text_default; ?>
									<?php } else { ?>
									<input type="checkbox" name="manufacturer_store[]" value="0"><?= $lang_text_default; ?>
									<?php } ?>
								</label>
								<?php foreach ($stores as $store) { ?>
								<label class="list-group-item">
									<?php if (in_array($store['store_id'], $manufacturer_store)) { ?>
									<input type="checkbox" name="manufacturer_store[]" value="<?= $store['store_id']; ?>" checked=""><?= $store['name']; ?>
									<?php } else { ?>
									<input type="checkbox" name="manufacturer_store[]" value="<?= $store['store_id']; ?>"><?= $store['name']; ?>
									<?php } ?>
								</label>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><?= $lang_entry_image; ?></label>
					<div class="control-field col-sm-4">
						<div class="media">
							<a class="pull-left" onclick="image_upload('image','thumb');"><img class="img-thumbnail" src="<?= $thumb; ?>" width="100" height="100" alt="" id="thumb"></a>
							<input type="hidden" name="image" value="<?= $image; ?>" id="image">
							<div class="media-body hidden-xs">
								<a class="btn btn-default" onclick="image_upload('image','thumb');"><?= $lang_text_browse; ?></a>&nbsp;
								<a class="btn btn-default" onclick="$('#thumb').attr('src','<?= $no_image; ?>'); $('#image').val('');"><?= $lang_text_clear; ?></a>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="slug"><?= $lang_entry_slug; ?></label>
					<div class="control-field col-sm-4">
						<div class="input-group">
							<input type="text" name="slug" value="<?= $slug; ?>" class="form-control" id="slug" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default" id="man-slug-btn" type="button"><?= $lang_text_build; ?></button>
							</span>
						</div>
						<?php if ($error_slug): ?>
						<span class="help-block error"><?= $error_slug; ?></span>
						<?php endif; ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="sort_order"><?= $lang_entry_sort_order; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="sort_order" value="<?= $sort_order; ?>" id="sort_order" class="form-control">
					</div>
				</div>
			</form>
		</div>
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
<?= $footer; ?>