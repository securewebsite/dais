<script>
$(document).on('click','#button-confirm',function(){
	$.ajax({
		url:'payment/authorize_net/send',
		type:'post',
		data:$('#payment :input'),
		dataType:'json',
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