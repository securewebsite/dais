<script>
function addImage(){
	html = '<tr id="image-row'+image_row+'">';
	html += '<td>';
	<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><input type="text" name="banner_image['+image_row+'][banner_image_description][<?= $language['language_id']; ?>][title]" value="" class="form-control"> <span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>" class="form-control"></i></span></div>';
	<?php } ?>
	html += '</td>';
	html += '<td><input type="text" name="banner_image['+image_row+'][link]" value="" class="form-control"></td>';
	html += '<td><div class="media"><a class="pull-left" onclick="image_upload(\'image'+image_row+'\',\'thumb'+image_row+'\');"><img class="img-thumbnail" src="<?= $no_image; ?>" width="100" height="100" alt="" id="thumb'+image_row+'"></a>';
	html += '<input type="hidden" name="banner_image['+image_row+'][image]" value="" id="image'+image_row+'">';
	html += '<div class="media-body hidden-xs">';
	html += '<a class="btn btn-default" onclick="image_upload(\'image'+image_row+'\',\'thumb'+image_row+'\');"><?= $lang_text_browse; ?></a>&nbsp;';
	html += '<a class="btn btn-default" onclick="$(\'#thumb'+image_row+'\').attr(\'src\',\'<?= $no_image; ?>\'); $(\'#image'+image_row+'\').attr(\'value\',\'\');"><?= $lang_text_clear; ?></a>';
	html += '</div></div></td>';
	html += '<td><a onclick="$(\'#image-row'+image_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#images tbody').append(html);
	
	$('#image-row'+image_row+' input[type="text"]:first').select();
	
	image_row++;
}
</script>