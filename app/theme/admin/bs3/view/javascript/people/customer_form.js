<script>
function country(a,b,c){
	var $this=$('select[name="address['+b+'][country_id]"]');
	$.ajax({
		url:'index.php?route=people/customer/country&token=<?= $token; ?>&country_id='+a.value,
		dataType:'json',
		beforeSend:function(){
			$this.after($('<i>',{class:'icon-loading'}));
		},
		complete:function(){
			$('.icon-loading').remove();
		},
		success:function(json){
			if(json['postcode_required']=='1'){
				$('#postcode-required'+b).show();
			} else {
				$('#postcode-required'+b).hide();
			}
			
			html = '<option value=""><?= $lang_text_select; ?></option>';
			if((typeof(json['zone'])!='undefined')&&json['zone']!=''){
				for(i=0;i<json['zone'].length;i++){
					html += '<option value="'+json['zone'][i]['zone_id']+'"';
					if(json['zone'][i]['zone_id']==c){
						html += ' selected=""';
					}
					html += '>'+json['zone'][i]['name']+'</option>';
				}
			} else {
				html += '<option value="0"><?= $lang_text_none; ?></option>';
			}
			
			$('select[name="address['+b+'][zone_id]"]').html(html);
		}
	});
}

$('select[name$="[country_id]"]').change();

function groupToggle(){
	var customer_group = [];
	
<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?= $customer_group['customer_group_id']; ?>]=[];
	customer_group[<?= $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?= $customer_group['company_id_display']; ?>';
	customer_group[<?= $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?= $customer_group['tax_id_display']; ?>';
<?php } ?>
	var customer_group_id = $('select[name="customer_group_id"]').val();
	if(customer_group[customer_group_id]) {
		if(customer_group[customer_group_id]['company_id_display']==1){
			$('.company-id-display').show();
		} else {
			$('.company-id-display').hide();
		}
		if(customer_group[customer_group_id]['tax_id_display']==1){
			$('.tax-id-display').show();
		} else {
			$('.tax-id-display').hide();
		}
	}
}

groupToggle();

$('input[name="affiliate[payment_method]"]').change(function(){
	$('.payment').hide();
	$('#payment-' + this.value).show();
});

$('input[name="affiliate[payment_method]"]:checked').change();

