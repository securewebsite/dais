<script>
$(document).on('change', '#checkout .panel-collapse input[name="account"]', function(){
	if($(this).attr('value')=='register'){
		$('#payment-address .panel-heading span').html('<?= $lang_text_checkout_account; ?>');
	}else{
		$('#payment-address .panel-heading span').html('<?= $lang_text_checkout_payment_address; ?>');
	}
});
<?php if (!$logged) { ?> 
$(document).ready(function(){
	<?php if (isset($quickconfirm)) { ?>
		quickConfirm();
	<?php } else { ?>
		$.ajax({
			url:'checkout/login',
			dataType:'html',
			success:function(html){
				$('#checkout .panel-collapse').html(html).slideDown('fast',function(){
					$(this).find('.form-control:first').select();
				});
				PluginInput.init();
			}
		});
	<?php } ?>
});
<?php } else { ?>
$(document).ready(function(){
	<?php if (isset($quickconfirm)) { ?>
		quickConfirm();
	<?php } else { ?>
		$.ajax({
			url:'checkout/payment_address',
			dataType:'html',
			success:function(html){
				$('#payment-address .panel-collapse').html(html);
				$('#payment-address .panel-collapse').slideDown('fast');
				PluginInput.init();
			}
		});
	<?php } ?>
});
<?php } ?>
$(document).on('click', '#button-register', function(){
	$.ajax({
		url:'checkout/register/validate',
		type:'post',
		data:$('#payment-address form').serialize(),
		dataType:'json',
		success:function(json){
			$('.warning, .error').remove();
			if (json['redirect']){
				location=json['redirect'];		
			} else if (json['error']){
				$('html,body').animate({scrollTop:$('#payment-address>.panel-collapse').offset().top-30},'slow');
			
				$.each(json['error'],function(key,val){
					if(key!='warning'){
						$('#payment-address [name^="'+key+'"]').after('<span class="help-block error">'+val+'</span>').closest('.form-group').addClass('has-error');
					}else{
						alertMessage('danger',json['error']['warning']);
					}
				});
				PluginInput.init();																													
			}else{
				<?php if ($shipping_required) { ?>				
				var shipping_address=$('#payment-address input[name=\'shipping_address\']:checked').attr('value');
				if (shipping_address) {
					$.ajax({
						url:'checkout/shipping_method',
						dataType:'html',
						success:function(html){
							$('#shipping-method .panel-collapse').html(html);
							$('#payment-address .panel-collapse').slideUp('fast');
							$('#shipping-method .panel-collapse').slideDown('fast');
							$('#checkout .panel-heading a').remove();
							$('#payment-address .panel-heading a').remove();
							$('#shipping-address .panel-heading a').remove();
							$('#shipping-method .panel-heading a').remove();
							$('#payment-method .panel-heading a').remove();									
							$('#shipping-address .panel-heading').append('<a class="close" title="<?= $lang_text_modify; ?>"><i class="fa fa-angle-down fa-lg"></i></a>');							
							$('#payment-address .panel-heading').append('<a class="close" title="<?= $lang_text_modify; ?>"><i class="fa fa-angle-down fa-lg"></i></a>');
							PluginInput.init();
							
							$.ajax({
								url:'checkout/shipping_address',
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
						url:'checkout/shipping_address',
						dataType:'html',
						success:function(html){
							$('#shipping-address .panel-collapse').html(html);
							$('#payment-address .panel-collapse').slideUp('fast');
							$('#shipping-address .panel-collapse').slideDown('fast');
							$('#checkout .panel-heading a').remove();
							$('#payment-address .panel-heading a').remove();
							$('#shipping-address .panel-heading a').remove();
							$('#shipping-method .panel-heading a').remove();
							$('#payment-method .panel-heading a').remove();					
							$('#payment-address .panel-heading').append('<a class="close" title="<?= $lang_text_modify; ?>"><i class="fa fa-angle-down fa-lg"></i></a>');
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
						$('#checkout .panel-heading a').remove();
						$('#payment-address .panel-heading a').remove();
						$('#payment-method .panel-heading a').remove();						
						$('#payment-address .panel-heading').append('<a class="close" title="<?= $lang_text_modify; ?>"><i class="fa fa-angle-down fa-lg"></i></a>');
						PluginInput.init();
					}
				});			
				<?php } ?>
				$.ajax({
					url:'checkout/payment_address',
					dataType:'html',
					success:function(html){
						$('#payment-address .panel-collapse').html(html);
						$('#payment-address .panel-heading span').html('<?= $lang_text_checkout_payment_address; ?>');
						
						PluginInput.init();
					}
				});
			} 
		}
	});
});
$(document).on('click','#button-payment-address',function(e){
	$.ajax({
		url:'checkout/payment_address/validate',
		type:'post',
		data:$('#payment-address form').serialize(),
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
				
				PluginInput.init();
			}else{
				<?php if ($shipping_required) { ?>
				$.ajax({
					url:'checkout/shipping_address',
					dataType:'html',
					success:function(html){
						$('#shipping-address .panel-collapse').html(html);
						$('#payment-address .panel-collapse').slideUp('fast');
						$('#shipping-address .panel-collapse').slideDown('fast');
						$('#payment-address .panel-heading a,#shipping-address .panel-heading a,#shipping-method .panel-heading a,#payment-method .panel-heading a').remove();
						$('#payment-address .panel-heading').append('<a class="close"><i class="fa fa-angle-down fa-lg"></i></a>');	
						
						PluginInput.init();
					}
				});
				<?php } else { ?>
				$.ajax({
					url:'checkout/payment_method',
					dataType:'html',
					success:function(html){
						$('#payment-method .panel-collapse').html(html);
						$('#payment-address .panel-collapse').slideUp('fast');
						$('#payment-method .panel-collapse').slideDown('fast');
						$('#payment-address .panel-heading a,#payment-method .panel-heading a').remove();
						$('#payment-address .panel-heading').append('<a class="close"><i class="fa fa-angle-down fa-lg"></i></a>');	
						
						PluginInput.init();
					}
				});
				<?php } ?>
				
				$.ajax({
					url:'checkout/payment_address',
					dataType:'html',
					success:function(html){
						$('#payment-address .panel-collapse').html(html);
						
						PluginInput.init();
					}
				});
			}		
		}
	});
});
$(document).on('click','#button-shipping-address',function(e){
	$.ajax({
		url:'checkout/shipping_address/validate',
		type:'post',
		data:$('#shipping-address form').serialize(),
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
					url:'checkout/shipping_method',
					dataType:'html',
					success:function(html){
						$('#shipping-method .panel-collapse').html(html);
						$('#shipping-address .panel-collapse').slideUp('fast');
						$('#shipping-method .panel-collapse').slideDown('fast');
						$('#shipping-address .panel-heading a,#shipping-method .panel-heading a,#payment-method .panel-heading a').remove();
						$('#shipping-address .panel-heading').append('<a class="close"><i class="fa fa-angle-down fa-lg"></i></a>');
						
						$.ajax({
							url:'checkout/shipping_address',
							dataType:'html',
							success:function(html){
								$('#shipping-address .panel-collapse').html(html);
								
								PluginInput.init();
							}
						});	
					}
				});
			}
		}
	});
});
$(document).on('click','#button-shipping-method',function(){
	$.ajax({
		url:'checkout/shipping_method/validate',
		type:'post',
		data:$('#shipping-method input[type="radio"]:checked, #shipping-method textarea'),
		dataType:'json',
		success:function(json){
			$('#notification>.alert,.help-block.error').remove();
			$('.has-error').removeClass('has-error');
			
			if(json['redirect']){
				location=json['redirect'];
			} else if(json['error']){
				$('html,body').animate({scrollTop:$('#shipping-method>.panel-collapse').offset().top-30},'slow');
				
				if(json['error']['warning']){
					alertMessage('danger',json['error']['warning']);
				}
			}else{
				$.ajax({
					url:'checkout/payment_method',
					dataType:'html',
					success:function(html){
						$('#payment-method .panel-collapse').html(html);
						$('#shipping-method .panel-collapse').slideUp('fast');
						$('#payment-method .panel-collapse').slideDown('fast');
						$('#shipping-method .panel-heading a,#payment-method .panel-heading a').remove();
						$('#shipping-method .panel-heading').append('<a class="close"><i class="fa fa-angle-down fa-lg"></i></a>');
						
						PluginInput.init();
					}
				});
			}
		}
	});
});
$(document).on('click','#button-payment-method',function(e){
	$.ajax({
		url:'checkout/payment_method/validate', 
		type:'post',
		data:$('#payment-method input[type="radio"]:checked, #payment-method input[type="checkbox"]:checked, #payment-method textarea'),
		dataType:'json',
		success:function(json){
			$('#notification>.alert,.help-block.error').remove();
			$('.has-error').removeClass('has-error');
			
			if(json['redirect']){
				location=json['redirect'];
			} else if(json['error']){
				if(json['error']['warning']){
					$('html,body').animate({scrollTop:$('#payment-method>.panel-collapse').offset().top-30},'slow');
					alertMessage('danger',json['error']['warning']);
				}
			}else{
				$.ajax({
					url:'checkout/confirm',
					dataType:'html',
					success:function(html){
						$('#confirm .panel-collapse').html(html);
						$('#payment-method .panel-collapse').slideUp('fast');
						$('#confirm .panel-collapse').slideDown('fast');
						$('#payment-method .panel-heading a').remove();
						$('#payment-method .panel-heading').append('<a class="close"><i class="fa fa-angle-down fa-lg"></i></a>');
					}
				});
			}
		}
	});
});

