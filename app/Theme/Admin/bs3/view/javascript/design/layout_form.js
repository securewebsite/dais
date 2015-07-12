<script>
function addRoute(){
	html = '<tr id="route-row'+route_row+'">';
	html += '<td><select name="layout_route['+route_row+'][store_id]" class="form-control">';
	html += '<option value="0"><?= $lang_text_default; ?></option>';
	<?php foreach ($stores as $store) { ?>
	html += '<option value="<?= $store['store_id']; ?>"><?= addslashes($store['name']); ?></option>';
	<?php } ?>	
	html += '</select></td>';
	html += '<td><input type="text" name="layout_route['+route_row+'][route]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#route-row'+route_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#route > tbody').append(html);
	
	route_row++;
}
</script>