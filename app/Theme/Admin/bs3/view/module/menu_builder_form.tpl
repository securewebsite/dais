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
			<div class="pull-left h2"><i class="hidden-xs fa fa-th-list"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
    <div class="panel-body">
		<form action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="name"><b class="required">*</b> <?= $lang_entry_name; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="name" value="<?= $name; ?>" id="name" class="form-control" required>
					<?php if ($error_name): ?>
					<div class="help-block error"><?= $error_name; ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="type"><b class="required">*</b> <?= $lang_entry_menu_type; ?></label>
				<div class="control-field col-sm-4">
					<select name="type" id="type" class="form-control" required>
						<option value="0"><?= $lang_text_select; ?></option>
						<?php foreach ($menu_types as $menu_type): ?>
						<?php if ($menu_type['type'] == $type): ?>
						<option value="<?= $menu_type['type']; ?>" selected="selected"><?= $menu_type['name']; ?></option>
						<?php else: ?>
						<option value="<?= $menu_type['type']; ?>"><?= $menu_type['name']; ?></option>
						<?php endif; ?>
						<?php endforeach; ?>
					</select>
					<?php if ($error_type): ?>
					<div class="help-block error"><?= $error_type; ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div id="result-panel"></div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_status; ?></label>
				<div class="col-sm-3">
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
		</form>
	</div>
</div>
<?= $footer; ?>