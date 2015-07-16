<script>
$('select[name="return_action_id"]').change(function(){
	var a=$(this);
	var value = a.val();
	$.ajax({
		url:'index.php?route=sale/returns/action&return_id=<?= $return_id; ?>',
		type:'post',
		dataType:'json',
		data:'return_action_id='+value,
		success:function(json){
			if(json['error']){
				alertMessage('danger',json['error']);
			}
			if(json['success']){
				alertMessage('success',json['success']);
			}
		}
	});
});
</script>