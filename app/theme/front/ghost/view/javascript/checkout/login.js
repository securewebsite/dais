<script>
$(document).on('click','#button-account',function(){
	$.ajax({
		url:'checkout/'+$('input[name="account"]:checked').val(),
		dataType:'html',
		success:function(html){
			$('#notification>.alert,.help-block.error').remove();
			$('.has-error').removeClass('has-error');
			
			$('#payment-address .panel-collapse').html(html);
			$('#checkout .panel-collapse').slideUp('fast');
			$('#payment-address .panel-collapse').slideDown('fast',function(){
				$(this).find('select[name="country_id"]').change();
			});
			$('.panel-heading a').remove();
			$('#checkout .panel-heading').append('<a class="close"><i class="fa fa-angle-down fa-lg"></i></a>');
			
			PluginInput.init();
		}
	});
});
$(document).on('click','#button-login',function(){
	$.ajax({
		url:'checkout/login/validate',
		type:'post',
		data:$('#form-login :input'),
		dataType:'json',
		success:function(json){
			$('#notification>.alert,.help-block.error').remove();
			$('.has-error').removeClass('has-error');
			
			if(json['redirect']){
				location=json['redirect'];
			} else if(json['error']){
				alertMessage('danger',json['error']['warning']);
			}
			
			PluginInput.init();
		}
	});	
});
</script>