$(document).on('click', '#address-button', function (e) {
	html = '<div class="tab-pane" id="tab-address-'+address_row+'">';
	html += '<input type="hidden" name="address['+address_row+'][address_id]" value="">';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_firstname; ?></label>';
	html += '<div class="control-field col-sm-4"><input type="text" name="address['+address_row+'][firstname]" value="" class="form-control" class="form-control"></div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_lastname; ?></label>';
	html += '<div class="control-field col-sm-4"><input type="text" name="address['+address_row+'][lastname]" value="" class="form-control" class="form-control"></div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><?= $lang_entry_company; ?></label>';
	html += '<div class="control-field col-sm-4"><input type="text" name="address['+address_row+'][company]" value="" class="form-control" class="form-control"></div>';
	html += '</div>';
	html += '<div class="form-group company-id-display">';
	html += '<label class="control-label col-sm-2"><?= $lang_entry_company_id; ?></label>';
	html += '<div class="control-field col-sm-4"><input type="text" name="address['+address_row+'][company_id]" value="" class="form-control" class="form-control"></div>';
	html += '</div>';
	html += '<div class="form-group tax-id-display">';
	html += '<label class="control-label col-sm-2"><?= $lang_entry_tax_id; ?></label>';
	html += '<div class="control-field col-sm-4"><input type="text" name="address['+address_row+'][tax_id]" value="" class="form-control" class="form-control"></div>';
	html += '</div>';		
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_address_1; ?></label>';
	html += '<div class="control-field col-sm-4"><input type="text" name="address['+address_row+'][address_1]" value="" class="form-control" class="form-control"></div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><?= $lang_entry_address_2; ?></label>';
	html += '<div class="control-field col-sm-4"><input type="text" name="address['+address_row+'][address_2]" value="" class="form-control" class="form-control"></div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_city; ?></label>';
	html += '<div class="control-field col-sm-4"><input type="text" name="address['+address_row+'][city]" value="" class="form-control" class="form-control"></div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><span id="postcode-required'+address_row+'" class="required">*</span> <?= $lang_entry_postcode; ?></label>';
	html += '<div class="control-field col-sm-4"><input type="text" name="address['+address_row+'][postcode]" value="" class="form-control" class="form-control"></div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_country; ?></label>';
	html += '<div class="control-field col-sm-4"><select name="address['+address_row+'][country_id]" onchange="country(this, \''+address_row+'\', \'0\');" class="form-control">';
	html += '<option value=""><?= $lang_text_select; ?></option>';
	<?php foreach ($countries as $country) { ?>
	html += '<option value="<?= $country['country_id']; ?>"><?= addslashes($country['name']); ?></option>';
	<?php } ?>
	html += '</select></div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2"><b class="required">*</b> <?= $lang_entry_zone; ?></label>';
	html += '<div class="control-field col-sm-4"><select name="address['+address_row+'][zone_id]" class="form-control"><option value="false"><?= $lang_text_none; ?></option></select></div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '<label class="control-label col-sm-2" for="default'+address_row+'"><?= $lang_entry_default; ?></label>';
	html += '<div class="control-field col-sm-4"><label class="radio-inline"><input type="radio" name="address['+address_row+'][default]" value="1" id="default'+address_row+'"></label></div>';
	html += '</div>';
	html += '</div>';
	
	$('#customer-content').append(html);
	
	$('select[name="address['+address_row+'][country_id]"]').change();
	
	$('#address-add').before('<li><a href="#tab-address-'+address_row+'" id="address-'+address_row+'" data-toggle="tab"><span class="label label-danger" onclick="$(\'#vtab-address a:first\').trigger(\'click\'); $(\'#address-'+address_row+'\').remove();$(\'#tab-address-'+address_row+'\').remove();return false;"><i class="fa fa-trash-o"></i></span> <?= $lang_tab_address; ?> '+address_row+'</a></li>');
	$('#address-'+address_row).trigger('click');
	
	groupToggle();
	
	address_row++;
});

$(document).on('click', '#button-reward', function(e){
	var btn=$(this);

	$.ajax({
		url:'index.php?route=people/customer/reward&token=<?= $token; ?>&customer_id=<?= $customer_id; ?>',
		type:'post',
		dataType:'html',
		data:'description='+encodeURIComponent($('#tab-reward input[name="description"]').val())+'&points='+encodeURIComponent($('#tab-reward input[name="points"]').val()),
		beforeSend:function(){
			btn.button('loading');
			btn.append($('<i>',{class:'icon-loading'}));
		},
		success:function(html){
			btn.button('reset');
			$('#reward').html(html);
			$('#tab-reward input[name="points"],#tab-reward input[name="description"]').val('');
		}
	});
});

function addBanIP(ip){
	var id = ip.replace(/\./g, '-');
	
	$.ajax({
		url:'index.php?route=people/customer/addbanip&token=<?= $token; ?>',
		type:'post',
		dataType:'json',
		data:'ip='+encodeURIComponent(ip),
		beforeSend:function(){
			alertMessage('warning','<?= $lang_text_wait; ?>');
		},
		success:function(json){
			if(json['error']){
				alertMessage('danger',json['error']);
			}
			if(json['success']){
				alertMessage('success',json['success']);
				$('#'+id).replaceWith('<a id="'+id+'" onclick="removeBanIP(\''+ip+'\');"><?= $lang_text_remove_ban_ip; ?></a>');
			}
		}
	});
}

function removeBanIP(ip) {
	var id = ip.replace(/\./g, '-');
	
	$.ajax({
		url:'index.php?route=people/customer/removebanip&token=<?= $token; ?>',
		type:'post',
		dataType:'json',
		data:'ip='+encodeURIComponent(ip),
		beforeSend:function(){
			alertMessage('warning','<?= $lang_text_wait; ?>');		
		},
		success:function(json){
			if(json['error']){
				alertMessage('danger',json['error']);
			}
			if(json['success']){
				alertMessage('success',json['success']);
				$('#'+id).replaceWith('<a id="'+id+'" onclick="addBanIP(\''+ip+'\');"><?= $lang_text_add_ban_ip; ?></a>');
			}
		}
	});
};
</script>