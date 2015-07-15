<script>
function addAttribute(){
	html =  '<tr id="attribute-row'+attribute_row+'">';
	html += '<td><input type="text" name="product_attribute['+attribute_row+'][name]" value="" class="form-control"><input type="hidden" name="product_attribute['+attribute_row+'][attribute_id]" value="" class="form-control"></td>';
	html += '<td>';
	<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><textarea name="product_attribute['+attribute_row+'][product_attribute_description][<?= $language['language_id']; ?>][text]" class="form-control" rows="3"></textarea><span class="input-group-addon"><i class="lang-<?= str_replace('.png','', $language['image']); ?>" title="<?= $language['name']; ?>"></i></span></div>';
	<?php } ?>
	html += '</td>';
	html += '<td><a onclick="$(\'#attribute-row'+attribute_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#attribute tbody').append(html);
	
	attributeautocomplete(attribute_row);
	
	$('input[name="product_attribute['+attribute_row+'][name]"]').select();
	
	attribute_row++;
}

var a=$('input[name="option"]'),mapped={};
a.typeahead({
	source:function(q,process){
		return $.getJSON('index.php?route=catalog/option/autocomplete&token=<?= $token; ?>&filter_name='+encodeURIComponent(q),function(json){
			var data=[];
			$.each(json,function(i,item){
				mapped[item.name]=item;
				data.push(item.name);
			});
			process(data);
		});
	},
	updater:function(item){
		html =  '<div id="tab-option-'+option_row+'" class="tab-pane">';
		html += '<input type="hidden" name="product_option['+option_row+'][product_option_id]" value="">';
		html += '<input type="hidden" name="product_option['+option_row+'][name]" value="'+item+'">';
		html += '<input type="hidden" name="product_option['+option_row+'][option_id]" value="'+mapped[item].option_id+'">';
		html += '<input type="hidden" name="product_option['+option_row+'][type]" value="'+mapped[item].type+'">';
		html += '<div class="form-group">';
		html += '<label class="control-label col-sm-2"><?= $lang_entry_required; ?></label>';
		html += '<div class="control-field col-sm-4">';
		html += '<select name="product_option['+option_row+'][required]" class="form-control">';
		html += '<option value="1"><?= $lang_text_yes; ?></option>';
		html += '<option value="0"><?= $lang_text_no; ?></option>';
		html += '</select>';
		html += '</div>';
		html += '</div>';
			
		if(mapped[item].type=='text'){
			html += '<div class="form-group">';
			html += '<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>';
			html += '<div class="control-field col-sm-4"><input type="text" name="product_option['+option_row+'][option_value]" value="" class="form-control" class="form-control"></div>';
			html += '</div>';
		}else if(mapped[item].type=='textarea'){
			html += '<div class="form-group">';
			html += '<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>';
			html += '<div class="control-field col-sm-4"><textarea name="product_option['+option_row+'][option_value]" class="form-control" rows="3"></textarea></div>';
			html += '</div>';	
		}else if(mapped[item].type=='file'){
			html += '<div class="form-group" style="display:none;">';
			html += '<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>';
			html += '<div class="control-field col-sm-4"><input type="text" name="product_option['+option_row+'][option_value]" value="" class="form-control" class="form-control"></div>';
			html += '</div>';
		}else if(mapped[item].type=='date'){
			html += '<div class="form-group">';
			html += '<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>';
			html += '<div class="control-field col-sm-4"><label class="input-group">';
			html += '<input type="text" class="form-control date" name="product_option['+option_row+'][option_value]" value="">';
			html += '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>';
			html += '</label></div>';
		}else if(mapped[item].type=='datetime'){
			html += '<div class="form-group">';
			html += '<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>';
			html += '<div class="control-field col-sm-4"><label class="input-group">';
			html += '<input type="text" class="form-control datetime" name="product_option['+option_row+'][option_value]" value="" autocomplete="off">';
			html += '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>';
			html += '</label></div>';
		}else if(mapped[item].type=='time'){
			html += '<div class="form-group">';
			html += '<label class="control-label col-sm-2"><?= $lang_entry_option_value; ?></label>';
			html += '<div class="control-field col-sm-4"><label class="input-group">';
			html += '<input type="text" class="form-control time" name="product_option['+option_row+'][option_value]" value="" autocomplete="off">';
			html += '<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>';
			html += '</label></div>';
		}else if(mapped[item].type=='select'||mapped[item].type=='radio'||mapped[item].type=='checkbox'||mapped[item].type=='image'){
			html += '<div class="table-responsive">'; 
			html += '<table id="option-value'+option_row+'" class="table table-bordered table-striped">';
			html += '<thead>'; 
			html += '<tr>';
			html += '<th><?= $lang_entry_option_value; ?></th>';
			html += '<th class="text-right"><?= $lang_entry_quantity; ?></th>';
			html += '<th><?= $lang_entry_subtract; ?></th>';
			html += '<th class="text-right"><?= $lang_entry_price; ?></th>';
			html += '<th class="text-right"><?= $lang_entry_option_points; ?></th>';
			html += '<th class="text-right"><?= $lang_entry_weight; ?></th>';
			html += '<th></th>';
			html += '</tr>';
			html += '</thead>';
			html += '<tbody></tbody>';
			html += '<tfoot>';
			html += '<tr>';
			html += '<td colspan="6"></td>';
			html += '<td><a onclick="addOptionValue(\''+option_row+'\');" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= $lang_button_add_option_value; ?></a></td>';
			html += '</tr>';
			html += '</tfoot>';
			html += '</table>';
			html += '</div>';
			html += '<select id="option-values'+option_row+'" style="display:none;">';

			for(i=0;i<mapped[item].option_value.length;i++){
				html += '<option value="'+mapped[item].option_value[i]['option_value_id']+'">'+mapped[item].option_value[i]['name']+'</option>';
			}

			html += '</select>';
		}
		
		html += '</div>';
		
		$('#option-container').append(html);

		$('#option-add').before('<li><a href="#tab-option-'+option_row+'" id="option-'+option_row+'" data-toggle="tab"><span class="label label-danger" onclick="$(\'#vtab-option a:first\').trigger(\'click\'); $(\'#option-'+option_row+'\').remove();$(\'#tab-option-'+option_row+'\').remove();return false;"><i class="fa fa-trash-o"></i></span>'+item+'</a></li>');

		$('#option-'+option_row).click();

		option_row++;

		return '';
	}
});

