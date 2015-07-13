<script>
$(document).on('click', '.toggle', function(){
	var obj = $(this).parent().prev();
	
	if ($(this).is(':checked')){
      $(obj).attr('disabled',true).val('');
	} else {
      $(obj).attr('disabled',false).select();
	}
});

function addWidget() {
	html = '<tr id="widget-row'+widget_row+'">';
	html += '<td><input type="text" class="form-control" name="post_wall_widget['+widget_row+'][limit]" value="" size="1"></td>';
	html += '<td><select name="post_wall_widget['+widget_row+'][span]" class="form-control">';
	<?php foreach (array(1,2,3,4,6) as $span): ?>
	html += '<option value="<?= $span; ?>"><?= $span; ?></option>';
	<?php endforeach; ?>
	html += '</select></td>';
	html += '<td><input type="text" name="post_wall_widget['+widget_row+'][height]" value="" class="form-control" size="1">';
	html += '&nbsp; <label class="checkbox"><input type="checkbox" class="toggle" name="post_wall_widget['+widget_row+'][height]" value=""> <?= $lang_text_auto; ?></label></td>';
	html += '<td><select name="post_wall_widget['+widget_row+'][post_type]" class="form-control">';
	<?php foreach ($post_types as $key => $post_type): ?>
	html += '<option value="<?= $key; ?>"><?= $post_type; ?></option>';
	<?php endforeach; ?>
	html += '</select></td>';
	html += '<td><select name="post_wall_widget['+widget_row+'][description]" class="form-control">';
	html += '<option value="1"><?= $lang_text_enabled; ?></option>';
	html += '<option value="0" selected=""><?= $lang_text_disabled; ?></option>';
	html += '</select></td>';
	html += '<td><select name="post_wall_widget['+widget_row+'][button]" class="form-control">';
	html += '<option value="1"><?= $lang_text_enabled; ?></option>';
	html += '<option value="0" selected=""><?= $lang_text_disabled; ?></option>';
	html += '</select></td>';
	html += '<td><select name="post_wall_widget['+widget_row+'][layout_id]" class="form-control">';
	<?php foreach ($layouts as $layout): ?>
	html += '<option value="<?= $layout['layout_id']; ?>"><?= $layout['name']; ?></option>';
	<?php endforeach; ?>
	html += '</select></td>';
	html += '<td><select name="post_wall_widget['+widget_row+'][position]" class="form-control">';
	html += '<option value="content_top"><?= $lang_text_content_top; ?></option>';
	html += '<option value="content_bottom"><?= $lang_text_content_bottom; ?></option>';
	html += '<option value="post_header"><?= $lang_text_post_header; ?></option>';
	html += '<option value="pre_footer"><?= $lang_text_pre_footer; ?></option>';
	html += '<option value="column_left"><?= $lang_text_column_left; ?></option>';
	html += '<option value="column_right"><?= $lang_text_column_right; ?></option>';
	html += '</select></td>';
	html += '<td><div class="btn-group" data-toggle="buttons"><label class="btn btn-default" title="<?= $lang_text_enabled; ?>">';
	html += '<input type="radio" name="post_wall_widget['+widget_row+'][status]" value="1"><i class="fa fa-play"></i></label>';
	html += '<label class="btn btn-default active" title="<?= $lang_text_disabled; ?>">';
	html += '<input type="radio" name="post_wall_widget['+widget_row+'][status]" value="0" checked=""><i class="fa fa-pause"></i></label></div></td>';
	html += '<td class="text-right"><input type="text" name="post_wall_widget['+widget_row+'][sort_order]" class="form-control" value="" size="3"></td>';
	html += '<td><a onclick="$(\'#widget-row'+widget_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#widget tbody').append(html);
	
	widget_row++;
	
}
</script>