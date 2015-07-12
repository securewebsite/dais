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
		<div class="h2"><i class="fa fa-hdd-o"></i><?= $lang_heading_title; ?></div>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?= $restore; ?>" method="post" enctype="multipart/form-data" id="restore">
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_restore; ?></label>
				<div class="control-field col-sm-4">
					<p class="form-control-static"><input type="file" name="import"></p>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6 col-sm-offset-2">
					<button type="submit" class="btn btn-primary"><i class="fa fa-hdd-o"></i> <?= $lang_button_restore; ?></button>
				</div>
			</div>
		</form>
		<hr>
		<form class="form-horizontal" action="<?= $backup; ?>" method="post" enctype="multipart/form-data" role="form">
			<div class="form-group">
				<label class="control-label col-sm-2"><p><?= $lang_entry_backup; ?></p>
					<div class="btn-group-vertical">
						<a class="btn btn-default btn-sm" onclick="$('input[name*=\'backup\']').prop('checked',true);"><?= $lang_text_select_all; ?></a>
						<a class="btn btn-default btn-sm" onclick="$('input[name*=\'backup\']').prop('checked',false);"><?= $lang_text_unselect_all; ?></a>
					</div>
				</label>
				<div class="col-sm-4">
					<div class="panel panel-default panel-scrollable">
						<div class="list-group list-group-hover">
							<?php foreach ($tables as $table) { ?>
							<label class="list-group-item">
							<input type="checkbox" name="backup[]" value="<?= $table; ?>" checked>
							<?= $table; ?></label>
							<?php } ?>
						</div>
					</div>
					<button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> <?= $lang_button_backup; ?></button>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>