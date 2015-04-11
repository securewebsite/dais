<script>
$(document).on('click','#button-quote',function(e){
	var $btn=$(this);
	$.ajax({
		url:'checkout/cart/quote',
		type:'post',
		data:$('#form-shipping').serialize(),
		dataType:'json',
		success:function(json){
			$('.help-block.error').remove();
			$('.has-error').removeClass('has-error');
			if(json['error']){
				if(json['error']['warning']){
					alertMessage('danger',json['error']['warning']);
				}
				if(json['error']['country']){
					$('select[name="country_id"]').after('<span class="help-block error">'+json['error']['country']+'</span>').closest('.form-group').addClass('has-error');
				}
				if(json['error']['zone']){
					$('select[name="zone_id"]').after('<span class="help-block error">'+json['error']['zone']+'</span>').closest('.form-group').addClass('has-error');
				}
				if(json['error']['postcode']){
					$('input[name="postcode"]').after('<span class="help-block error">'+json['error']['postcode']+'</span>').closest('.form-group').addClass('has-error');
				}					
			}
			if(json['shipping_method']){
				html='';
				for(i in json['shipping_method']){
					html+='<thead>';
					html+='<tr>';
					html+='<th colspan="2">'+json['shipping_method'][i]['title']+'</th>';
					html+='</tr>';
					html+='</thead>';

					if(!json['shipping_method'][i]['error']){
						for(j in json['shipping_method'][i]['quote']){
							html+='<tr>';
							html+='<td><div class="radio"><label>';
							html+='<input type="radio" name="shipping_method" value="'+json['shipping_method'][i]['quote'][j]['code']+'" id="'+json['shipping_method'][i]['quote'][j]['code']+'"';
							if(json['shipping_method'][i]['quote'][j]['code']=='<?= $shipping_method; ?>')html+=' checked=""';
							html+='>';
							html+=json['shipping_method'][i]['quote'][j]['title']+'</label></div></td>';
							html+='<td class="text-right">'+json['shipping_method'][i]['quote'][j]['text']+'</td>';
							html+='</tr>';
						}	
					}else{
						html+='<tr><td colspan="2"><div class="text-danger">'+json['shipping_method'][i]['error']+'</div></td></tr>';					
					}
				}
				$('#modal-table').append(html);
				$('#modal').modal('show');
				$('input[name="shipping_method"]').change(function(){
					$('#button-shipping').removeAttr('disabled');
				});
			}
			
			PluginInput.init();	
		}
	});
});
</script>