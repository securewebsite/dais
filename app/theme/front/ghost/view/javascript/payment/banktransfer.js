<script>
$('#button-confirm').click(function(){
	$.ajax({
		type:'get',
		url:'payment/banktransfer/confirm',
		success:function(){
			location='<?= $continue; ?>';
		}		
	});
});
</script>
