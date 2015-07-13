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
			<div class="pull-left h2"><i class="hidden-xs fa fa-download"></i><?= $lang_heading_title; ?></div>
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
					<div class="input-group">
						<input type="text" name="download_description[<?= $language['language_id']; ?>][name]" value="<?= isset($download_description[$language['language_id']]) ? $download_description[$language['language_id']]['name'] :''; ?>" class="form-control">
						<span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span>
					</div>
					<?php if (isset($error_name[$language['language_id']])) { ?>
					<div class="help-block error"><?= $error_name[$language['language_id']]; ?></div>
					<?php } ?>
				<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="input-filename"><?= $lang_entry_filename; ?></label>
				<div class="control-field col-sm-4">
					<div class="input-group">
						<input type="text" name="filename" value="<?= $filename; ?>" id="input-filename" class="form-control">
						<span class="input-group-btn">
							<button type="button" id="button-upload" class="btn btn-default"><i class="fa fa-upload"></i> <?= $lang_button_upload; ?></button>
						</span>
					</div>
					<?php if ($error_filename){ ?>
					<div class="help-block error"><?= $error_filename; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="mask"><?= $lang_entry_mask; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="mask" value="<?= $mask; ?>" id="mask" class="form-control">
					<?php if ($error_mask) { ?>
					<div class="help-block error"><?= $error_mask; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="remaining"><?= $lang_entry_remaining; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="remaining" value="<?= $remaining; ?>" id="remaining" class="form-control">
				</div>
			</div>
			<?php if ($download_id) { ?>
				<div class="form-group">
					<label class="control-label col-sm-2" for="update"><?= $lang_entry_update; ?></label>
					<div class="control-field col-sm-4">
						<label class="checkbox-inline"><?php if ($update) { ?>
							<input type="checkbox" name="update" value="1" checked="" id="update">
						<?php } else { ?>
							<input type="checkbox" name="update" value="1" id="update">
						<?php } ?>
						</label>
					</div>
				</div>
			<?php } ?>
		</form>
	</div>
</div>
<?= $footer; ?>