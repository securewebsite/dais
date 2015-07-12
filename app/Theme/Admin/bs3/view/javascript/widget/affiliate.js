<script>
function addWidget(){	
	html = '<tr id="widget-row'+widget_row+'">';
	html += '<td><select name="affiliate_widget['+widget_row+'][layout_id]" class="form-control">';
	<?php foreach ($layouts as $layout) { ?>
	html += '<option value="<?= $layout['layout_id']; ?>"><?= addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '<td><select name="affiliate_widget['+widget_row+'][position]" class="form-control">';
	html += '<option value="content_top"><?= $lang_text_content_top; ?></option>';
	html += '<option value="content_bottom"><?= $lang_text_content_bottom; ?></option>';
	html += '<option value="post_header"><?= $lang_text_post_header; ?></option>';
	html += '<option value="pre_footer"><?= $lang_text_pre_footer; ?></option>';
	html += '<option value="column_left"><?= $lang_text_column_left; ?></option>';
	html += '<option value="column_right"><?= $lang_text_column_right; ?></option>';
	html += '</select></td>';
	html += '<td><div class="btn-group" data-toggle="buttons">';
	html += '<label class="btn btn-default active" title="<?= $lang_text_enabled; ?>"><input type="radio" name="affiliate_widget['+widget_row+'][status]" value="1" checked=""><i class="fa fa-play"></i></label>';
	html += '<label class="btn btn-default" title="<?= $lang_text_disabled; ?>"><input type="radio" name="affiliate_widget['+widget_row+'][status]" value="0"><i class="fa fa-pause"></i></label>';
	html += '</div></td>';
	html += '<td class="text-right"><input type="text" name="affiliate_widget['+widget_row+'][sort_order]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#widget-row'+widget_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#widget tbody').append(html);
	
	widget_row++;
}
</script>