function quickConfirm(module){
	$.ajax({
		url:'checkout/confirm',
		dataType:'html',
		success:function(html){
			$('#confirm .panel-collapse').html(html);
			$('#confirm .panel-collapse').slideDown('fast');
			$('.panel-heading a').remove();
			$('#checkout .panel-heading a').remove();
			$('#checkout .panel-heading').append('<a class="close" title="<?= $lang_text_modify; ?>"><i class="fa fa-angle-down fa-lg"></i></a>');
			$('#shipping-address .panel-heading a').remove();
			$('#shipping-address .panel-heading').append('<a class="close" title="<?= $lang_text_modify; ?>"><i class="fa fa-angle-down fa-lg"></i></a>');
			$('#shipping-method .panel-heading a').remove();
			$('#shipping-method .panel-heading').append('<a class="close" title="<?= $lang_text_modify; ?>"><i class="fa fa-angle-down fa-lg"></i></a>');
			$('#payment-address .panel-heading a').remove();	
			$('#payment-address .panel-heading').append('<a class="close" title="<?= $lang_text_modify; ?>"><i class="fa fa-angle-down fa-lg"></i></a>');
			$('#payment-method .panel-heading a').remove();
			$('#payment-method .panel-heading').append('<a class="close" title="<?= $lang_text_modify; ?>"><i class="fa fa-angle-down fa-lg"></i></a>');
			
			PluginInput.init();
		}
	});
}
</script>