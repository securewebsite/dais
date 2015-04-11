<script>
$('#button-confirm').click(function(){
	$.ajax({
		type:'get',
		url:'payment/freecheckout/confirm',
		success:function(){
			location='<?= $continue; ?>';
		}		
	});
});
</script>