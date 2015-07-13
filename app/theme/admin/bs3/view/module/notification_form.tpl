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
			<div class="pull-left h2"><i class="hidden-xs fa fa-info-circle"></i><?= $lang_heading_title; ?></div>
			<div class="pull-right">
				<button type="submit" id="notification-submit" form="form" class="btn btn-primary">
				<i class="fa fa-floppy-o"></i><span class="hidden-xs"> <?= $lang_button_save; ?></span></button>
				<a class="btn btn-warning" href="<?= $cancel; ?>">
				<i class="fa fa-ban"></i><span class="hidden-xs"> <?= $lang_button_cancel; ?></span></a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		
		<form class="form-horizontal" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div id="language-tabs">
				<ul class="nav nav-tabs">
					<?php foreach ($languages as $language): ?>
						<li><a href="#language<?= $language['language_id']; ?>" data-toggle="tab">
							<i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i> <?= $language['name']; ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="tab-content">
					<?php foreach ($languages as $language): ?>
					<div class="tab-pane" id="language<?= $language['language_id']; ?>">
						<div class="form-group">
							<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_subject; ?></label>
							<div class="control-field col-sm-8">
								<input type="text" name="email_content[<?= $language['language_id']; ?>][subject]" value="<?= isset($email_content[$language['language_id']]) ? $email_content[$language['language_id']]['subject'] :''; ?>" class="form-control">
								<?php if (isset($error_subject[$language['language_id']])): ?>
								<span class="help-block error"><?= $error_subject[$language['language_id']]; ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_html; ?></label>
							<div class="control-field col-sm-8">
								<textarea id="html_<?= $language['language_id']; ?>" name="email_content[<?= $language['language_id']; ?>][html]" class="summernote form-control" rows="10" spellcheck="false"><?= isset($email_content[$language['language_id']]) ? $email_content[$language['language_id']]['html'] :''; ?></textarea>
								<?php if (isset($error_html[$language['language_id']])): ?>
								<span class="help-block error"><?= $error_html[$language['language_id']]; ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_text; ?></label>
							<div class="col-sm-6">
								<textarea name="email_content[<?= $language['language_id']; ?>][text]" class="form-control" rows="6"><?= isset($email_content[$language['language_id']]) ? $email_content[$language['language_id']]['text'] : ''; ?></textarea>
								<?php if (isset($error_text[$language['language_id']])): ?>
								<span class="help-block error"><?= $error_text[$language['language_id']]; ?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_recipient; ?></label>
				<div class="control-field col-sm-3">
					<select name="recipient" class="form-control">
						<option value="1" <?= $recipient == 1 ? 'selected' : ''; ?>><?= $lang_text_customer; ?></option>
						<option value="2" <?= $recipient == 2 ? 'selected' : ''; ?>><?= $lang_text_admin; ?></option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_priority; ?></label>
				<div class="control-field col-sm-3">
					<select name="priority" class="form-control">
						<option value="1" <?= $priority == 1 ? 'selected' : ''; ?>><?= $lang_text_send_now; ?></option>
						<option value="2" <?= $priority == 2 ? 'selected' : ''; ?>><?= $lang_text_send_queue; ?></option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_config; ?></label>
				<div class="col-sm-6">
					<?php if ($configurable): ?>
						<label class="radio-inline"><input type="radio" name="configurable" value="1" checked><?= $lang_text_yes; ?></label>
						<label class="radio-inline"><input type="radio" name="configurable" value="0"><?= $lang_text_no; ?></label>
						<?php else: ?>
						<label class="radio-inline"><input type="radio" name="configurable" value="1"><?= $lang_text_yes; ?></label>
						<label class="radio-inline"><input type="radio" name="configurable" value="0" checked><?= $lang_text_no; ?></label>
						<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"><?= $lang_entry_config_description; ?></label>
				<div class="control-field col-sm-6">
					<textarea name="config_description" class="form-control" rows="6" spellcheck="false"><?= isset($config_description) ? $config_description : ''; ?></textarea>
					<?php if ($error_description): ?>
					<span class="help-block error"><?= $error_description; ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="email_slug"><b class="required">*</b> <?= $lang_entry_email_slug; ?></label>
				<div class="control-field col-sm-4">
					<?php if ($is_system): ?>
					<p class="form-control-static"><?= $email_slug; ?></p>
					<input type="hidden" name="email_slug" value="<?= $email_slug; ?>">
					<input type="hidden" name="is_system" value="1">
					<?php else: ?>
					<input type="text" name="email_slug" value="<?= $email_slug; ?>" class="form-control">
					<input type="hidden" name="is_system" value="0">
					<?php endif; ?>
					<?php if ($error_email_slug): ?>
					<span class="help-block error"><?= $error_email_slug; ?></span>
					<?php endif; ?>
				</div>
			</div>
		</form>
	</div>
</div>
<?= $footer; ?>