var mapped={};
$('input[name="customer"]').typeahead({
	source:function(q,process){
		return $.getJSON('index.php?route=catalog/product/autouser&token='+token+'&name='+encodeURIComponent(q),function(json){
			var data=[];
			$.each(json,function(i,item){
				mapped[item.name]=item;
				data.push(item.name);
			});
			process(data);
		});
	},
	updater:function(item){
		$('input[name="customer_id"]').val(mapped[item].customer_id);
		$('input[name="customer"]').val(mapped[item].name);
		return item;
	}
}).click(function(){
	this.select();
});

$(document).on('click', '#clear-customer-btn', function(){
	$('input[name="customer_id"]').val('0');
	$('input[name="customer"]').val('');
});

function addOptionValue(option_row){
	html =  '<tr id="option-value-row'+option_value_row+'">';
	html += '<td><select name="product_option['+option_row+'][product_option_value]['+option_value_row+'][option_value_id]" class="form-control">';
	html += $('#option-values'+option_row).html();
	html += '</select><input type="hidden" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][product_option_value_id]" value=""></td>';
	html += '<td class="text-right"><input type="text" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][quantity]" value="" class="form-control"></td>'; 
	html += '<td><select name="product_option['+option_row+'][product_option_value]['+option_value_row+'][subtract]" class="form-control"><option value="1"><?= $lang_text_yes; ?></option><option value="0"><?= $lang_text_no; ?></option></select></td>';
	html += '<td class="text-right"><div class="input-group"><span class="input-group-btn" data-toggle="buttons"><label class="btn btn-default active"><input type="radio" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][price_prefix]" value="+" checked=""><i class="fa fa-plus"></i></label><label class="btn btn-default"><input type="radio" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][price_prefix]" value="-"><i class="fa fa-minus"></i></label></span><input type="text" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][price]" value="" class="form-control"></div></td>';
	html += '<td class="text-right"><div class="input-group"><span class="input-group-btn" data-toggle="buttons"><label class="btn btn-default active"><input type="radio" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][points_prefix]" value="+" checked=""><i class="fa fa-plus"></i></label><label class="btn btn-default"><input type="radio" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][points_prefix]" value="-"><i class="fa fa-minus"></i></label></span><input type="text" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][points]" value="" class="form-control"></div></td>';
	html += '<td class="text-right"><div class="input-group"><span class="input-group-btn" data-toggle="buttons"><label class="btn btn-default active"><input type="radio" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][weight_prefix]" value="+" checked=""><i class="fa fa-plus"></i></label><label class="btn btn-default"><input type="radio" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][weight_prefix]" value="-"><i class="fa fa-minus"></i></label></span><input type="text" name="product_option['+option_row+'][product_option_value]['+option_value_row+'][weight]" value="" class="form-control"></div></td>';
	html += '<td><a onclick="$(\'#option-value-row'+option_value_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#option-value'+option_row+' tbody').append(html);

	option_value_row++;
}

