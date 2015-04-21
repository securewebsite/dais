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
			<div class="pull-left h2"><i class="hidden-xs fa fa-user"></i><?= $lang_heading_title; ?></div>
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
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_presenter_name; ?></label>
					<div class="control-field col-sm-4">
						<input type="text" name="presenter_name" value="<?= $presenter_name; ?>" class="form-control" id="name" class="form-control">
						<?php if ($error_presenter_name) { ?>
						<div class="help-block error"><?= $error_presenter_name; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_bio; ?></label>
					<div class="control-field col-sm-8">
						<textarea name="bio" class="form-control summernote"><?= $bio; ?></textarea>
						<?php if ($error_bio) { ?>
						<span class="help-block error"><?= $error_bio; ?></span>
						<?php } ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?= $footer; ?>