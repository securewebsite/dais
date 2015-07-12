<script>
$('select[name="type"]').change(function(){
	if (this.value=='select'||this.value=='radio'||this.value=='checkbox'||this.value=='image'){
		$('#option-value').show();
	} else {
		$('#option-value').hide();
	}
}).change();

function addOptionValue(){
	html = '<tr id="option-value-row'+option_value_row+'">';
	html += '<td><input type="hidden" name="option_value['+option_value_row+'][option_value_id]" value="">';
	<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><input type="text" name="option_value['+option_value_row+'][option_value_description][<?= $language['language_id']; ?>][name]" value="" class="form-control"> <span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>" class="form-control"></i></span></div>';
	<?php } ?>
	html += '</td>';
	html += '<td><div class="media">';
	html += '<a class="pull-left" onclick="image_upload(\'image'+option_value_row+'\',\'thumb'+option_value_row+'\');"><img class="img-thumbnail" src="<?= $no_image; ?>" width="100" height="100" alt="" id="thumb'+option_value_row+'"></a>';
	html += '<input type="hidden" name="option_value['+option_value_row+'][image]" value="" id="image'+option_value_row+'">';
	html += '<div class="media-body hidden-xs">';
	html += '<a class="btn btn-default" onclick="image_upload(\'image'+option_value_row+'\',\'thumb'+option_value_row+'\');"><?= $lang_text_browse; ?></a>&nbsp;';
	html += '<a class="btn btn-default" onclick="$(\'#thumb'+option_value_row+'\').attr(\'src\',\'<?= $no_image; ?>\'); $(\'#image'+option_value_row+'\').attr(\'value\',\'\');"><?= $lang_text_clear; ?></a>';
	html += '</div>';
	html += '</div></td>';
	html += '<td class="text-right"><input type="text" name="option_value['+option_value_row+'][sort_order]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#option-value-row'+option_value_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#option-value tbody').append(html);
	
	option_value_row++;
}
</script>