function addDiscount(){
	html =  '<tr id="discount-row'+discount_row+'">';
	html += '<td><select name="product_discount['+discount_row+'][customer_group_id]" class="form-control">';
	<?php foreach ($customer_groups as $customer_group) { ?>
	html += '<option value="<?= $customer_group['customer_group_id']; ?>"><?= addslashes($customer_group['name']); ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '<td class="text-right"><input type="text" name="product_discount['+discount_row+'][quantity]" value="" class="form-control"></td>';
	html += '<td class="text-right"><input type="text" name="product_discount['+discount_row+'][priority]" value="" class="form-control"></td>';
	html += '<td class="text-right"><input type="text" name="product_discount['+discount_row+'][price]" value="" class="form-control"></td>';
	html += '<td><label class="input-group"><input type="text" name="product_discount['+discount_row+'][date_start]" value="" class="form-control date" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></label></td>';
	html += '<td><label class="input-group"><input type="text" name="product_discount['+discount_row+'][date_end]" value="" class="form-control date" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></label></td>';
	html += '<td><a onclick="$(\'#discount-row'+discount_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#discount tbody').append(html);

	discount_row++;
}

function addSpecial(){
	html =  '<tr id="special-row'+special_row+'">';
	html += '<td><select name="product_special['+special_row+'][customer_group_id]" class="form-control">';
	<?php foreach ($customer_groups as $customer_group) { ?>
	html += '<option value="<?= $customer_group['customer_group_id']; ?>"><?= addslashes($customer_group['name']); ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '<td class="text-right"><input type="text" name="product_special['+special_row+'][priority]" value="" class="form-control"></td>';
	html += '<td class="text-right"><input type="text" name="product_special['+special_row+'][price]" value="" class="form-control"></td>';
	html += '<td><label class="input-group"><input type="text" name="product_special['+special_row+'][date_start]" value="" class="form-control date" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></label></td>';
	html += '<td><label class="input-group"><input type="text" name="product_special['+special_row+'][date_end]" value="" class="form-control date" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></label></td>';
	html += '<td><a onclick="$(\'#special-row'+special_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#special tbody').append(html);

	special_row++;
}

function addImage(){
	html =  '<tr id="image-row'+image_row+'">';
	html += '<td><div class="media"><a class="pull-left" onclick="image_upload(\'image'+image_row+'\',\'thumb'+image_row+'\');"><img class="img-thumbnail" src="<?= $no_image; ?>" width="100" height="100" alt="" id="thumb'+image_row+'"></a>';
	html += '<input type="hidden" name="product_image['+image_row+'][image]" value="" id="image'+image_row+'">';
	html += '<div class="media-body hidden-xs">';
	html += '<a class="btn btn-default" onclick="image_upload(\'image'+image_row+'\',\'thumb'+image_row+'\');"><?= $lang_text_browse; ?></a>&nbsp;';
	html += '<a class="btn btn-default" onclick="$(\'#thumb'+image_row+'\').attr(\'src\',\'<?= $no_image; ?>\'); $(\'#image'+image_row+'\').attr(\'value\',\'\');"><?= $lang_text_clear; ?></a>';
	html += '</div></div></td>';
	html += '<td class="text-right"><input type="text" name="product_image['+image_row+'][sort_order]" value="" class="form-control"></td>';
	html += '<td><a onclick="$(\'#image-row'+image_row+'\').remove();" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a></td>';
	html += '</tr>';
	
	$('#images tbody').append(html);
	
	image_row++;
}

function addRecurring() {
	html =  '<tr id="recurring-row' + recurring_row + '">';
	html += '<td class="text-left">';
	html += '<select name="product_recurrings[' + recurring_row + '][recurring_id]" class="form-control">';
	<?php foreach ($recurrings as $recurring): ?>
	html += '<option value="<?= $recurring['recurring_id']; ?>"><?= $recurring['name']; ?></option>';
	<?php endforeach; ?>
	html += '</select>';
	html += '</td>';
	html += '<td class="text-left">';
	html += '<select name="product_recurrings[' + recurring_row + '][customer_group_id]" class="form-control">';
	<?php foreach ($customer_groups as $customer_group): ?>
	html += '<option value="<?= $customer_group['customer_group_id']; ?>"><?= $customer_group['name']; ?></option>';
	<?php endforeach; ?>
	html += '<select>';
	html += '</td>';
	html += '<td class="text-left">';
	html += '<a onclick="$(\'#recurring-row' + recurring_row + '\').remove()" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i><span class="hidden-xs"> <?= $lang_button_remove; ?></span></a>';
	html += '</td>';
	html += '</tr>';
	
	$('#recurring tbody').append(html);

	recurring_row++;
}

<?php foreach($languages as $language): ?>

$('#meta-description<?= $language["language_id"]; ?>').bind('click', function(e) {
	e.preventDefault();
	$data = $('textarea[name="product_description[<?= $language["language_id"]; ?>][description]"]').code();
	$.ajax({
		url: 'index.php?route=catalog/product/description&token=<?= $token; ?>',
		type: 'post',
		dataType: 'json',
		data: {
			description: $data
		},
		success: function (json) {
			if (json['success']) {
				$('textarea[name="product_description[<?= $language["language_id"]; ?>][meta_description]"]').html(json['success']);
			}
		} 
	});
});

$('#meta-keyword<?= $language["language_id"]; ?>').bind('click', function(e) {
	e.preventDefault();
	$data = $('textarea[name="product_description[<?= $language["language_id"]; ?>][description]"]').code();
	$.ajax({
		url: 'index.php?route=catalog/product/keyword&token=<?= $token; ?>',
		type: 'post',
		dataType: 'json',
		data: {
			keywords: $data
		},
		success: function (json) {
			if (json['success']) {
				$('textarea[name="product_description[<?= $language["language_id"]; ?>][meta_keyword]"]').html(json['success']);
			}
		} 
	});
});

<?php endforeach; ?>

</script>