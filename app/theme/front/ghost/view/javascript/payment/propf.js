<script>
$('#button-confirm').click(function(){
	$.ajax({
		url:'payment/propf/send',
		type:'post',
		data:$('#payment :input'),
		dataType:'json',		
		beforeSend:function(){
			$('#button-confirm').prop('disabled',true);
			$('#payment').before('<div class="alert alert-warning"><i class="icon-loading"></i> <?= $lang_text_wait; ?></div>');
		},
		complete:function(){
			$('#button-confirm').prop('disabled',false);
			$('.alert').remove();
		},	
		success:function(json){
			if(json['error']){
				alert(json['error']);
			}
			if(json['success']){
				location=json['success'];
			}
		}
	});
});
</script>