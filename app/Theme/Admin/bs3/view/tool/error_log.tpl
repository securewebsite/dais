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
		<div class="pull-left h2"><i class="hidden-xs fa fa-book"></i><?= $lang_heading_title; ?></div>
		<div class="pull-right"><a href="<?= $clear; ?>" class="btn btn-default"><?= $lang_button_clear; ?></a></div>
	</div>
	<div class="panel-body">
		<textarea wrap="off" class="form-control" rows="24"><?= $log; ?></textarea>
	</div>
</div>
<?= $footer; ?>