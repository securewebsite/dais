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
			<div class="pull-left h2"><i class="hidden-xs fa fa-git-square"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form-git-settings" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
    <div class="panel-body">
		<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form-git-settings" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-git-provider"><b class="required">*</b> <?= $lang_entry_git_provider; ?></label>
			<div class="control-field col-sm-4">
				<select name="git_provider" id="input-git-provider" class="form-control" required>
					<option value="0"><?= $lang_text_select; ?></option>
					<?php foreach ($git_providers as $provider): ?>
					<?php if ($provider['id'] == $git_provider): ?>
					<option value="<?= $provider['id']; ?>" selected="selected"><?= $provider['name']; ?></option>
					<?php else: ?>
					<option value="<?= $provider['id']; ?>"><?= $provider['name']; ?></option>
					<?php endif; ?>
					<?php endforeach; ?>
				</select>
				<span class="help-block"><?= $lang_help_git_provider; ?></span>
				<?php if ($error_git_provider): ?>
				<div class="text-danger"><?= $error_git_provider; ?></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-git-url"><b class="required">*</b> <?= $lang_entry_git_url; ?></label>
			<div class="control-field col-sm-4">
				<input type="text" name="git_url" value="<?= $git_url; ?>" placeholder="<?= $lang_entry_git_url; ?>" id="input-git-url" class="form-control" required>
				<span class="help-block"><?= $lang_help_git_url; ?></span>
				<?php if ($error_git_url): ?>
				<div class="text-danger"><?= $error_git_url; ?></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-git-branch"><b class="required">*</b> <?= $lang_entry_git_branch; ?></label>
			<div class="control-field col-sm-4">
				<select id="input-git-branch" class="form-control" required>
					<option value="0"><?= $lang_text_select; ?></option>
					<?php foreach ($git_branches as $branch): ?>
					<?php if ($branch['name'] == $git_branch): ?>
					<option value="<?= $branch['name']; ?>" selected="selected"><?= $branch['name']; ?></option>
					<?php else: ?>
					<option value="<?= $branch['name']; ?>"><?= $branch['name']; ?></option>
					<?php endif; ?>
					<?php endforeach; ?>
				</select><br>
				<input type="text" name="git_branch" value="<?= $git_branch; ?>" placeholder="<?= $lang_entry_git_branch; ?>" id="git-branch" class="form-control" required>
				<span class="help-block"><?= $lang_help_git_branch; ?></span>
				<?php if ($error_git_branch): ?>
				<div class="text-danger"><?= $error_git_branch; ?></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?= $lang_entry_git_status; ?></label>
			<div class="col-sm-10">
				<label class="radio-inline">
					<?php if ($git_status): ?>
					<input type="radio" name="git_status" value="1" checked="checked" />
					<?= $lang_text_enabled; ?>
					<?php else: ?>
					<input type="radio" name="git_status" value="1" />
					<?= $lang_text_enabled; ?>
					<?php endif; ?>
				</label>
				<label class="radio-inline">
					<?php if (!$git_status): ?>
					<input type="radio" name="git_status" value="0" checked="checked" />
					<?= $lang_text_disabled; ?>
					<?php else: ?>
					<input type="radio" name="git_status" value="0" />
					<?= $lang_text_disabled; ?>
					<?php endif; ?>
				</label>
			</div>
		</div>
		</form>
	</div>
</div>
<?= $footer; ?>