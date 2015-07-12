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
				<label class="control-label col-sm-2"><p><?= $lang_entry_access; ?></p>
					<div class="btn-group-vertical">
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'permission[access]\']').prop('checked',true);"><?= $lang_text_select_all; ?></a>
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'permission[access]\']').prop('checked',false);"><?= $lang_text_unselect_all; ?></a>
					</div>
				</label>
				<div class="control-field col-sm-4">
					<div class="panel panel-default panel-scrollable">
						<div class="list-group list-group-hover">
						<?php foreach ($permissions as $permission) { ?>
						<label class="list-group-item">
							<?php if (in_array($permission, $access)) { ?>
							<input type="checkbox" name="permission[access][]" value="<?= $permission; ?>" checked=""><?= $permission; ?>
							<?php } else { ?>
							<input type="checkbox" name="permission[access][]" value="<?= $permission; ?>"><?= $permission; ?>
							<?php } ?>
						</label>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><p><?= $lang_entry_modify; ?></p>
					<div class="btn-group-vertical">
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'permission[modify]\']').prop('checked',true);"><?= $lang_text_select_all; ?></a>
						<a class="btn btn-default btn-sm" onclick="$('[name*=\'permission[modify]\']').prop('checked',false);"><?= $lang_text_unselect_all; ?></a>
					</div>
				</label>
				<div class="control-field col-sm-4">
					<div class="panel panel-default panel-scrollable">
						<div class="list-group list-group-hover">
							<?php foreach ($permissions as $permission) { ?>
							<label class="list-group-item">
								<?php if (in_array($permission, $modify)) { ?>
								<input type="checkbox" name="permission[modify][]" value="<?= $permission; ?>" checked=""><?= $permission; ?>
								<?php } else { ?>
								<input type="checkbox" name="permission[modify][]" value="<?= $permission; ?>"><?= $permission; ?>
								<?php } ?>
							</label>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?> 