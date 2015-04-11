<script>
function addWidget(){	
	html = '<div id="tab-widget-'+widget_row+'" class="tab-pane">';
	html += '<ul class="nav nav-tabs" id="language-'+widget_row+'">';
	<?php foreach ($languages as $language) { ?>
	html += '<li><a href="#tab-language-'+widget_row+'-<?= $language['language_id']; ?>" data-toggle="tab"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i> <?= $language['name']; ?></a></li>';
	<?php } ?>
	html += '</ul>';
	html += '<div class="tab-content">';
	<?php foreach ($languages as $language) { ?>
	html += '<div class="tab-pane" id="tab-language-'+widget_row+'-<?= $language['language_id']; ?>">';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><?= $lang_entry_description; ?></label>';
	html += '<div class="control-field col-sm-8">';
	html += '<textarea name="welcome_widget['+widget_row+'][description][<?= $language['language_id']; ?>]" class="summernote form-control" rows="10" id="description-'+widget_row+'-<?= $language['language_id']; ?>" spellcheck="false"></textarea>';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	<?php } ?>
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><?= $lang_entry_layout; ?></label>';
	html += '<div class="control-field col-sm-4">';
	html += '<select name="welcome_widget['+widget_row+'][layout_id]" class="form-control">';
	<?php foreach ($layouts as $layout) { ?>
	html += '<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>';
	<?php } ?>
	html += '</select>';
	html += '</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><?= $lang_entry_position; ?></label>';
	html += '<div class="control-field col-sm-4">';
	html += '<select name="welcome_widget['+widget_row+'][position]" class="form-control">';
	html += '<option value="content_top"><?= $lang_text_content_top; ?></option>';
	html += '<option value="content_bottom"><?= $lang_text_content_bottom; ?></option>';
	html += '<option value="post_header"><?= $lang_text_post_header; ?></option>';
	html += '<option value="pre_footer"><?= $lang_text_pre_footer; ?></option>';
	html += '<option value="column_left"><?= $lang_text_column_left; ?></option>';
	html += '<option value="column_right"><?= $lang_text_column_right; ?></option>';
	html += '</select>';
	html += '</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><?= $lang_entry_status; ?></label>';
	html += '<div class="control-field col-sm-4">';
	html += '<div class="btn-group" data-toggle="buttons">';
	html += '<label class="btn btn-default active" title="<?= $lang_text_enabled; ?>"><input type="radio" name="welcome_widget['+widget_row+'][status]" value="1" checked=""><i class="fa fa-play"></i></label>';
	html += '<label class="btn btn-default" title="<?= $lang_text_disabled; ?>"><input type="radio" name="welcome_widget['+widget_row+'][status]" value="0"><i class="fa fa-pause"></i></label>';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><?= $lang_entry_sort_order; ?></label>';
	html += '<div class="control-field col-sm-4">';
	html += '<input type="text" name="welcome_widget['+widget_row+'][sort_order]" value="" class="form-control">';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	
	$('#append').append(html);

	<?php foreach ($languages as $language) { ?>
	CKEDITOR.replace('description-'+widget_row+'-<?= $language['language_id']; ?>');
	<?php } ?>

	$('#language-'+widget_row).find('a:first').click();

	$('#widget-add').before('<li><a href="#tab-widget-'+widget_row+'" id="widget-'+widget_row+'" data-toggle="tab"><span class="label label-danger" onclick="removeWidget('+widget_row+');"><i class="fa fa-trash-o fa-lg"></i></span>&nbsp;&nbsp;<?= $lang_tab_widget; ?> '+widget_row+'</a></li>');
	
	$('#widget-'+widget_row).click();
	
	widget_row++;
}
function removeWidget(widget_row){
	$('#widget-'+widget_row).remove();
	$('#tab-widget-'+widget_row).remove();
	$('#tabs a:first').trigger('click');
	return false;
}
<?php if (!$widgets) { ?>
addWidget();
<?php } ?>
</script>