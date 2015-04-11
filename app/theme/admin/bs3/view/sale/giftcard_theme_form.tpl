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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_name; ?></label>
				<div class="control-field col-sm-4">
					<?php foreach ($languages as $language) { ?>
						<div class="input-group"><input type="text" name="giftcard_theme_description[<?= $language['language_id']; ?>][name]" value="<?= isset($giftcard_theme_description[$language['language_id']]) ? $giftcard_theme_description[$language['language_id']]['name'] :''; ?>" class="form-control">
						<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
						<?php if (isset($error_name[$language['language_id']])) { ?>
						<div class="help-block error"><?= $error_name[$language['language_id']]; ?></div>
						<?php } ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_image; ?></label>
				<div class="control-field col-sm-4">
					<div class="media">
						<a class="pull-left" onclick="image_upload('image','thumb');"><img class="img-thumbnail" src="<?= $thumb; ?>" width="100" height="100" alt="" id="thumb"></a>
						<input type="hidden" name="image" value="<?= $image; ?>" id="image">
						<div class="media-body hidden-xs">
							<a class="btn btn-default" onclick="image_upload('image','thumb');"><?= $lang_text_browse; ?></a>
							<a class="btn btn-default" onclick="$('#thumb').attr('src','<?= $no_image; ?>'); $('#image').val('');"><?= $lang_text_clear; ?></a>
							<?php if ($error_image) { ?>
								<div class="help-block error"><?= $error_image; ?></div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="well"><button type="submit" form="form" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?= $lang_button_save; ?></button>&nbsp;<a class="btn btn-warning" href="<?= $cancel; ?>"><i class="fa fa-ban"></i> <?= $lang_button_cancel; ?></a></div>
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
<?= $footer; ?>