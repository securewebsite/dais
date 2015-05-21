<script>
var customer_group=[];
<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?= $customer_group['customer_group_id']; ?>]=[];
	customer_group[<?= $customer_group['customer_group_id']; ?>]['company_id_display']=<?= $customer_group['company_id_display']; ?>;
	customer_group[<?= $customer_group['customer_group_id']; ?>]['company_id_required']=<?= $customer_group['company_id_required']; ?>;
	customer_group[<?= $customer_group['customer_group_id']; ?>]['tax_id_display']=<?= $customer_group['tax_id_display']; ?>;
	customer_group[<?= $customer_group['customer_group_id']; ?>]['tax_id_required']=<?= $customer_group['tax_id_required']; ?>;
<?php } ?>

$('#payment-address select[name="customer_group_id"]').change();

$('#button-guest').off().on('click',function(){
	$.ajax({
		url:'checkout/guest/validate',
		type:'post',
		data:$('#payment-address input[type="text"],#payment-address input[type="checkbox"]:checked,#payment-address select'),
		dataType:'json',
		success:function(json){
			$('#notification>.alert,.help-block.error').remove();
			$('.has-error').removeClass('has-error');
			
			if(json['redirect']){
				location=json['redirect'];
			} else if(json['error']){
				$('html,body').animate({scrollTop:$('#payment-address>.panel-collapse').offset().top-30},'slow');

				$.each(json['error'],function(key,val){
					if(key!='warning'){
						$('#payment-address [name^="'+key+'"]').after('<span class="help-block error">'+val+'</span>').closest('.form-group').addClass('has-error');
					}else{
						alertMessage('danger',json['error']['warning']);
					}
				});
			}else{
				<?php if ($shipping_required) { ?>	
				var shipping_address = $('#payment-address input[name="shipping_address"]:checked').val();
				
				if(shipping_address){
					$.ajax({
						url:'checkout/shipping_method',
						dataType:'html',
						success:function(html){
							$('#shipping-method .panel-collapse').html(html);
							$('#payment-address .panel-collapse').slideUp('fast');
							$('#shipping-method .panel-collapse').slideDown('fast');
							$('#payment-address .panel-heading a,#shipping-address .panel-heading a,#shipping-method .panel-heading a,#payment-method .panel-heading a').remove();
							$('#payment-address .panel-heading').append('<a class="close"><i class="fa fa-lg fa-angle-down"></i></a>');	
							$('#shipping-address .panel-heading').append('<a class="close"><i class="fa fa-lg fa-angle-down"></i></a>');	
							
							$.ajax({
								url:'checkout/guest_shipping',
								dataType:'html',
								success:function(html){
									$('#shipping-address .panel-collapse').html(html);
									PluginInput.init();
								}
							});
						}
					});
				}else{
					$.ajax({
						url:'checkout/guest_shipping',
						dataType:'html',
						success:function(html){
							$('#shipping-address .panel-collapse').html(html);
							$('#payment-address .panel-collapse').slideUp('fast');
							$('#shipping-address .panel-collapse').slideDown(500,function(){
								$('#guest-firstname').select();
								$(this).find('select[name="country_id"]').change();
							});
							$('#payment-address .panel-heading a,#shipping-address .panel-heading a,#shipping-method .panel-heading a,#payment-method .panel-heading a').remove();
							$('#payment-address .panel-heading').append('<a class="close"><i class="fa fa-lg fa-angle-down"></i></a>');	
							
							PluginInput.init();
						}
					});
				}
				<?php } else { ?>				
				$.ajax({
					url:'checkout/payment_method',
					dataType:'html',
					success:function(html){
						$('#payment-method .panel-collapse').html(html);
						$('#payment-address .panel-collapse').slideUp('fast');
						$('#payment-method .panel-collapse').slideDown('fast');
						$('#payment-address .panel-heading a,#payment-method .panel-heading a').remove();
						$('#payment-address .panel-heading').append('<a class="close"><i class="fa fa-lg fa-angle-down"></i></a>');
						
						PluginInput.init();
					}
				});	
				<?php } ?>
			}	 
		}
	});
});
</script>