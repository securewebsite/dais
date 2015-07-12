<script>
function addGeoZone(){
	html = '<tr id="zone-to-geo-zone-row'+zone_to_geo_zone_row+'">';
	html += '<td><select name="zone_to_geo_zone['+zone_to_geo_zone_row+'][country_id]" id="country'+zone_to_geo_zone_row+'" onchange="$(\'#zone'+zone_to_geo_zone_row+'\').load(\'index.php?route=locale/geo_zone/zone&token=<?= $token; ?>&country_id=\'+this.value+\'&zone_id=0\');" class="form-control">';
	<?php foreach ($countries as $country) { ?>
	html += '<option value="<?= $country['country_id']; ?>"><?= addslashes($country['name']); ?></option>';
	<?php } ?>	
	html += '</select></td>';
	html += '<td><select name="zone_to_geo_zone['+zone_to_geo_zone_row+'][zone_id]" id="zone'+zone_to_geo_zone_row+'" class="form-control"></select></td>';
	html += '<td><a onclick="$(\'#zone-to-geo-zone-row'+zone_to_geo_zone_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#zone-to-geo-zone > tbody').append(html);
		
	$('#zone'+zone_to_geo_zone_row).load('index.php?route=locale/geo_zone/zone&token=<?= $token; ?>&country_id='+$('#country'+zone_to_geo_zone_row).val()+'&zone_id=0');
	
	zone_to_geo_zone_row++;
}
</script>