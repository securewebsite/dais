<script>
function addLink(){
	html = '<tr id="item-row'+item_row+'">';
	html += '<td><input type="text" name="menu_item['+item_row+'][href]" value="" class="form-control"></td>';
	html += '<td><input type="text" name="menu_item['+item_row+'][name]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#item-row'+item_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#custom > tbody').append(html);
	
	item_row++;
}
</script>