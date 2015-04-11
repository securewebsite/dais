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
			<div class="pull-left h2"><i class="hidden-xs fa fa-leaf"></i><?= $lang_heading_title; ?></div>
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
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_author; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="author" value="<?= $author; ?>" class="form-control">
					<?php if ($error_author): ?>
					<span class="help-block error"><?= $error_author; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_post; ?></label>
				<div class="control-field col-sm-4">
					<input type="text" name="post" value="<?= $post; ?>" class="form-control" data-target="name" autocomplete="off">
					<input type="hidden" name="post_id" value="<?= $post_id; ?>">
					<?php if ($error_post): ?>
					<span class="help-block error"><?= $error_post; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_text; ?></label>
				<div class="control-field col-sm-8">
					<textarea name="text" class="form-control summernote" rows="6"><?= $text; ?></textarea>
					<?php if ($error_text): ?>
					<span class="help-block error"><?= $error_text; ?></span>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_rating; ?></label>
				<div class="control-field col-sm-4">
					<label class="label label-danger" style="margin-right: 10px;"><?= $lang_entry_bad; ?></label>
					<?php for ($i = 1; $i < 6; $i++): ?>
						<label class="radio-inline" style="margin-bottom:12px;">
							<?php if ($rating == $i): ?>
							<input type="radio" name="rating" value="<?= $i; ?>" checked>
							<?php else: ?>
							<input type="radio" name="rating" value="<?= $i; ?>">
							<?php endif; ?>
						</label>
					<?php endfor; ?>
					<label class="label label-success"><?= $lang_entry_good; ?></label>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
				<div class="control-field col-sm-4">
					<select name="status" class="form-control">
						<?php if ($status): ?>
						<option value="1" selected="selected"><?= $lang_text_enabled; ?></option>
						<option value="0"><?= $lang_text_disabled; ?></option>
						<?php else: ?>
						<option value="1"><?= $lang_text_enabled; ?></option>
						<option value="0" selected="selected"><?= $lang_text_disabled; ?></option>
						<?php endif; ?>
					</select>
				</div>
			</div>
		</form>
	</div>
</div>

<?= $footer; ?>