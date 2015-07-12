<script>
function addRoute(){
	html = '<tr id="route-row'+route_row+'">';
	html += '<td><input type="text" name="custom_route['+route_row+'][route]" value="" class="form-control"></td>';
	html += '<td><input type="text" name="custom_route['+route_row+'][slug]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#route-row'+route_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#route > tbody').append(html);
	
	route_row++;
}
</script>