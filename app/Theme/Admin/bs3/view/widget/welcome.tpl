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
			<div class="pull-left h2"><i class="hidden-xs fa fa-puzzle-piece"></i><?= $lang_heading_title; ?></div>
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
			<ul id="tabs" class="nav nav-tabs">
				<?php $widget_row = 1; ?>
				<?php foreach ($widgets as $widget) { ?>
				<li><a href="#tab-widget-<?= $widget_row; ?>" data-toggle="tab" id="widget-<?= $widget_row; ?>"><span class="label label-danger" onclick="removeWidget('<?= $widget_row; ?>');"><i class="fa fa-trash-o fa-lg"></i></span>&nbsp;&nbsp;<?= $lang_tab_widget . ' ' . $widget_row; ?></a></li>
				<?php $widget_row++; ?>
				<?php } ?>
				<li id="widget-add" class="active"><a onclick="addWidget();"><i class="fa fa-plus-circle fa-lg fa-fw"></i>&nbsp;<?= $lang_button_add_widget; ?></a></li>
			</ul>
			<div class="tab-content" id="append">
				<?php $widget_row = 1; ?>
				<?php foreach ($widgets as $widget) { ?>
				<div class="tab-pane" id="tab-widget-<?= $widget_row; ?>">
					<ul class="nav nav-tabs" id="language-<?= $widget_row; ?>">
						<?php foreach ($languages as $language) { ?>
							<li><a href="#tab-language-<?= $widget_row; ?>-<?= $language['language_id']; ?>" data-toggle="tab"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i> <?= $language['name']; ?></a></li>
						<?php } ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($languages as $language) { ?>
						<div class="tab-pane" id="tab-language-<?= $widget_row; ?>-<?= $language['language_id']; ?>">
							<div class="form-group">
								<label class="control-label col-sm-2"><?= $lang_entry_description; ?></label>
								<div class="control-field col-sm-8">
									<textarea name="welcome_widget[<?= $widget_row; ?>][description][<?= $language['language_id']; ?>]" class="summernote form-control" rows="10" spellcheck="false"><?= isset($widget['description'][$language['language_id']]) ? $widget['description'][$language['language_id']] :''; ?></textarea>
								</div>
							</div>
						</div>
						<?php } ?>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_layout; ?></label>
							<div class="control-field col-sm-4">
								<select name="welcome_widget[<?= $widget_row; ?>][layout_id]" class="form-control">
									<?php foreach ($layouts as $layout) { ?>
									<?php if ($layout['layout_id'] == $widget['layout_id']) { ?>
									<option value="<?= $layout['layout_id']; ?>" selected><?= $layout['name']; ?></option>
									<?php } else { ?>
									<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_position; ?></label>
							<div class="control-field col-sm-4">
								<select name="welcome_widget[<?= $widget_row; ?>][position]" class="form-control">
									<?php if ($widget['position'] == 'content_top'): ?>
									<option value="content_top" selected><?= $lang_text_content_top; ?></option>
									<?php else: ?>
									<option value="content_top"><?= $lang_text_content_top; ?></option>
									<?php endif; ?>
									<?php if ($widget['position'] == 'content_bottom'): ?>
									<option value="content_bottom" selected><?= $lang_text_content_bottom; ?></option>
									<?php else: ?>
									<option value="content_bottom"><?= $lang_text_content_bottom; ?></option>
									<?php endif; ?>
									<?php if ($widget['position'] == 'post_header'): ?>
									<option value="post_header" selected><?= $lang_text_post_header; ?></option>
									<?php else: ?>
									<option value="post_header"><?= $lang_text_post_header; ?></option>
									<?php endif; ?>
									<?php if ($widget['position'] == 'pre_footer'): ?>
									<option value="pre_footer" selected><?= $lang_text_pre_footer; ?></option>
									<?php else: ?>
									<option value="pre_footer"><?= $lang_text_pre_footer; ?></option>
									<?php endif; ?>
									<?php if ($widget['position'] == 'column_left'): ?>
									<option value="column_left" selected><?= $lang_text_column_left; ?></option>
									<?php else: ?>
									<option value="column_left"><?= $lang_text_column_left; ?></option>
									<?php endif; ?>
									<?php if ($widget['position'] == 'column_right'): ?>
									<option value="column_right" selected><?= $lang_text_column_right; ?></option>
									<?php else: ?>
									<option value="column_right"><?= $lang_text_column_right; ?></option>
									<?php endif; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>
							<div class="control-field col-sm-4">
								<div class="btn-group" data-toggle="buttons">
									<?php if ($widget['status']){ ?>
									<label class="btn btn-default active" title="<?= $lang_text_enabled; ?>"><input type="radio" name="welcome_widget[<?= $widget_row; ?>][status]" value="1" checked=""><i class="fa fa-play"></i></label>
									<label class="btn btn-default" title="<?= $lang_text_disabled; ?>"><input type="radio" name="welcome_widget[<?= $widget_row; ?>][status]" value="0"><i class="fa fa-pause"></i></label>
									<?php } else { ?>
									<label class="btn btn-default" title="<?= $lang_text_enabled; ?>"><input type="radio" name="welcome_widget[<?= $widget_row; ?>][status]" value="1"><i class="fa fa-play"></i></label>
									<label class="btn btn-default active" title="<?= $lang_text_disabled; ?>"><input type="radio" name="welcome_widget[<?= $widget_row; ?>][status]" value="0" checked=""><i class="fa fa-pause"></i></label>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2"><?= $lang_entry_sort_order; ?></label>
							<div class="control-field col-sm-4">
								<input type="text" name="welcome_widget[<?= $widget_row; ?>][sort_order]" value="<?= $widget['sort_order']; ?>" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<?php $widget_row++; ?>
				<?php } ?>
			</div>
		</form>
	</div>
</div>
<script>var widget_row=<?= $widget_row; ?>;</script>
<?= $footer; ?>