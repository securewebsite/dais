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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_user_name; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="user_name" value="<?= $user_name; ?>" class="form-control" autofocus>
					<?php if ($error_user_name) { ?>
						<div class="help-block error"><?= $error_user_name; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="firstname" value="<?= $firstname; ?>" class="form-control">
					<?php if ($error_firstname) { ?>
						<div class="help-block error"><?= $error_firstname; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="lastname" value="<?= $lastname; ?>" class="form-control">
					<?php if ($error_lastname) { ?>
						<div class="help-block error"><?= $error_lastname; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_email; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="email" value="<?= $email; ?>" class="form-control">
					<?php if ($error_email) { ?>
						<div class="help-block error"><?= $error_email; ?></div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_user_group; ?></label>
				<div class="control-field col-sm-4">
					<select name="user_group_id" class="form-control">
						<?php foreach ($user_groups as $user_group) { ?>
						<?php if ($user_group['user_group_id'] == $user_group_id) { ?>
						<option value="<?= $user_group['user_group_id']; ?>" selected><?= $user_group['name']; ?></option>
						<?php } else { ?>
						<option value="<?= $user_group['user_group_id']; ?>"><?= $user_group['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_password; ?></label>
				<div class="control-field col-sm-4">
					<input type="password" name="password" value="<?= $password; ?>" class="form-control">
					<?php if ($error_password) { ?>
						<div class="help-block error"><?= $error_password; ?></div>
						<?php	} ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_confirm; ?></label>
				<div class="control-field col-sm-4">
					<input type="password" name="confirm" value="<?= $confirm; ?>" class="form-control">
					<?php if ($error_confirm) { ?>
						<div class="help-block error"><?= $error_confirm; ?></div>
						<?php	} ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="status" class="form-control">
						<?php if ($status) { ?>
						<option value="0"><?= $lang_text_disabled; ?></option>
						<option value="1" selected><?= $lang_text_enabled; ?></option>
						<?php } else { ?>
						<option value="0" selected><?= $lang_text_disabled; ?></option>
						<option value="1"><?= $lang_text_enabled; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?> 