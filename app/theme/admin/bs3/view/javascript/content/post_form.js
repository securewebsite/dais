<script>
function addImage(){
	html = '<tr id="image-row'+image_row+'">';
	html += '<td><div class="media"><a class="pull-left" onclick="image_upload(\'image'+image_row+'\',\'thumb'+image_row+'\');"><img class="img-thumbnail" src="<?= $no_image; ?>" width="100" height="100" alt="" id="thumb'+image_row+'"></a>';
	html += '<input type="hidden" name="post_image['+image_row+'][image]" value="" id="image'+image_row+'">';
	html += '<div class="media-body hidden-xs">';
	html += '<a class="btn btn-default" onclick="image_upload(\'image'+image_row+'\',\'thumb'+image_row+'\');"><?= $lang_text_browse; ?></a>&nbsp;';
	html += '<a class="btn btn-default" onclick="$(\'#thumb'+image_row+'\').attr(\'src\',\'<?= $no_image; ?>\'); $(\'#image'+image_row+'\').attr(\'value\',\'\');"><?= $lang_text_clear; ?></a>';
	html += '</div></div></td>';
	html += '<td class="text-right"><input type="text" name="post_image['+image_row+'][sort_order]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#image-row'+image_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#images tbody').append(html);
	
	image_row++;
}

var mapped={};
<?php if ($posted_by == 'user_name'): ?>
	var filter_name = 'filter_user_name';
<?php else: ?>
	var filter_name = 'filter_name';
<?php endif; ?>
$('input[name="author"]').typeahead({
	source:function(q,process){
		return $.getJSON('index.php?route=content/post/autoauthor&token='+token+'&'+filter_name+'='+encodeURIComponent(q),function(json){
			var data=[];
			$.each(json,function(i,item){
				<?php if ($posted_by == 'user_name'): ?>
				mapped[item.user_name]=item;
				data.push(item.user_name);
				<?php else: ?>
				mapped[item.name]=item;
				data.push(item.name);
				<?php endif; ?>
			});
			process(data);
		});
	},
	updater:function(item){
		<?php if ($posted_by == 'user_name'): ?>
		$('input[name="author"]').val(mapped[item].user_name);
		<?php else: ?>
		$('input[name="author"]').val(mapped[item].name);
		<?php endif; ?>
		return item;
	}
}).click(function(){
	this.select();
});

</script>