<script>
$(document).on('click','#button-guest-shipping',function(e){
	$.ajax({
		url:'checkout/guestshipping/validate',
		type:'post',
		data:$('#shipping-address input[type="text"], #shipping-address select'),
		dataType:'json',
		success:function(json){
			$('#notification>.alert,.help-block.error').remove();
			$('.has-error').removeClass('has-error');
			
			if(json['redirect']){
				location=json['redirect'];
			} else if(json['error']){
				$('html,body').animate({scrollTop:$('#shipping-address>.panel-collapse').offset().top-30},'slow');

				$.each(json['error'],function(key,val){
					if(key!='warning'){
						$('#shipping-address [name^="'+key+'"]').after('<span class="help-block error">'+val+'</span>').closest('.form-group').addClass('has-error');
					}else{
						alertMessage('danger',json['error']['warning']);
					}
				});
			}else{
				$.ajax({
					url:'checkout/shippingmethod',
					dataType:'html',
					success:function(html){
						$('#shipping-method .panel-collapse').html(html);
						$('#shipping-address .panel-collapse').slideUp('fast');
						$('#shipping-method .panel-collapse').slideDown('fast');
						$('#shipping-address .panel-heading a,#shipping-method .panel-heading a,#payment-method .panel-heading a').remove();
						$('#shipping-address .panel-heading').append('<a class="close"><i class="fa fa-angle-down fa-lg"></i></a>');
					}
				});	
			}	 
		}
	});
});
</script>