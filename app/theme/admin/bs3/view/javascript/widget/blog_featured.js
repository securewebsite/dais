<script>
var mapped={};
$('input[name="post"]').typeahead({
	source:function(q,process){
		return $.getJSON('content/post/autocomplete/filter_name/'+encodeURIComponent(q),function(json){
			var data=[];
			$.each(json,function(i,item){
				mapped[item.name]=item.post_id;
				data.push(item.name);
			});
			process(data);
		});
	},
	updater:function(item){
		$('#featured-post'+mapped[item]).remove();
		$('#featured-post').prepend('<div class="list-group-item" id="featured-post'+mapped[item]+'">'+item+'<a class="label label-danger label-trash"><i class="fa fa-trash-o fa-lg"></i></a><input type="hidden" value="'+mapped[item]+'"></div>');
		
		data=$.map($('#featured-post input'),function(element){
			return $(element).val();
		});

		$('input[name="blog_featured_post"]').val(data.join());

		return null;
	}
}).select();

$(document).on('click','#featured-post .label-trash',function(){
	$(this).parent().remove();

	data=$.map($('#featured-post input'),function(el){
		return $(el).val();
	});

	$('input[name="blog_featured_post"]').val(data.join());
});

function addWidget(){	
	html = '<tr id="widget-row'+widget_row+'">';
	html += '<td><input type="text" name="blog_featured_widget['+widget_row+'][limit]" value="5" class="form-control"></td>';
	html += '<td><input type="text" name="blog_featured_widget['+widget_row+'][image_width]" value="80" class="form-control"> <input type="text" name="blog_featured_widget['+widget_row+'][image_height]" value="80" class="form-control"></td>';
	html += '<td><select name="blog_featured_widget['+widget_row+'][layout_id]" class="form-control">';
	<?php foreach ($layouts as $layout) { ?>
	html += '<option value="<?= $layout['layout_id']; ?>"><?= addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '<td><select name="blog_featured_widget['+widget_row+'][position]" class="form-control">';
	html += '<option value="content_top"><?= $lang_text_content_top; ?></option>';
	html += '<option value="content_bottom"><?= $lang_text_content_bottom; ?></option>';
	html += '<option value="post_header"><?= $lang_text_post_header; ?></option>';
	html += '<option value="pre_footer"><?= $lang_text_pre_footer; ?></option>';
	html += '<option value="column_left"><?= $lang_text_column_left; ?></option>';
	html += '<option value="column_right"><?= $lang_text_column_right; ?></option>';
	html += '</select></td>';
	html += '<td><div class="btn-group" data-toggle="buttons">';
	html += '<label class="btn btn-default active" title="<?= $lang_text_enabled; ?>"><input type="radio" name="blog_featured_widget['+widget_row+'][status]" value="1" checked=""><i class="fa fa-play"></i></label>';
	html += '<label class="btn btn-default" title="<?= $lang_text_disabled; ?>"><input type="radio" name="blog_featured_widget['+widget_row+'][status]" value="0"><i class="fa fa-pause"></i></label>';
	html += '</div></td>';
	html += '<td class="text-right"><input type="text" name="blog_featured_widget['+widget_row+'][sort_order]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#widget-row'+widget_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#widget tbody').append(html);
	
	widget_row++;
}
</script>