<script>
function addFilter(){
	html = '<tr id="filter-row'+filter_row+'">';
	html += '<td><input type="hidden" name="filter['+filter_row+'][filter_id]" value="">';
	<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><input type="text" name="filter['+filter_row+'][filter_description][<?= $language['language_id']; ?>][name]" value="" class="form-control"> <span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>" class="form-control"></i></span></div>';
	<?php } ?>
	html += '</td>';
	html += '<td class="text-right"><input type="text" name="filter['+filter_row+'][sort_order]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#filter-row'+filter_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#filter tbody').append(html);
	
	$('#filter-row'+filter_row+' input[type="text"]:first').select();
	filter_row++;
}
</script>